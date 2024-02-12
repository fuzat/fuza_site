<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;

    const _ATTR = 'positions';

    protected $fillable = ['id', 'name', 'status'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_POSITION);
    }

    public function board_directors()
    {
        return $this->belongsToMany(BoardDirector::class, 'position_board_director');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_POSITION)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        return $this->_rules = [
            self::_ATTR.'-name' => 'required|string|max:70|noanytag',
            'status' => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale' => 'required|in:' . implode(',', Datameta::$_lang),
        ];
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        return $this->_rules;
    }

    public function validation($params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation() : $this->getCreateValidation());

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [], $columns = ["*"])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                $query->where('data_value', 'like', '%'. $params['name'] .'%')->where('data_field', 'name_' . \LaravelLocalization::getCurrentLocale());
            });

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

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
                    'id' => $id,
                    'type' => Datameta::TYPE_POSITION,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_POSITION,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_POSITION)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'status' => $params['status'],
        ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $temp = new Position();
        $params['status'] = Constant::STATUS_ACTIVE;
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
