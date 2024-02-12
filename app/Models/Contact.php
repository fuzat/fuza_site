<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    const _ATTR = 'contacts';

    const _STATUS_NEW = 1;
    const _STATUS_DONE = 2;

    protected $fillable = ['id', 'fullname', 'email', 'phone', 'content', 'status', 'subject', 'industry_id'];

    protected $dates = ['deleted_at'];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function validation($params)
    {
        $validator = \Validator::make($params, [
            'fullname'  => 'required|string|max:255',
            'phone'     => 'required|string|digits_between:10,20',
            'email'     => 'required|email|string|max:255',
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string|max:50000',
            'industry'  => 'required|exists:industries,id',
        ]);

        if ($validator->fails())
            return $validator;

        return null;
    }

    public function filter($perPage = 0, $params = [], $columns = ['*'])
    {
        $data = self::query();

        if (isset($params['relationship']) && !empty($params['relationship']))
            $data = $data->with($params['relationship']);

        if (isset($params['email']) && !empty($params['email']))
            $data = $data->where('email', 'like', '%'. $params['email'] .'%');

        if (isset($params['name']) && !empty($params['name']))
            $data = $data->where('fullname', 'like', '%'. $params['name'] .'%');

        if (isset($params['fullname']) && !empty($params['fullname']))
            $data = $data->where('fullname', 'like', '%'. $params['fullname'] .'%');

        if (isset($params['industry']) && !empty($params['industry']))
            $data = $data->where('industry_id', $params['industry']);

        if (isset($params['status']) && !empty($params['status']))
            $data = $data->where('status', $params['status']);

        if (isset($params['grouping']) && !empty($params['grouping']))
            $data = $data->groupBy($params['grouping']);

        if (isset($params['ordering']) && !empty($params['ordering']))
            foreach ($params['ordering'] as $k => $v)
                $data = $data->orderBy($k, $v);
        else
            $data = $data->latest();

        if (isset($params['limit']) && !empty($params['limit']) && empty($perPage))
            $data = $data->take($params['limit']);

        if (!empty($perPage))
            $data = ($perPage == 1) ? $data->first($columns) : $data->paginate($perPage, $columns);
        else
            $data = $data->get($columns);

        return $data;
    }
}
