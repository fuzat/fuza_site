<?php

namespace App\ Models;

use App\User;
use Illuminate\Notifications\Notifiable;

class UserApp extends Model
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = ['user_id', 'device_type', 'device_token', 'uid_token', 'lang', 'last_login', 'login_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
