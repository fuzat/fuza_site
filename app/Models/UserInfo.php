<?php

namespace App\ Models;

use App\User;
use Illuminate\Notifications\Notifiable;

class UserInfo extends Model
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
