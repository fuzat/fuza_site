<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    protected $table = 'search_results';

    protected $fillable = ['id', 'obj_id', 'obj_type'];

    const _OBJ_TYPE_JOB         = 'jobs';
    const _OBJ_TYPE_NEWS        = 'news';
    const _OBJ_TYPE_BUSINESS    = 'businesses';

    public function job()
    {
        return $this->belongsTo(Job::class, 'obj_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'obj_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'obj_id');
    }

    public static function getData($obj_type)
    {
        return self::where('obj_type', $obj_type)->first();
    }

    public static function updateSearchResult($params = [])
    {
        self::query()->updateOrCreate([
            'obj_id'    => $params['id'],
            'obj_type'  => $params['type'],
        ], [
            'obj_id'    => $params['id'],
            'obj_type'  => $params['type'],
        ]);
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = $this->newQuery();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['job']) && !empty($params['job'])) {
            $data = is_array($params['job']) ? $data->whereIn('obj_id', $params['job']) : $data->where('obj_id', $params['job']);
            $data = $data->where('obj_type', self::_OBJ_TYPE_JOB);
        }

        if (isset($params['news']) && !empty($params['news'])) {
            $data = is_array($params['news']) ? $data->whereIn('obj_id', $params['news']) : $data->where('obj_id', $params['news']);
            $data = $data->where('obj_type', self::_OBJ_TYPE_NEWS);
        }

        if (isset($params['business']) && !empty($params['business'])) {
            $data = is_array($params['business']) ? $data->whereIn('obj_id', $params['business']) : $data->where('obj_id', $params['business']);
            $data = $data->where('obj_type', self::_OBJ_TYPE_BUSINESS);
        }

        if (isset($params['search']) && !empty($params['search'])) {
            $data = $data->where(function ($sql) use ($params) {
                $sql->whereHas('job', function ($query) use ($params) {
                    $query->where('name', 'like', '%' . $params['search'] . '%');
                    $query->where('search_results.obj_type', self::_OBJ_TYPE_JOB);
                    $query->where('status', Constant::STATUS_ACTIVE);
                });

                $sql->orWhereHas('news', function ($query) use ($params) {
                    $query->where('name', 'like', '%' . $params['search'] . '%');
                    $query->where('search_results.obj_type', self::_OBJ_TYPE_NEWS);
                    $query->where('status', Constant::STATUS_ACTIVE);
                });

                $sql->orWhereHas('business', function ($query) use ($params) {
                    $query->where('name', 'like', '%' . $params['search'] . '%');
                    $query->where('search_results.obj_type', self::_OBJ_TYPE_BUSINESS);
                    $query->where('status', Constant::STATUS_ACTIVE);
                });
            });
        }

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['count']) && $params['count'] == true) {
            $data = $data->count($columns);
        } else {
            if (!empty($perPage))
                $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
            else
                $data = $data->get($columns);
        }

        return $data;
    }
}
