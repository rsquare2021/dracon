<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmptyTruck extends Model
{
    public function getDepartureAt(): string
    {
        return $this->departure_date->isoFormat("M/D ddd") . " " . ($this->departure_time ?? "指定なし");
    }

    public function getArrivalAt(): string
    {
        return $this->arrival_date->isoFormat("M/D ddd") . " " . ($this->arrival_time ?? "指定なし");
    }

    public function getDepartureAddress(): string
    {
        $base = $this->departure_prefecture->name . $this->departure_address_1;
        $around = "(" . $this->departure_around_prefectures->implode("name", "、") . ")";
        return $base . " " . ($this->departure_around_prefectures->isNotEmpty() ? $around : "");
    }

    public function getArrivalAddress(): string
    {
        $base = $this->arrival_prefecture->name . $this->arrival_address_1;
        $around = "(" . $this->arrival_around_prefectures->implode("name", "、") . ")";
        return $base . " " . ($this->arrival_around_prefectures->isNotEmpty() ? $around : "");
    }

    public function syncAroundPrefectures($departures, $arrivals)
    {
        $this->departure_around_prefectures()->sync(collect($departures)->mapWithKeys(fn($v) => [$v => ["is_departure" => true]])->toArray());
        $this->arrival_around_prefectures()->sync(collect($arrivals)->mapWithKeys(fn($v) => [$v => ["is_departure" => false]])->toArray());
    }

    // リレーション
    public function owner()
    {
        return $this->belongsTo(Company::class, "owner_company_id");
    }

    public function departure_prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function arrival_prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function departure_around_prefectures()
    {
        return $this->belongsToMany(Prefecture::class, "around_prefectures")->wherePivot("is_departure", true)->withTimestamps();
    }

    public function arrival_around_prefectures()
    {
        return $this->belongsToMany(Prefecture::class, "around_prefectures")->wherePivot("is_departure", false)->withTimestamps();
    }

    public function truck_capacity_type()
    {
        return $this->belongsTo(TruckCapacityType::class)->withDefault([
            "name" => "問わず",
        ]);
    }

    public function truck_cargo_type()
    {
        return $this->belongsTo(TruckCargoType::class)->withDefault([
            "name" => "問わず",
        ]);
    }

    protected $guarded = [];
    protected $casts = [
        "departure_date" => "date",
        "arrival_date" => "date",
    ];
}
