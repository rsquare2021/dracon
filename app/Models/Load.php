<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Load extends Model
{
    use SoftDeletes;

    public function getDepartureAt(string $patern): string
    {
        return $this->departure_date->isoFormat("M/D ddd") . " " . ($this->departure_time ?? "指定なし");
    }

    public function getArrivalAt(string $patern): string
    {
        return $this->arrival_date->isoFormat("M/D ddd") . " " . ($this->arrival_time ?? "指定なし");
    }

    public function getDepartureAddress(): string
    {
        return $this->departure_prefecture->name . $this->departure_address_1 . " " . $this->departure_address_2;
    }

    public function getArrivalAddress(): string
    {
        return $this->arrival_prefecture->name . $this->arrival_address_1 . " " . $this->arrival_address_2;
    }

    public function hasBookmark(): bool
    {
        return $this->bookmarks->contains(Auth::user()->company_id);
    }

    public function getDriverWorkCaption(string $where)
    {
        switch($where) {
            case "integrate":
                $rank = max($this->getDriverWorkRank($this->carry_in_driver_work), $this->getDriverWorkRank($this->carry_out_driver_work));
                $captions = ["なし", "未入力", "あり"];
                return $captions[$rank];
            case "carry_in":
                return $this->carry_in_driver_work ?
                    $this->carry_in_driver_work->name :
                    "未入力";
            case "carry_out":
                return $this->carry_out_driver_work ?
                    $this->carry_out_driver_work->name :
                    "未入力";
        }
    }

    public function canApply()
    {
        $is_posted = !$this->trashed();
        $before_departure_at = self::where("id", $this->id)->beforeDepartureAt() ? true : false;
        $has_contractor = $this->contract ? true : false;
        return $is_posted && $before_departure_at && !$has_contractor;
    }

    public function hasConfirmStatus()
    {
        return $this->applies->contains("status", "confirm");
    }

    public function getAccessCount()
    {
        return count($this->accessed_users ?? []);
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

    public function carry_in_driver_work()
    {
        return $this->belongsTo(DriverWork::class);
    }

    public function carry_out_driver_work()
    {
        return $this->belongsTo(DriverWork::class);
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

    public function bookmarks()
    {
        return $this->belongsToMany(Company::class, "bookmarks")->withTimestamps();
    }

    public function applies()
    {
        return $this->hasMany(Contract::class)->whereNotIn("status", ["accept", "cancel"]);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class)->where("status", "accept");
    }

    // スコープ
    public function scopeHasContract($query)
    {
        return $query->whereIn("id", Contract::where("status", "accept")->select("load_id"));
    }

    public function scopeHasnotContract($query)
    {
        return $query->whereNotIn("id", Contract::where("status", "accept")->select("load_id"));
    }

    public function scopeBeforeDepartureAt($query)
    {
        return $query->where(function($query) {
            $query->whereDate("departure_date", ">", Carbon::today())
                ->orWhere(function($query) {
                    $query->whereDate("departure_date", "=", Carbon::today())
                        ->where(function($query) {
                            $query->whereNull("departure_time")
                                ->orWhereTime("departure_time", ">", Carbon::now());
                        });
                });
        });
    }

    public function scopeAfterDepartureAt($query)
    {
        return $query->where(function($query) {
            $query->whereDate("departure_date", "<", Carbon::today())
                ->orWhere(function($query) {
                    $query->whereDate("departure_date", "=", Carbon::today())
                        ->whereTime("departure_time", "<=", Carbon::now());
                });
        });
    }

    public function scopeIgnoreOwner($query, User $user)
    {
        return $query->where("owner_company_id", "<>", $user->company->id);
    }

    private function getDriverWorkRank($driver_work)
    {
        if($driver_work === null) {
            return 1;
        }
        else {
            return $driver_work->hasWork() ? 2 : 0;
        }
    }

    protected $guarded = [];

    protected $casts = [
        "departure_date" => "date",
        "arrival_date" => "date",
        "accessed_users" => "json",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    protected $attributes = [
        "accessed_users" => [],
    ];
}
