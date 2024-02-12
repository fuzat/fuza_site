<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlobalPresence extends Model
{
    use SoftDeletes;

    const _ATTR = 'global-presence';

    protected $table = 'global_presence';

    protected $fillable = ['id', 'name', 'address', 'phone', 'email', 'status', 'headquarter'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_GLOBAL_PRESENCE);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_GLOBAL_PRESENCE)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        return $this->_rules = [
            'locale'                        => 'required|in:' . implode(',', Datameta::$_lang),
            self::_ATTR.'-name'             => 'required|string|max:70|noanytag',
            self::_ATTR.'-address'          => 'required|string|max:200|noanytag',
            'phone'                         => 'required|string|max:20|noanytag',
            'email'                         => 'required|email|max:255',
            'headquarter'                   => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'status'                        => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
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

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['phone']) && !empty($params['phone']))
            $data = $data->where('phone', 'like', '%'. $params['phone'] .'%');

        if (isset($params['email']) && !empty($params['email']))
            $data = $data->where('email', 'like', '%'. $params['email'] .'%');

        if (isset($params['name']) ||  isset($params['address']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                if (!empty($params['name']))
                    $query->where('data_value', 'like', '%'. $params['name'] .'%')
                        ->where('data_field', 'name_' . \LaravelLocalization::getCurrentLocale());

                if (!empty($params['address']))
                    $query->where('data_value', 'like', '%'. $params['address'] .'%')
                        ->where('data_field', 'address_' . \LaravelLocalization::getCurrentLocale());
            });

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
                    'type' => Datameta::TYPE_GLOBAL_PRESENCE,
                    'field' => 'name_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'type' => Datameta::TYPE_GLOBAL_PRESENCE,
                    'field' => 'address_' . $v,
                    'id' => $id,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'address'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_GLOBAL_PRESENCE,
                'field' => 'name_' . $params['locale'],
                'id' => $id,
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'type' => Datameta::TYPE_GLOBAL_PRESENCE,
                'field' => 'address_' . $params['locale'],
                'id' => $id,
                'value' => $params[$attr . 'address'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_GLOBAL_PRESENCE)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'address' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'address_%')
                ->where('data_type', Datameta::TYPE_GLOBAL_PRESENCE)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'phone'         => $params['phone'],
            'email'         => $params['email'],
            'status'        => $params['status'],
            'headquarter'   => $params['headquarter'],
        ]);

        return $id;
    }
}
