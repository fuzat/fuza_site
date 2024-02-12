<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    protected $table = 'vision_mission';

    protected $fillable = ['id', 'name', 'status'];

    private $_rules = [];

    const _ATTR = 'vision-mission';

    public function icon_active()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_VISION_MISSION_ACTIVE);
    }

    public function icon_inactive()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_VISION_MISSION_INACTIVE);
    }


    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_VISION_MISSION)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation()
    {
        $attr = self::_ATTR . '-';

        return $this->_rules = [
            $attr . 'name'              => 'required|string|max:70|noanytag',
            $attr . 'icon_active'       => 'required|image|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) . '|mimes:' . implode(',', Media::$_type_image),
            $attr . 'icon_inactive'     => 'required|image|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) . '|mimes:' . implode(',', Media::$_type_image),
            $attr . 'content'           => 'required|string|max:2000|noscript',
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
        ];
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR . '-icon_active']     = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) . '|mimes:' . implode(',', Media::$_type_image);
        $this->_rules[self::_ATTR . '-icon_inactive']   = 'nullable|image|max:' . (Media::_MAX_FILE_SIZE_CV * 1024) . '|mimes:' . implode(',', Media::$_type_image);
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

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId(['created_at' => $date, 'updated_at' => $date]);

            foreach (Datameta::$_lang as $k => $v) {
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_VISION_MISSION,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_VISION_MISSION,
                    'field' => 'content_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'content'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_VISION_MISSION,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_VISION_MISSION,
                'field' => 'content_' . $params['locale'],
                'value' => $params[$attr . 'content'],
            ]);
        }

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_VISION_MISSION)
                ->get(['data_value'])->pluck('data_value')->toArray()),
            'status'        => $params['status'],
        ]);

        return $id;
    }
}
