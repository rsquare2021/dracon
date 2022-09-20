<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmptyTruck;
use App\Models\Prefecture;
use App\Models\TruckCapacityType;
use App\Models\TruckCargoType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmptyTruckController extends Controller
{
    public function find(Request $request)
    {
        $safe_data = $request->validate([
            "dp" => ["nullable", "exists:prefectures,id"],
            "ap" => ["nullable", "exists:prefectures,id"],
            "ds" => ["nullable", "date"],
            "de" => ["nullable", "date"],
            "as" => ["nullable", "date"],
            "ae" => ["nullable", "date"],
            "f" => ["nullable", "integer", "min:1"],
            "cp" => ["nullable", "exists:truck_capacity_types,id"],
            "cg" => ["nullable", "exists:truck_cargo_types,id"],
            "ci" => ["nullable", "exists:companies,id"],
            "co" => ["nullable", "exists:companies,id"],
        ]);

        $query = EmptyTruck::query();
        if($safe_data["dp"] ?? "") {
            $query->where(function($where) use($safe_data) {
                $where->where("departure_prefecture_id", $safe_data["dp"])
                    ->orWhereIn("id", DB::table("around_prefectures")->select("empty_truck_id")->where("prefecture_id", $safe_data["dp"])->where("is_departure", true))
                ;
            });
        }
        if($safe_data["ap"] ?? "") {
            $query->where(function($where) use($safe_data) {
                $where->where("arrival_prefecture_id", $safe_data["ap"])
                    ->orWhereIn("id", DB::table("around_prefectures")->select("empty_truck_id")->where("prefecture_id", $safe_data["ap"])->where("is_departure", false))
                ;
            });
        }
        if($safe_data["ds"] ?? "") {
            $query->whereDate("departure_date", ">=", $safe_data["ds"]);
        }
        if($safe_data["de"] ?? "") {
            $query->whereDate("departure_date", "<=", $safe_data["de"]);
        }
        if($safe_data["as"] ?? "") {
            $query->whereDate("arrival_date", ">=", $safe_data["as"]);
        }
        if($safe_data["ae"] ?? "") {
            $query->whereDate("arrival_date", "<=", $safe_data["ae"]);
        }
        if($safe_data["f"] ?? "") {
            $query->where("fare_amount", "<=", $safe_data["f"]);
        }
        if($safe_data["cp"] ?? "") {
            $query->where("truck_capacity_type_id", $safe_data["cp"]);
        }
        if($safe_data["cg"] ?? "") {
            $query->where("truck_cargo_type_id", $safe_data["cg"]);
        }
        if($safe_data["ci"] ?? "") {
            $query->where("owner_company_id", "<>", $safe_data["ci"]);
        }
        if($safe_data["co"] ?? "") {
            $query->where("owner_company_id", $safe_data["co"]);
        }

        $relations = [
            "owner",
            "departure_prefecture",
            "arrival_prefecture",
            "departure_around_prefectures",
            "arrival_around_prefectures",
            "truck_capacity_type",
            "truck_cargo_type",
        ];
        $empties = $query->with($relations)
            ->where("owner_company_id", "<>", Auth::user()->company_id)
            ->whereDate("departure_date", ">=", Carbon::today())
            ->paginate(20)
        ;

        $prefectures = Prefecture::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();

        return view("user.empty.find", [
            "param" => $safe_data,
            "empties" => $empties,
            "prefectures" => $prefectures,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function posted()
    {
        $empties = Auth::user()->company->emptyTrucks;

        return view("user.empty.posted", [
            "empties" => $empties,
        ]);
    }

    public function create()
    {
        $prefectures = Prefecture::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();

        return view("user.empty.create", [
            "prefectures" => $prefectures,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function store(Request $request)
    {
        $safe_data = $request->validate([
            "departure_date" => ["required", "date", "after_or_equal:today"],
            "departure_time" => ["nullable", "date_format:H:i"],
            "departure_prefecture_id" => ["required", "exists:prefectures,id"],
            "departure_address_1" => ["required", "string"],
            "arrival_date" => ["required", "date", "after_or_equal:departure_date"],
            "arrival_time" => ["nullable", "date_format:H:i"],
            "arrival_prefecture_id" => ["required", "exists:prefectures,id"],
            "arrival_address_1" => ["required", "string"],
            "departure_around_prefecture_ids" => ["nullable", "array"],
            "departure_around_prefecture_ids.*" => ["exists:prefectures,id"],
            "arrival_around_prefecture_ids" => ["nullable", "array"],
            "arrival_around_prefecture_ids.*" => ["exists:prefectures,id"],
            "truck_capacity_type_id" => ["nullable", "exists:truck_capacity_types,id"],
            "truck_cargo_type_id" => ["nullable", "exists:truck_cargo_types,id"],
            "fare_amount" => ["required", "integer", "min:1"],
            "memo" => ["nullable", "string"],
            "contact_name" => ["required", "string"],
        ]);

        $safe_data_collection = collect($safe_data);
        $departure_prefs = $safe_data_collection->pull("departure_around_prefecture_ids");
        $arrival_prefs = $safe_data_collection->pull("arrival_around_prefecture_ids");
        $safe_data = $safe_data_collection->toArray();

        $empty = new EmptyTruck($safe_data);
        $empty->owner_company_id = Auth::user()->company_id;
        $empty->save();
        $empty->syncAroundPrefectures($departure_prefs, $arrival_prefs);

        return back()->with("flush_message", "空車情報を登録しました。");
    }

    public function edit(EmptyTruck $empty)
    {
        abort_unless($empty->owner_company_id == Auth::user()->company_id, 404);

        $prefectures = Prefecture::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();

        return view("user.empty.edit", [
            "empty" => $empty,
            "prefectures" => $prefectures,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function update(Request $request, EmptyTruck $empty)
    {
        abort_unless($empty->owner_company_id == Auth::user()->company_id, 404);

        $safe_data = $request->validate([
            "departure_date" => ["required", "date", "after_or_equal:today"],
            "departure_time" => ["nullable", "date_format:H:i"],
            "departure_prefecture_id" => ["required", "exists:prefectures,id"],
            "departure_address_1" => ["required", "string"],
            "arrival_date" => ["required", "date", "after_or_equal:departure_date"],
            "arrival_time" => ["nullable", "date_format:H:i"],
            "arrival_prefecture_id" => ["required", "exists:prefectures,id"],
            "arrival_address_1" => ["required", "string"],
            "departure_around_prefecture_ids" => ["nullable", "array"],
            "departure_around_prefecture_ids.*" => ["exists:prefectures,id"],
            "arrival_around_prefecture_ids" => ["nullable", "array"],
            "arrival_around_prefecture_ids.*" => ["exists:prefectures,id"],
            "truck_capacity_type_id" => ["nullable", "exists:truck_capacity_types,id"],
            "truck_cargo_type_id" => ["nullable", "exists:truck_cargo_types,id"],
            "fare_amount" => ["required", "integer", "min:1"],
            "memo" => ["nullable", "string"],
            "contact_name" => ["required", "string"],
        ]);

        $safe_data_collection = collect($safe_data);
        $departure_prefs = $safe_data_collection->pull("departure_around_prefecture_ids");
        $arrival_prefs = $safe_data_collection->pull("arrival_around_prefecture_ids");
        $safe_data = $safe_data_collection->toArray();

        $empty->fill($safe_data);
        $empty->save();
        $empty->syncAroundPrefectures($departure_prefs, $arrival_prefs);

        return back()->with("flush_message", "更新しました。");
    }

    public function destroy(EmptyTruck $empty)
    {
        abort_unless($empty->owner_company_id == Auth::user()->company_id, 404);

        $empty->delete();

        return redirect()->route("empty.posted");
    }
}
