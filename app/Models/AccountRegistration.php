<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountRegistration extends Model
{
    // リレーション
    public function same_email_users()
    {
        return $this->hasMany(User::class, "email", "user_email");
    }

    protected $guarded = [];
}
