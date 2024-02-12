<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $fillable = ['id', 'company_id', 'location_id', 'city', 'address'];

    public function applications()
    {
        return $this->hasMany(Application::class, 'company_location_id');
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_COMPANY_LOCATION);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_location','location_id','job_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_COMPANY_LOCATION)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['has_relation']) && !empty($params['has_relation']))
            $data = $data->has($params['has_relation']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['company']) && !empty($params['company']))
            $data = $data->where('company_id', $params['company']);

        if (!empty($perPage))
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_COMPANY_LOCATION,
                    'field' => 'city_' . $v,
                    'value' => ($v == $params['locale']) ? $params['city'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_COMPANY_LOCATION,
                    'field' => 'address_' . $v,
                    'value' => ($v == $params['locale']) ? $params['address'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_COMPANY_LOCATION,
                'field' => 'city_' . $params['locale'],
                'value' => $params['city'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_COMPANY_LOCATION,
                'field' => 'address_' . $params['locale'],
                'value' => $params['address'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'city' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'city_%')
                ->where('data_type', Datameta::TYPE_COMPANY_LOCATION)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'address' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'address_%')
                ->where('data_type', Datameta::TYPE_COMPANY_LOCATION)
                ->get(['data_value'])->pluck('data_value')->toArray()),

            'company_id'    => $params['company_id'],
            'location_id'   => $params['location_id'],
        ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $params = [];
        $params['has_relation'] = (isset($action['has_relation'])) ? $action['has_relation'] : null;
        $params['company'] = (isset($action['company'])) ? $action['company'] : null;

        $temp = new CompanyLocation();
        $temp = $temp->filter(0, $params);

        $items_arr = [];

        if (!empty($temp)) {
            if (isset($action['pluck']))
                $items_arr = ($action['pluck'] == 'id') ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($temp as $item)
                    $items_arr[] = ['id' => $item->id, 'name' => optional($item->datameta('', 'city'))->data_value . ': ' . optional($item->datameta('', 'address'))->data_value];
            else
                foreach ($temp as $item)
                    $items_arr[$item->id] = optional($item->datameta('', 'city'))->data_value . ': ' . optional($item->datameta('', 'address'))->data_value;
        }

        return $items_arr;
    }
}
