<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;

    const _ATTR = 'partners';

    private $_rules = [];

    protected $fillable = ['id', 'name', 'url', 'status'];

    protected $dates = ['deleted_at'];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_PARTNER);
    }

    private function getCreateValidation()
    {
        $prefix = self::_ATTR . '-';

        $this->_rules = [
            $prefix.'name'  => 'nullable|string|max:70|noanytag',
//            $prefix.'url'   => 'nullable|string|max:255|noanytag',
            $prefix.'file'  => 'required|file|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
            'status'        => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
        ];

        return $this->_rules;
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR.'-file'] = 'nullable|file|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image);
        return $this->_rules;
    }

    public function validation(array $params, $id = null)
    {
        $validator = \Validator::make($params, !empty($id) ? $this->getUpdateValidation() : $this->getCreateValidation());

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage, $params, $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%'. $params['name'] .'%');

        if (isset($params['url']) && !empty($params['url']))
            $data = $data->where('url', 'like', '%'. $params['url'] .'%');

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage > 1)
            $data = $data->paginate($perPage, $columns);
        else if ($perPage === 1 || $perPage === '1')
            $data = $data->first($columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        $prefix = self::_ATTR . '-';

        if (!$id) {
            $date = date('Y-m-d H:i:s');
            $id = $this->newQuery()->insertGetId([
                'name'          => $params[$prefix . 'name'],
//                'url'           => $params[$prefix . 'url'],
                'status'        => $params['status'],
                'created_at'    => $date,
                'updated_at'    => $date,
            ]);
        } else {
            $this->newQuery()->where('id', $id)->update([
                'name'      => $params[$prefix . 'name'],
//                'url'       => $params[$prefix . 'url'],
                'status'    => $params['status'],
            ]);
        }

        return $id;
    }
}
