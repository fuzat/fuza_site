<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    const _ATTR = 'categories';

    private $_rules = [];

    protected $fillable = ['id', 'name', 'slug', 'menu_id', 'status'];

    protected $dates = ['deleted_at'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function carousels()
    {
        return $this->hasMany(Carousel::class, 'category_id');
    }

    public function core_value()
    {
        return $this->hasOne(CoreValue::class, 'category_id');
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_CATEGORY);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_CATEGORY)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $this->_rules = [
            self::_ATTR.'-name'         => 'required|string|max:70|noanytag',
            self::_ATTR.'-menu'         => 'required|exists:menus,id',
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

        if (isset($params['name']) ||  isset($params['slug']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                if (!empty($params['name']))
                    $query->where('data_value', 'like', '%'. $params['name'] .'%')->where('data_field', 'name_' . \LaravelLocalization::getCurrentLocale());
                
                if (!empty($params['slug']))
                    $query->where('data_value', 'like', '%'. $params['slug'] .'%')->where('data_field', 'slug_' . \LaravelLocalization::getCurrentLocale());
            });

        if (isset($params['menu']) || isset($params['menu_route_name']))
            $data = $data->whereHas('menu', function ($query) use ($params) {
                if (!empty($params['menu']))
                    $query->where('id', $params['menu']);

                if (!empty($params['menu_route_name']))
                    $query->where('route_name', $params['menu_route_name']);
            });

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['not_have']) && !empty($params['not_have']))
            $data = (isset($params['except_id']) && !empty($params['except_id'])) ?
                $data->whereDoesntHave($params['not_have'], function ($query) use ($params) {
                    $query->where('category_id', '!=', $params['except_id']);
                }) : $data->doesntHave($params['not_have']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

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
                    'type'  => Datameta::TYPE_CATEGORY,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id'    => $id,
                    'type'  => Datameta::TYPE_CATEGORY,
                    'field' => 'slug_' . $v,
                    'value' => ($v == $params['locale']) ? str_slug($params[$attr . 'name']) : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id'    => $id,
                'type'  => Datameta::TYPE_CATEGORY,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id'    => $id,
                'type'  => Datameta::TYPE_CATEGORY,
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
                    ->where('data_type', Datameta::TYPE_CATEGORY)
                    ->get(['data_value'])->pluck('data_value')->toArray()),
                'slug' => implode('; ', Datameta::query()
                    ->where('data_id', $id)
                    ->whereNotNull('data_value')
                    ->where('data_field', 'like', 'slug_%')
                    ->where('data_type', Datameta::TYPE_CATEGORY)
                    ->get(['data_value'])->pluck('data_value')->toArray()),
                'menu_id'   => $params[$attr . 'menu'],
                'status'    => $params['status'],
            ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $params['status'] = Constant::STATUS_ACTIVE;
        $params['menu'] = isset($action['menu_id']) ? $action['menu_id'] : null;
        $params['menu_route_name'] = isset($action['menu_route_name']) ? $action['menu_route_name'] : null;
        $params['not_have'] = isset($action['not_have']) ? $action['not_have'] : null;
        $params['except_id'] = isset($action['except_id']) ? $action['except_id'] : null;
        $params['ordering'] = isset($action['ordering']) ? $action['ordering'] : null;

        $temp = new Category();
        $temp = $temp->filter(0, $params);

        $field_arr = [];
        if (!empty($temp)) {
            if (isset($action['pluck']))
                $field_arr = $action['pluck'] == 'id' ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item) {
                    $field_arr[] = ['id' => $item->id, 'name' => optional($item->datameta())->data_value];
                }
            else
                foreach ($temp as $item) {
                    $field_arr[$item->id] = optional($item->datameta())->data_value;
                }
        }
        return $field_arr;
    }
}
