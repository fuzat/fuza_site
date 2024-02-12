<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    const _ATTR = 'businesses';

    private $_rules = [];

    protected $fillable = ['id', 'menu_id', 'name', 'slug', 'status', 'show_home', 'all_products_url'];

    protected $dates = ['deleted_at'];

    public function hash_key()
    {
        return $this->hasOne(HashKey::class, 'obj_id')->where('obj_type', HashKey::_OBJ_TYPE_BUSINESS);
    }

    public function avatar()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_AVATAR);
    }

    public function icon()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_ICON);
    }

    public function icon_act()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_ICON_ACT);
    }

    public function file()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_IMAGE);
    }

    public function file_home()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_IMAGE_HOME);
    }

    public function products_background()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BUSINESS_PRODUCTS_BACKGROUND);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_BUSINESS);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_BUSINESS)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params, $id)
    {
        $attr = self::_ATTR . '-';
        $max_size = Media::_MAX_FILE_SIZE_AVATAR * 1024;
        $type_image = implode(',', Media::$_type_image);

        $this->_rules = [
            $attr . 'name'      => 'required|string|max:70|noanytag',
            $attr . 'avatar'    => 'required|image|max:' . $max_size . '|mimes:' . $type_image,
            $attr . 'file'      => 'required|image|max:' . $max_size . '|mimes:' . $type_image,
            $attr . 'short-desc'            => 'nullable|string|max:1500',
            $attr . 'content'               => 'required|string|max:2500|noscript',
            $attr . 'scale-operation'       => 'required|string|max:1100|noscript',
            $attr . 'development-strategy'  => 'nullable|string|max:1100|noscript',
            $attr . 'our-products'          => 'required|string|max:400|noscript',
            $attr . 'all-products-url'      => 'nullable|string|max:255|noanytag|noscript',
            $attr . 'show-home'             => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            $attr . 'icon'                  => 'nullable|image|max:' . $max_size . '|mimes:' . $type_image,
            $attr . 'icon-act'              => 'nullable|image|max:' . $max_size . '|mimes:' . $type_image,
            $attr . 'file-home'             => 'nullable|image|max:' . $max_size . '|mimes:' . $type_image,
            $attr . 'products-background'   => 'nullable|image|max:' . $max_size . '|mimes:' . $type_image,
            'status' => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale' => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        if ($params[$attr . 'show-home'] == Constant::STATUS_ACTIVE) {
            if (empty($id)) {
                $this->_rules[$attr . 'icon']           = 'required|image|max:' . $max_size . '|mimes:' . $type_image;
                $this->_rules[$attr . 'icon-act']       = 'required|image|max:' . $max_size . '|mimes:' . $type_image;
                $this->_rules[$attr . 'file-home']      = 'required|image|max:' . $max_size . '|mimes:' . $type_image;
            }
            $this->_rules[$attr . 'short-desc']     = 'required|string|max:1500';
        } else {
            $this->_rules[$attr . 'short-desc']     = 'nullable|string|max:1500';
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params, $id)
    {
        $this->getCreateValidation($params, $id);

        $attr = self::_ATTR . '-';
        $max_size = Media::_MAX_FILE_SIZE_AVATAR * 1024;
        $type_image = implode(',', Media::$_type_image);

        $this->_rules[$attr . 'avatar'] = 'nullable|image|max:' . $max_size . '|mimes:' . $type_image;
        $this->_rules[$attr . 'file']   = 'nullable|image|max:' . $max_size . '|mimes:' . $type_image;

        if ($params[$attr . 'show-home'] == Constant::STATUS_ACTIVE) {
            if (Media::getOneMedia(['obj_id' => $id, 'obj_type' => Media::OBJ_TYPE_BUSINESS_ICON, 'type' => Media::_TYPE_IMAGE]))
                $this->_rules[$attr . 'icon']           = 'nullable|image|max:' . $max_size . '|mimes:' . $type_image;
            else
                $this->_rules[$attr . 'icon']           = 'required|image|max:' . $max_size . '|mimes:' . $type_image;

            if (Media::getOneMedia(['obj_id' => $id, 'obj_type' => Media::OBJ_TYPE_BUSINESS_ICON_ACT, 'type' => Media::_TYPE_IMAGE]))
                $this->_rules[$attr . 'icon-act']           = 'nullable|image|max:' . $max_size . '|mimes:' . $type_image;
            else
                $this->_rules[$attr . 'icon-act']           = 'required|image|max:' . $max_size . '|mimes:' . $type_image;

            if (Media::getOneMedia(['obj_id' => $id, 'obj_type' => Media::OBJ_TYPE_BUSINESS_IMAGE_HOME, 'type' => Media::_TYPE_IMAGE]))
                $this->_rules[$attr . 'file-home']           = 'nullable|image|max:' . $max_size . '|mimes:' . $type_image;
            else
                $this->_rules[$attr . 'file-home']           = 'required|image|max:' . $max_size . '|mimes:' . $type_image;
        }

        return $this->_rules;
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation($params, $id) : $this->getCreateValidation($params, $id));

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

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['slug']) && !empty($params['slug']))
            $data = $data->where('slug', 'like', '%'. $params['slug'] .'%');

        if (isset($params['show_home']) && !empty($params['show_home']))
            $data = $data->where('show_home', $params['show_home']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && $perPage == 0)
            $data = $data->take($params['limit']);

        if (isset($params['count']) && $params['count'] == true) {
            $data = $data->count($columns);
        } else {
            if (!empty($perPage))
                $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
            else
                $data = $data->get($columns);
        }

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
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'slug_' . $v,
                    'value' => ($v == $params['locale']) ? str_slug($params[$attr . 'name']) : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'content'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'scale-operation_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'scale-operation'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'development-strategy_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'development-strategy'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'our-products_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'our-products'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BUSINESS,
                    'field' => 'short-desc_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'short-desc'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'slug_' . $params['locale'],
                'value' => str_slug($params[$attr . 'name']),
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'content_' . $params['locale'],
                'value' => $params[$attr . 'content'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'scale-operation_' . $params['locale'],
                'value' => $params[$attr . 'scale-operation'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'development-strategy_' . $params['locale'],
                'value' => $params[$attr . 'development-strategy'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'our-products_' . $params['locale'],
                'value' => $params[$attr . 'our-products'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BUSINESS,
                'field' => 'short-desc_' . $params['locale'],
                'value' => $params[$attr . 'short-desc'],
            ]);
        }

        $data = $this->newQuery()->find($id);

        $data->name = implode('; ', Datameta::query()
            ->where('data_id', $id)
            ->whereNotNull('data_value')
            ->where('data_field', 'like', 'name_%')
            ->where('data_type', Datameta::TYPE_BUSINESS)
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->slug = implode('; ', Datameta::query()
            ->where('data_id', $id)
            ->whereNotNull('data_value')
            ->where('data_field', 'like', 'slug_%')
            ->where('data_type', Datameta::TYPE_BUSINESS)
            ->get(['data_value'])->pluck('data_value')->toArray());

        $data->all_products_url = $params[$attr . 'all-products-url'];
        $data->show_home        = $params[$attr . 'show-home'];
        $data->status           = $params['status'];
        $data->save();

        SearchResult::updateSearchResult(['type' => SearchResult::_OBJ_TYPE_BUSINESS, 'id' => $id]);

        if (empty($data->hash_key)) {
            HashKey::doUpdatingOrCreating([
                'type'  => HashKey::_OBJ_TYPE_BUSINESS,
                'code'  => rand(),
                'id'    => $id,
            ]);
        }

        return $id;
    }

    public static function getList($action = null)
    {
        $list = new Business();

        $params['status']   = Constant::STATUS_ACTIVE;
        $params['count']    = isset($action['count']) ? $action['count'] : null;
        $params['ordering'] = isset($action['ordering']) ? $action['ordering'] : ['created_at' => 'asc'];

        $list = $list->filter(0, $params);

        if (empty($params['count'])) {
            $arr = [];

            if (!empty($list)) {
                if (isset($action['pluck']))
                    $arr = ($action['pluck'] == 'id') ? $list->pluck($action['pluck'])->toArray() : $list->pluck($action['pluck'], 'id')->toArray();
                else if(isset($action['api']) && $action['api'] == true)
                    foreach ($list as $item)
                        $arr[] = ['id' => $item->id, 'name' => optional($item->datameta('', 'name'))->data_value];
                else
                    foreach ($list as $item)
                        $arr[$item->id] = optional($item->datameta('', 'name'))->data_value;
            }
        } else {
            $arr = $list;
        }

        return $arr;
    }
}
