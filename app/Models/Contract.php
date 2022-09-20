<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    // リレーション
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function load_item()
    {
        return $this->belongsTo(Load::class, "load_id");
    }

    protected $guarded = [];
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];
}
