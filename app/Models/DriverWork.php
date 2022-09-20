<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverWork extends Model
{
    public function hasWork(): bool
    {
        return $this->name != "なし";
    }
}
