<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    const _ATTR = 'milestones';

    private $_rules = [];

    protected $fillable = ['id', 'name', 'year', 'status'];

    protected $dates = ['deleted_at'];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_MILESTONES);
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_MILESTONE)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        $attr = self::_ATTR . '-';

        return $this->_rules = [
            $attr . 'name'          => 'required|string|max:70|noanytag',
            $attr . 'year'          => 'required|string|max:20|noanytag',
            $attr . 'file'          => 'required|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:'. implode(',', Media::$_type_image),
            $attr . 'description'   => 'required|string|max:2000|noscript',
            $attr . 'hover'         => 'nullable|string|max:2000|noscript',
            'status'                => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                => 'required|in:' . implode(',', Datameta::$_lang),
        ];
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR . '-file'] = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_AVATAR * 1024) . '|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
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

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['year']) && !empty($params['year']))
            $data = $data->where('year', 'like', '%'. $params['year'] .'%');

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage > 0)
            $data = ($perPage === 1 || $perPage === '1') ? $data->first($columns) : $data->paginate($perPage, $columns);
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
                    'type' => Datameta::TYPE_MILESTONE,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_MILESTONE,
                    'field' => 'description_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'description'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_MILESTONE,
                    'field' => 'hover_' . $v,
                    'value' => ($v == $params['locale']) ? $hover : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_MILESTONE,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_MILESTONE,
                'field' => 'description_' . $params['locale'],
                'value' => $params[$attr . 'description'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_MILESTONE,
                'field' => 'hover_' . $params['locale'],
                'value' => $hover,
            ]);
        }

        $this->newQuery()
            ->where('id', $id)
            ->update([
                'name' => implode('; ', Datameta::query()
                    ->where('data_id', $id)
                    ->whereNotNull('data_value')
                    ->where('data_field', 'like', 'name_%')
                    ->where('data_type', Datameta::TYPE_MILESTONE)
                    ->get(['data_value'])->pluck('data_value')->toArray()),

                'year'      => $params[$attr . 'year'],
                'status'    => $params['status'],
            ]);

        return $id;
    }

    public static function getList($action = null)
    {
        $list = new self();

        $params['status'] = Constant::STATUS_ACTIVE;
        $params['ordering'] = isset($action['ordering']) ? $action['ordering'] : ['created_at' => 'asc'];

        $list = $list->filter(0, $params);

        $arr = [];

        if (!empty($list)) {
            if (isset($action['pluck']))
                $arr = ($action['pluck'] == 'id') ? $list->pluck($action['pluck'])->toArray() : $list->pluck($action['pluck'], 'id')->toArray();
            else if(isset($action['api']) && $action['api'] == true)
                foreach ($list as $item)
                    $arr[] = ['id' => $item->id, 'name' => optional($item->datameta('', 'name'))->data_value];
            else
                foreach ($list as $item)
                    $arr[$item->id] = optional($item->datameta('', 'name'))->data_value;
        }

        return $arr;
    }
}
