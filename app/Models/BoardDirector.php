<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardDirector extends Model
{
    use SoftDeletes;

    const _ATTR = 'board-directors';

    protected $fillable = ['id', 'name', 'position_id', 'on_top', 'status', 'sorting'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_DIRECTOR_AVATAR);
    }

    public function media_big()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_DIRECTOR_AVATAR_BIG);
    }

    public function metas()
    {
        return $this->hasMany(Datameta::class, 'data_id')->where('data_type', Datameta::TYPE_BOARD_DIRECTOR);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_board_director');
    }

    public function datameta($lang = '', $field = '')
    {
        $lang = in_array($lang, Datameta::$_lang) ? $lang : \LaravelLocalization::getCurrentLocale();
        return $this->hasOne(Datameta::class, 'data_id')
            ->where('data_type', Datameta::TYPE_BOARD_DIRECTOR)
            ->where('data_field', Datameta::setDataField($field) . $lang)
            ->first();
    }

    private function getCreateValidation($params)
    {
        $attr = self::_ATTR . '-';

        $this->_rules = [
            $attr . 'name'              => 'required|string|max:70|noanytag',
            $attr . 'position'          => 'required|array',
            $attr . 'position.*'        => 'required|exists:positions,id',
            $attr . 'avatar'            => 'required|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
            $attr . 'description-1'     => 'required|noscript',
            $attr . 'hover-1'           => 'nullable|noscript',
            'on_top'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'status'                    => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
            'locale'                    => 'required|in:' . implode(',', Datameta::$_lang),
            'sorting'                   => 'required|numeric|integer',
        ];

        if ($params['on_top'] == Constant::STATUS_ACTIVE) {
            $this->_rules[$attr . 'description-2' ] = 'required|noscript';
            $this->_rules[$attr . 'hover-2' ] = 'nullable|noscript';
        } else {
            $params[$attr . 'description-2'] = null;
            $params[$attr . 'hover-2'] = null;
        }

        return $this->_rules;
    }

    private function getUpdateValidation($params)
    {
        $this->getCreateValidation($params);
        $this->_rules[self::_ATTR . '-avatar'] = 'nullable|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
    }

    public function validation($params, $id = null)
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

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['position']) && !empty($params['position']))
            $data = $data->whereHas('positions', function ($query) use ($params) {
                $query->where('id', $params['position']);
            });

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->whereHas('metas', function ($query) use ($params) {
                $query->where('data_value', 'like', '%'. $params['name'] .'%')->where('data_field', 'name_' . \LaravelLocalization::getCurrentLocale());
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
                    'type' => Datameta::TYPE_BOARD_DIRECTOR,
                    'field' => 'name_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'name'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BOARD_DIRECTOR,
                    'field' => 'description-1_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'description-1'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BOARD_DIRECTOR,
                    'field' => 'description-2_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'description-2'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BOARD_DIRECTOR,
                    'field' => 'hover-1_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'hover-1'] : null,
                ]);
                Datameta::updateDataMeta([
                    'id' => $id,
                    'type' => Datameta::TYPE_BOARD_DIRECTOR,
                    'field' => 'hover-2_' . $v,
                    'value' => ($v == $params['locale']) ? $params[$attr . 'hover-2'] : null,
                ]);
            }
        } else {
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BOARD_DIRECTOR,
                'field' => 'name_' . $params['locale'],
                'value' => $params[$attr . 'name'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BOARD_DIRECTOR,
                'field' => 'description-1_' . $params['locale'],
                'value' => $params[$attr . 'description-1'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BOARD_DIRECTOR,
                'field' => 'description-2_' . $params['locale'],
                'value' => $params[$attr . 'description-2'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BOARD_DIRECTOR,
                'field' => 'hover-1_' . $params['locale'],
                'value' => $params[$attr . 'hover-1'],
            ]);
            Datameta::updateDataMeta([
                'id' => $id,
                'type' => Datameta::TYPE_BOARD_DIRECTOR,
                'field' => 'hover-2_' . $params['locale'],
                'value' => $params[$attr . 'hover-2'],
            ]);
        }

        $select = ['data_value'];

        $this->newQuery()->where('id', $id)->update([
            'name' => implode('; ', Datameta::query()
                ->where('data_id', $id)
                ->whereNotNull('data_value')
                ->where('data_field', 'like', 'name_%')
                ->where('data_type', Datameta::TYPE_BOARD_DIRECTOR)
                ->get($select)->pluck('data_value')->toArray()),
            'status'        => $params['status'],
            'on_top'        => $params['on_top'],
            'sorting'       => $params['sorting'],
        ]);

        $data = $this->filter(1, ['id' => $id]);
        $data->positions()->detach();
        $data->positions()->attach($params[$attr . 'position']);

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
