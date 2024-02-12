<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    const _ATTR = 'posts';

    const _TYPE_POST = 1;
    const _TYPE_HOME = 2;
    const _TYPE_CONTACT = 3;
    const _ARR_TYPE = [
        self::_TYPE_POST,
        self::_TYPE_HOME,
        self::_TYPE_CONTACT,
    ];

    public static function getArrayPage()
    {
        return [
            'vision-mission'    => __('validation.attributes.' . self::_ATTR . '-vision-mission'),
            'board-director'    => __('validation.attributes.' . self::_ATTR . '-board-director'),
            'core-value'        => __('validation.attributes.' . self::_ATTR . '-core-value'),
            'milestone'         => __('validation.attributes.' . self::_ATTR . '-milestone'),
        ];
    }

    private $_rules = [];

    protected $fillable = ['id', 'menu_id', 'category_id', 'title', 'slug', 'status', 'type', 'page'];

    protected $dates = ['deleted_at'];

    public function hash_key()
    {
        return $this->hasOne(HashKey::class, 'obj_id')->where('obj_type', HashKey::_OBJ_TYPE_POST);
    }

    public function banner()
    {
        return $this->hasOne(Banner::class, 'post_id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_POST);
    }

    public function media_vision_mission()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_POST_VISION_MISSION);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_POST);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_POST)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $attr = self::_ATTR . '-';

        $this->_rules = [
            $attr . 'title'             => 'required|string|max:150|noanytag',
            $attr . 'menu'              => 'required|exists:menus,id',
            $attr . 'short-content'     => 'nullable|string|max:3000|noanytag',
            $attr . 'content'           => 'nullable|string|max:10000|noscript',
            $attr . 'file'              => 'nullable|file|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) .'|mimes:'. implode(',', Media::$_type_files),
            $attr . 'type'              => 'required|in:' . implode(',', self::_ARR_TYPE),
            $attr . 'page'              => 'nullable',
            $attr . 'seo_title'         => 'nullable|string|max:150|noanytag',
            $attr . 'seo_description'   => 'nullable|string|max:1500|noanytag',
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        if ($params[$attr . 'type'] == self::_TYPE_HOME) {
            $this->_rules[$attr . 'menu']   = 'nullable';
            $params[$attr . 'menu']         = null;
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params)
    {
        $this->getCreateValidation($params);
        return $this->_rules;
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation($params) : $this->getCreateValidation($params));

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['not_have']) && !empty($params['not_have']))
            $data = (isset($params['except_id']) && !empty($params['except_id'])) ?
                $data->whereDoesntHave($params['not_have'], function ($query) use ($params) {
                    $query->where('post_id', '!=', $params['except_id']);
                }) : $data->doesntHave($params['not_have']);

        if (isset($params['type']) && !empty($params['type']))
            $data = $data->where('type', $params['type']);

        if (isset($params['menu']) || isset($params['menu_status']) || isset($params['menu_route_name']))
            $data = $data->whereHas('menu', function ($query) use ($params) {
                if (!empty($params['menu']))
                    $query->where('id', $params['menu']);

                if (!empty($params['menu_status']))
                    $query->where('status', $params['menu_status']);

                if (!empty($params['menu_route_name']))
                    $query->where('route_name', $params['menu_route_name']);
            });


        if (isset($params['category']) && !empty($params['category']))
            $data = $data->where('category_id', $params['category']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['title']) && !empty($params['title']))
            $data = $data->where('title', 'like', '%'. $params['title'] .'%');

        if (isset($params['slug']) && !empty($params['slug']))
            $data = $data->where('slug', 'like', '%'. $params['slug'] .'%');

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage > 0)
            $data = ($perPage === 1 || $perPage === '1') ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating(array $params, $id = null)
    {
        $attr = self::_ATTR . '-';

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'title_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'title'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'slug_' . $v,
                    'value' => ($v == $params['locale']) ? str_slug($params[$attr . 'title']) : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'short-content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'short-content'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'content'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'seo_title_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'seo_title'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_POST,
                    'field' => 'seo_description_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'seo_description'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'title_' . $params['locale'],
                'value' => $params[$attr . 'title'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'slug_' . $params['locale'],
                'value' => (isset($params[$attr . 'title'])) ? str_slug($params[$attr . 'title']) : null,
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'short-content_' . $params['locale'],
                'value' => $params[$attr . 'short-content'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'content_' . $params['locale'],
                'value' => $params[$attr . 'content'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'seo_title_' . $params['locale'],
                'value' => (isset($params[$attr . 'seo_title'])) ? $params[$attr . 'seo_title'] : null,
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POST,
                'field' => 'seo_description_' . $params['locale'],
                'value' => (isset($params[$attr . 'seo_description'])) ? $params[$attr . 'seo_description'] : null,
            ]);
        }

        if ($params[$attr . 'type'] == self::_TYPE_HOME) {
            $params[$attr . 'menu'] = null;
            $params[$attr . 'category'] = null;
        }

        $data = $this->newQuery()->find($id);

        $data->title = implode('; ', Datameta::query()
            ->where('data_id', $id)->whereNotNull('data_value')
            ->where('data_type', Datameta::TYPE_POST)->where('data_field', 'like', 'title_%')
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->slug = implode('; ', Datameta::query()
            ->where('data_id', $id)->whereNotNull('data_value')
            ->where('data_type', Datameta::TYPE_POST)->where('data_field', 'like', 'slug_%')
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->menu_id              = isset($params[$attr . 'menu']) ? $params[$attr . 'menu'] : null;
        $data->page                 = isset($params[$attr . 'page']) ? $params[$attr . 'page'] : null;
//        $data->is_milestone         = $params[$attr . 'milestone'];
//        $data->is_core_value        = $params[$attr . 'core-value'];
//        $data->is_board_director    = $params[$attr . 'board-director'];
//        $data->is_vision_mission    = $params[$attr . 'vision-mission'];
        $data->type                 = $params[$attr . 'type'];
        $data->status               = $params['status'];
        $data->save();

        $menu = $data->menu()->where('status', Constant::STATUS_ACTIVE)->first();

        if (!empty($menu) && str_contains($menu->datameta(env('APP_LOCALE'), 'slug')->data_value, ['about', 'about-us', 'about-stavian']) && empty($data->hash_key)) {
            HashKey::doUpdatingOrCreating([
                'type'  => HashKey::_OBJ_TYPE_POST,
                'code'  => rand(),
                'id'    => $id,
            ]);
        }

        return $id;
    }

    public static function getList($action = null)
    {
        $list = new self();

        $params['status']       = Constant::STATUS_ACTIVE;
        $params['menu']         = isset($action['menu']) ? $action['menu'] : null;
        $params['menu_status']  = isset($action['menu_status']) ? $action['menu_status'] : null;
        $params['except_id']    = isset($action['except_id']) ? $action['except_id'] : null;
        $params['not_have']     = isset($action['not_have']) ? $action['not_have'] : null;
        $params['ordering']     = isset($action['ordering']) ? $action['ordering'] : ['created_at' => 'asc'];
        $params['menu_route_name']  = isset($action['menu_route_name']) ? $action['menu_route_name'] : null;

        $list = $list->filter(0, $params);

        $arr = [];

        if (!empty($list)) {
            if (isset($action['pluck']))
                $arr = ($action['pluck'] == 'id') ? $list->pluck($action['pluck'])->toArray() : $list->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($list as $item)
                    $arr[] = ['id' => $item->id, 'name' => optional($item->datameta('', 'title'))->data_value];
            else
                foreach ($list as $item)
                    $arr[$item->id] = optional($item->datameta('', 'title'))->data_value;
        }

        return $arr;
    }
}
