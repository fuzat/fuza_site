<?php

namespace App\Models;

class Benefit extends Model
{
    const _ATTR = 'benefits';

    static $_image_size = [
        'min_height' => 12,
        'max_height' => 800,
        'min_width' => 12,
        'max_width' => 800,
    ];

    private $_rules = [];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_BENEFIT);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_benefit');
    }

    private function getCreateValidation()
    {
        return $this->_rules = [
            self::_ATTR.'-name'     => 'required|string|max:70',
            self::_ATTR.'-file'     => 'required|file|max:500|dimensions:min_width='.self::$_image_size['min_width'].',max_width='.self::$_image_size['max_width'].',min_height='.self::$_image_size['min_height'].',max_height='.self::$_image_size['max_height'].'|mimes:'. implode(',', Media::$_type_image),
            'status'                => 'required|in:1,2',
            'locale'                => 'required|in:' . implode(',', Datameta::$_lang),
        ];
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR.'-file'] = 'nullable|file|max:10240|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation() : $this->getCreateValidation());
        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [])
    {
        $data = self::orderBy('created_at', 'desc');

        if (!empty($params)) {
            if (isset($params['id']) && !empty($params['id']))
                $data = $data->where('id', $params['id']);

            if (isset($params['name']) && !empty($params['name']))
                $data = $data->where('name', 'like', '%'. $params['name'] .'%');

            if (isset($params['status']) && !empty($params['status']))
                $data = $data->where('status', $params['status']);

            if (isset($params['ordering']) && !empty($params['ordering']))
                foreach ($params['ordering'] as $k => $i)
                    $data = $data->orderBy($k, $i);
        }

        if ($perPage > 1)
            $data = $data->paginate($perPage);
        elseif ($perPage === 1 || $perPage === '1')
            $data = $data->first();
        else
            $data = $data->get();

        return $data;
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_BENEFIT)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    public function doCreatingOrUpdating(array $params, $id = null)
    {
        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = self::insertGetId([
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'type' => Datameta::TYPE_BENEFIT,
                    'field' => 'name_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[self::_ATTR.'-name'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_BENEFIT,
                'field' => 'name_' . $params['locale'],
                'id' => $id,
                'value' => $params[self::_ATTR.'-name'],
            ]);
        }

        self::where('id', $id)->update([
            'name' => implode('; ', Datameta::where('data_type', Datameta::TYPE_BENEFIT)
                ->where('data_field', 'like', '%name_%')
                ->where('data_id', $id)
                ->get(['data_value'])
                ->pluck('data_value')
                ->toArray()),
            'status' => $params['status'],
        ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $temp = new Benefit();
        $params['status'] = Constant::STATUS_ACTIVE;
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

}
