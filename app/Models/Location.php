<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    const _ATTR = 'locations';

    protected $fillable = ['id', 'name', 'status', 'sorting'];

    protected $dates = ['deleted_at'];

    public function company_locations()
    {
        return $this->hasMany(CompanyLocation::class, 'location_id');
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_LOCATION);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_LOCATION)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        return [
            self::_ATTR.'-name' => 'required|string|max:70|noanytag',
            'status'            => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'            => 'required|in:' . implode(',', Datameta::$_lang),
        ];
    }

    private function getUpdateValidation()
    {
        return $this->getCreateValidation();
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation() : $this->getCreateValidation());

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['has_relation']) && !empty($params['has_relation']))
            $data = $data->has($params['has_relation']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                $query->where('data_value', 'like', '%'. $params['name'] .'%')->where('data_field', 'name_' . \LaravelLocalization::getCurrentLocale());
            });

        if (isset($params['job']) && !empty($params['job']))
            $data = $data->whereHas('jobs', function ($query) use ($params) {
                $query->where('job_id', $params['job']);
            });

        if (isset($params['ordering']) && !empty($params['ordering'])) {
            foreach ($params['ordering'] as $k => $i) {
                $data = $data->orderBy($k, $i);
            }
        } else {
            $data = $data->latest();
        }

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage >= 1)
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
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
                    'type' => Datameta::TYPE_LOCATION,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_LOCATION,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_LOCATION)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'sorting'   => isset($params['sorting']) ? $params['sorting'] : '-1',
            'status'    => $params['status'],
        ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $temp = new Location();
        $params['status'] = Constant::STATUS_ACTIVE;
        $params['has_relation'] = (isset($action['has_relation'])) ? $action['has_relation'] : null;

        if (isset($action['job']) && !empty($action['job']))
            $params['job'] = $action['job'];

        $items_arr = [];
        $temp = $temp->filter(0, $params);

        if (!empty($temp)) {
            if (isset($action['pluck']))
                $items_arr = $action['pluck'] == 'id' ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item)
                    $items_arr[] = ['id' => $item->id, 'name' => optional($item->datameta())->data_value];
            else
                foreach ($temp as $item)
                    $items_arr[$item->id] = optional($item->datameta())->data_value;
        }

        return $items_arr;
    }
}
