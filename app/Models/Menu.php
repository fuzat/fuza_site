<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    const _ATTR = 'menus';

    const _MENU_HOME_VAL                    = -1;
    const _MENU_SEARCH_VAL                  = -2;
    const _MENU_JOIN_TALENT_COMMUNITY_VAL   = -3;

    private $_rules = [];

    protected $fillable = ['id', 'parent_id', 'name', 'url', 'type', 'status', 'sorting', 'route_name', 'editable'];

    protected $dates = ['deleted_at'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'menu_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'menu_id');
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_MENU);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_MENU)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $this->_rules = [
            self::_ATTR.'-name'         => 'required|string|max:70|noanytag',
            self::_ATTR.'-parent_id'    => 'nullable|numeric|integer|min:1',
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        return $this->_rules;
    }

    private function getUpdateValidation($params)
    {
        return $this->getCreateValidation($params);
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

        if (isset($params['not_id']) && !empty($params['not_id']))
            $data = $data->where('id', '!=', $params['not_id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['slug']) && !empty($params['slug']))
            $data = $data->where('slug', 'like', '%'. $params['slug'] .'%');

        if (isset($params['route_name']) && !empty($params['route_name']))
            $data = $data->where('route_name', $params['route_name']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['parent_id']) && !empty($params['parent_id']))
            $data = $data->where('parent_id', $params['parent_id']);

        if (isset($params['parent_id_null']) && $params['parent_id_null'] == true)
            $data = $data->whereNull('parent_id');

        if (isset($params['not_have']) && !empty($params['not_have']))
            $data = (isset($params['except_id']) && !empty($params['except_id'])) ?
                $data->whereDoesntHave($params['not_have'], function ($query) use ($params) {
                    $query->where('id', '!=', $params['except_id']);
                }) : $data->doesntHave($params['not_have']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering'])) {
            foreach ($params['ordering'] as $k => $i) {
                $data = $data->orderBy($k, $i);
            }
        } else {
            $data = $data->latest();
        }

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage > 0)
            $data = ($perPage > 1) ? $data->paginate($perPage, $columns) : $data->first($columns);
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
                    'id'    => $id,
                    'type'  => Datameta::TYPE_MENU,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id'    => $id,
                    'type'  => Datameta::TYPE_MENU,
                    'field' => 'slug_' . $v,
                    'value' => ($v == $params['locale']) ? str_slug($params[$attr . 'name']) : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id'    => $id,
                'type'  => Datameta::TYPE_MENU,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id'    => $id,
                'type'  => Datameta::TYPE_MENU,
                'field' => 'slug_' . $params['locale'],
                'value' => str_slug($params[$attr . 'name']),
            ]);
        }

        $this->newQuery()
            ->where('id', $id)
            ->update([
                'name' => implode('; ', Datameta::query()
                    ->where('data_id', $id)
                    ->whereNotNull('data_value')
                    ->where('data_field', 'like', 'name_%')
                    ->where('data_type', Datameta::TYPE_MENU)
                    ->get(['data_value'])->pluck('data_value')->toArray()),

                'slug' => implode('; ', Datameta::query()
                    ->where('data_id', $id)
                    ->whereNotNull('data_value')
                    ->where('data_field', 'like', 'slug_%')
                    ->where('data_type', Datameta::TYPE_MENU)
                    ->get(['data_value'])->pluck('data_value')->toArray()),

                'parent_id' => isset($params[$attr . 'parent_id']) ? $params[$attr . 'parent_id'] : null,
                'status'    => $params['status'],
            ]);

        return $id;
    }

    public static function getList($action = null, $id = null)
    {
        $temp = new Menu();
        $params['status']           = Constant::STATUS_ACTIVE;
        $params['slug']             = (isset($action['slug'])) ? $action['slug'] : null;
        $params['not_id']           = (isset($action['not_id'])) ? $action['not_id'] : null;
        $params['not_have']         = (isset($action['not_have'])) ? $action['not_have'] : null;
        $params['except_id']        = (isset($action['except_id'])) ? $action['except_id'] : null;
        $params['parent_id']        = (isset($action['parent_id'])) ? $action['parent_id'] : null;
        $params['parent_id_null']   = (isset($action['parent_id_null'])) ? $action['parent_id_null'] : null;
        $params['ordering']         = (isset($action['ordering'])) ? $action['ordering'] : null;

        $temp = $temp->filter(0, $params);
        $items_arr = [];
        if (!empty($temp)) {
            if (isset($action['pluck']))
                $items_arr = $action['pluck'] == 'id' ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item) {
                    $items_arr[] = ['id' => $item->id, 'name' => optional($item->datameta())->data_value];
                }
            else
                foreach ($temp as $item) {
                    $items_arr[$item->id] = optional($item->datameta())->data_value;
                }
        }

        return $items_arr;
    }

    public static function getData($id = null, $option = [])
    {
        $data = self::query();

        if (!empty($id))
            $data = $data->where('id', $id);

        if (!empty($option))
            foreach ($option as $key => $value)
                $data = $data->where($key, $value);

        return $data->first();
    }
}
