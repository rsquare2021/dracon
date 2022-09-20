<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Company extends Model
{
    public function getCompanyAndOfficeName(): string
    {
        return $this->name . " " . $this->office_address;
    }

    public function getFullAddress(): string
    {
        return $this->prefecture->name . $this->address_1 . $this->address_2;
    }

    // リレーション
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function employee_size()
    {
        return $this->belongsTo(EmployeeSize::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Load::class, "bookmarks")->withTimestamps()->withTrashed();
    }

    public function emptyTrucks()
    {
        return $this->hasMany(EmptyTruck::class, "owner_company_id");
    }

    protected $guarded = [];

    protected $casts = [
        "established_at" => "date",
        "created_at" => "datetime",
    ];
}
