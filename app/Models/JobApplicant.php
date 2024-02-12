<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    protected $table = 'job_applicant';

    protected $fillable = ['id', 'application_id', 'job_id', 'status'];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
