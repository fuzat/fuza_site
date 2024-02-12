<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    const _ATTR = 'groups';

    protected $fillable = ['id', 'name', 'status'];

    protected $dates = ['deleted_at'];

    private $_rules = [];

    public function media()
    {
        return $this->hasOne(Media::class, 'obj_id')->where('obj_type', Media::OBJ_TYPE_GROUP);
    }

    private function getCreateValidation()
    {
        $prefix = self::_ATTR . '-';

        $this->_rules = [
            $prefix . 'name'    => 'required|string|max:255|noanytag',
            $prefix . 'file'    => 'required|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image),
            'status'            => 'required|in:' . implode(',', Constant::ARRAY_STATUS),
        ];

        return $this->_rules;
    }

    private function getUpdateValidation()
    {
        $this->getCreateValidation();
        $this->_rules[self::_ATTR.'-file'] = 'nullable|image|max:'. (Media::_MAX_FILE_SIZE_AVATAR * 1024) .'|mimes:'. implode(',', Media::$_type_image);
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

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%' . $params['name'] . '%');

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && $perPage == 0)
            $data = $data->take($params['limit']);

        if ($perPage)
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        $data = null;
        $attr = self::_ATTR . '-';

        if (empty($id))
            $data = new Group();
        else
            $data = $this->filter(1, ['id' => $id]);

        $data->name     = $params[$attr . 'name'];
        $data->status   = $params['status'];
        $data->save();

        return !empty($id) ? $id : $data->id;
    }
}
