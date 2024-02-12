<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    const _ATTR = 'companies';

    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'status'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    private $_messages = [];

    public function work_locations()
    {
        return $this->hasMany(CompanyLocation::class, 'company_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'company_id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_COMPANY);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_COMPANY);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_COMPANY)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $attr = self::_ATTR . '-';

        $this->_rules = [
            $attr . 'name'          => 'required|string|max:70|noanytag',
            $attr . 'email'         => 'required|email|max:100|noanytag',
            $attr . 'logo'          => 'required|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
            $attr . 'content'       => 'required|string|max:2000|noanytag',
            $attr . 'working-time'  => 'required|string|max:250|noanytag',
            'status' => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale' => 'required|in:' . implode(',', Datameta::$_lang),
        ];

        foreach ($params[$attr.'city'] as $i => $v) {
            $key = $attr.'city'.'.'.$i;
            $key_name = __('validation.attributes.'.$attr.'city');
            $this->_rules[$key] = 'required|exists:locations,id';
            $this->_messages[$key.'.required'] = __('validation.required', ['attribute' => $key_name]) . ' ' . __('validation.line-error', ['line' => ($i + 1)]);
            $this->_messages[$key.'.exists'] = __('validation.exists', ['attribute' => $key_name]) . ' ' . __('validation.line-error', ['line' => ($i + 1)]);
        }

        foreach ($params[$attr.'address'] as $i => $v) {
            $key = $attr.'address'.'.'.$i;
            $key_name = __('validation.attributes.'.$attr.'address');
            $this->_rules[$key] = 'required|string|max:250|noanytag';
            $this->_messages[$key.'.required'] = __('validation.required', ['attribute' => $key_name]) . ' ' . __('validation.line-error', ['line' => ($i + 1)]);
            $this->_messages[$key.'.max'] = __('validation.max.string', ['attribute' => $key_name, 'max' => 250]) . ' ' . __('validation.line-error', ['line' => ($i + 1)]);
            $this->_messages[$key.'.noanytag'] = __('validation.noanytag', ['attribute' => $key_name]) . ' ' . __('validation.line-error', ['line' => ($i + 1)]);
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params)
    {
        $this->getCreateValidation($params);
        $this->_rules[self::_ATTR.'-logo'] = 'nullable|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
    }

    public function validation($params = [], $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation($params) : $this->getCreateValidation($params), $this->_messages);

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
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['email']) && !empty($params['email']))
            $data = $data->where('email', 'like', '%'. $params['email'] .'%');

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
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        $attr = self::_ATTR . '-';

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_COMPANY,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_COMPANY,
                    'field' => 'content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'content'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_COMPANY,
                    'field' => 'working-time_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'working-time'] : null,
                ]);
            }

        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_COMPANY,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_COMPANY,
                'field' => 'content_' . $params['locale'],
                'value' => $params[$attr . 'content'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_COMPANY,
                'field' => 'working-time_' . $params['locale'],
                'value' => $params[$attr . 'working-time'],
            ]);
        }

        $data = $this->filter(1, ['id' => $id]);
        $data->name = implode('; ', Datameta::query()
            ->where('data_id', $id)
            ->whereNotNull('data_value')
            ->where('data_field', 'like', 'name_%')
            ->where('data_type', Datameta::TYPE_COMPANY)
            ->get(['data_value'])->pluck('data_value')->toArray());
        $data->email = $params[$attr . 'email'];
        $data->status = $params['status'];
        $data->save();

        return $id;
    }

    public static function getList($action = null)
    {
        $params['status'] = Constant::STATUS_ACTIVE;
        $params['has_relation'] = (isset($action['has_relation'])) ? $action['has_relation'] : null;

        $temp = new Company();
        $temp = $temp->filter(0, $params);

        $items_arr = [];

        if (!empty($temp)) {
            if (isset($action['pluck']))
                $items_arr = ($action['pluck'] == 'id') ? $temp->pluck($action['pluck'])->toArray() : $temp->pluck($action['pluck'], 'id')->toArray();
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
