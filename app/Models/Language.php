<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['id', 'code', 'name', 'regional', 'status'];

    public function filter($perPage, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['code']) && !empty($params['code']))
            $data = $data->where('code', $params['code']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['regional']) && !empty($params['regional']))
            $data = $data->where('regional', $params['regional']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%' . $params['name'] . '%');

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $i)
                $data = $data->orderBy($k, $i);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if ($perPage > 0)
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }
}
