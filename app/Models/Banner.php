<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    const _ATTR = 'banners';

    protected $fillable = ['id', 'name', 'menu_id', 'post_id', 'banner_position_id', 'status', 'url'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BANNER);
    }

    public function media_mobile()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BANNER_MOBILE);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_BANNER);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function banner_position()
    {
        return $this->belongsTo(BannerPosition::class, 'banner_position_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_BANNER)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    public function getLocaleMedia($lang = '', $obj_type = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', $obj_type)->where('locale', $lang)->first();
    }

    private function getCreateValidation($params)
    {
        $this->_rules = [
            self::_ATTR.'-name'         => 'required|string|max:70|noanytag',
            self::_ATTR.'-menu'         => 'required',
            self::_ATTR.'-position'     => 'required|exists:banner_positions,id',
            self::_ATTR.'-post'         => 'nullable',
            self::_ATTR.'-file'         => 'required|file|max:102400|mimes:'. implode(',', Media::$_type_image) .','. implode(',', Media::$_type_video),
            self::_ATTR.'-mobile_file'  => 'nullable|file|max:102400|mimes:'. implode(',', Media::$_type_image) .','. implode(',', Media::$_type_video),
            self::_ATTR.'-slogan_1'     => 'nullable|string|max:250|noanytag',
            self::_ATTR.'-slogan_2'     => 'nullable|string|max:250|noanytag',
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        if (optional($menu = Menu::getData($params[self::_ATTR.'-menu']))->route_name == 'front.about-us') {
            $this->_rules[self::_ATTR.'-post'] = 'required|exists:posts,id';
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params)
    {
        $this->getCreateValidation($params);
        $this->_rules[self::_ATTR.'-file'] = 'nullable|file|max:102400|mimes:'. implode(',', Media::$_type_image) .','. implode(',', Media::$_type_video);
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
            $data = $data->where('id', $params['id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['menu']) && !empty($params['menu']))
            $data = $data->where('menu_id', $params['menu']);

        if (isset($params['post']) && !empty($params['post']))
            $data = $data->where('post_id', $params['post']);

        if (isset($params['position']) && !empty($params['position']))
            $data = $data->where('banner_position_id', $params['position']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && $perPage == 0)
            $data = $data->take($params['limit']);

        if ($perPage > 1)
            $data = $data->paginate($perPage, $columns);
        elseif ($perPage === 1 || $perPage === '1')
            $data = $data->first($columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating(array $params, $id = null)
    {
        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'type' => Datameta::TYPE_BANNER,
                    'field' => 'name_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[self::_ATTR.'-name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'type' => Datameta::TYPE_BANNER,
                    'field' => 'slogan_1_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[self::_ATTR.'-slogan_1'] : null,
                ]);
                Datameta::updateDataMeta([
                    'type' => Datameta::TYPE_BANNER,
                    'field' => 'slogan_2_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[self::_ATTR.'-slogan_2'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_BANNER,
                'field' => 'name_' . $params['locale'],
                'id' => $id,
                'value' => $params[self::_ATTR.'-name'],
            ]);
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_BANNER,
                'field' => 'slogan_1_' . $params['locale'],
                'id' => $id,
                'value' => $params[self::_ATTR.'-slogan_1'],
            ]);
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_BANNER,
                'field' => 'slogan_2_' . $params['locale'],
                'id' => $id,
                'value' => $params[self::_ATTR.'-slogan_2'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_BANNER)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'banner_position_id' => $params[self::_ATTR.'-position'],
            'post_id' => (isset($params[self::_ATTR.'-post']) && !empty($params[self::_ATTR.'-post'])) ? $params[self::_ATTR.'-post'] : null,
            'menu_id' => $params[self::_ATTR.'-menu'],
            'status' => $params['status'],
            'url' => $params['url'],
        ]);

        return $id;
    }
}
