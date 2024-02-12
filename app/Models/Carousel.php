<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carousel extends Model
{
    use SoftDeletes;

    const _ATTR = 'carousels';

    private $_rules = [];

    protected $fillable = ['id', 'category_id', 'status'];

    protected $dates = ['deleted_at'];

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_CAROUSEL);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_CAROUSEL)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $this->_rules = [
            self::_ATTR.'-category'         => 'required|exists:categories,id',
            self::_ATTR.'-description'      => 'required|string|max:2000|noscript',
            self::_ATTR.'-hover'            => 'nullable|string|max:2000|noscript',
            'status'                        => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                        => 'required|in:' . implode(',', Datameta::$_lang),
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

        if (isset($params['category']) && !empty($params['category']))
            $data = $data->where('category_id', $params['category']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

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
        $hover = (isset($params[$attr.'hover']) && !empty($params[$attr.'hover'])) ? $params[$attr.'hover'] : null;

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_CAROUSEL,
                    'field' => 'description_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'description'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_CAROUSEL,
                    'field' => 'hover_' . $v,
                    'value' => ($v == $params['locale']) ? $hover : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_CAROUSEL,
                'field' => 'description_' . $params['locale'],
                'value' => $params[$attr . 'description'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_CAROUSEL,
                'field' => 'hover_' . $params['locale'],
                'value' => $hover,
            ]);
        }

        $this->newQuery()
            ->where('id', $id)
            ->update([
                'category_id' => $params[$attr.'category'],
                'status' => $params['status'],
            ]);

        return $id;
    }
}
