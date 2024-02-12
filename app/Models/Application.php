<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    const _ATTR = 'applications';

    protected $fillable = ['id', 'user_id', 'job_id', 'company_id', 'company_location_id', 'name', 'mobile', 'email', 'position', 'cv_file', 'status'];

    protected $dates = ['deleted_at'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function company_location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

    private function sendEmailValidation($params = [])
    {
        $prefix = self::_ATTR;

        $validator = \Validator::make($params, [
            $prefix . "-name"               => "required|string|max:150",
            $prefix . "-mobile"             => "required|string|max:20",
            $prefix . "-email"              => "required|email|max:50",
            $prefix . "-company"            => "required|exists:companies,id",
            $prefix . "-position"           => "required|exists:jobs,id",
            $prefix . "-company_location"   => "required|exists:company_locations,id",
            $prefix . "-cv_file"            => "required|file|max:" . (Media::_MAX_FILE_SIZE_CV * 1024) . "|mimes:" . implode(',', Media::$_type_cv),
        ]);

        return $validator;
    }

    public function validation($params = [], $id = null)
    {
        $validator = (isset($params['sendEmail']) && $params['sendEmail'] == true) ? $this->sendEmailValidation($params) : null;

        if (!empty($validator) && $validator->fails())
            return $validator;

        return null;
    }

    public function doCreatingOrUpdating($params = [], $id = null)
    {
        $prefix = self::_ATTR . '-';

        if (!empty($id))
            $data = self::query()->find($id);
        else
            $data = new Application();
        $data->job_id               = $params[$prefix . 'job'];
        $data->name                 = $params[$prefix . 'name'];
        $data->email                = $params[$prefix . 'email'];
        $data->mobile               = $params[$prefix . 'mobile'];
        $data->position             = $params[$prefix . 'position'];
        $data->company_id           = $params[$prefix . 'company'];
        $data->company_location_id  = $params[$prefix . 'company_location'];
        $data->cv_file              = isset($params['url']) ? $params['url'] : $data->cv_file;
        $data->save();

        return $data;
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = self::query();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['id']) && !empty($params['id']))
            $data = is_array($params['id']) ? $data->whereIn('id', $params['id']) : $data->where('id', $params['id']);

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('name', 'like', '%' . $params['name'] . '%');

        if (isset($params['email']) && !empty($params['email']))
            $data = $data->where('email', 'like', '%' . $params['email'] . '%');

        if (isset($params['position']) && !empty($params['position']))
            $data = $data->where('position', 'like', '%' . $params['position'] . '%');

        if (isset($params['company']) && !empty($params['company']))
            $data = $data->where('company_id', $params['company']);

        if (isset($params['company_location']) && !empty($params['company_location']))
            $data = $data->where('company_location_id', $params['company_location']);

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['job_type']) && !empty($params['job_type']))
            $data = $data->whereHas('job', function ($query) use ($params) {
                $query->where('type_id', $params['job_type']);
            });

        if (isset($params['job_level']) && !empty($params['job_level']))
            $data = $data->whereHas('job', function ($query) use ($params) {
                $query->where('level_id', $params['job_level']);
            });

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (!empty($perPage))
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }
}
