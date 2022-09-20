<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class User extends Authenticatable
{
    use Notifiable;

    // リレーション
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }

    protected $guarded = [
        "id", "email_verified_at", "remember_token", "created_at", "updated_at",
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
