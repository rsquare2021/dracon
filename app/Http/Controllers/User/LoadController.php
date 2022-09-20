<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DriverWork;
use App\Models\Load;
use App\Models\Prefecture;
use App\Models\TruckCapacityType;
use App\Models\TruckCargoType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadController extends Controller
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
            "cp_ia" => ["nullable", "boolean"],
            "cg" => ["nullable", "exists:truck_cargo_types,id"],
            "cg_ia" => ["nullable", "boolean"],
            "xo" => ["nullable", "boolean"],
            "xi" => ["nullable", "boolean"],
            "mo" => ["nullable", "boolean"],
            "mi" => ["nullable", "boolean"],
            "l" => ["nullable", "exists:loads,id"],
            "ci" => ["nullable", "exists:companies,id"],
            "co" => ["nullable", "exists:companies,id"],
        ]);

        $query = Load::query();
        if($safe_data["dp"] ?? "") {
            $query->where("departure_prefecture_id", $safe_data["dp"]);
        }
        if($safe_data["ap"] ?? "") {
            $query->where("arrival_prefecture_id", $safe_data["ap"]);
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
            $query->where("fare_amount", ">=", $safe_data["f"]);
        }
        if($safe_data["cp"] ?? "") {
            $query->where("truck_capacity_type_id", $safe_data["cp"]);
        }
        if($safe_data["cp_ia"] ?? "") {
            $query->whereNotNull("truck_capacity_type_id");
        }
        if($safe_data["cg"] ?? "") {
            $query->where("truck_cargo_type_id", $safe_data["cg"]);
        }
        if($safe_data["cg_ia"] ?? "") {
            $query->whereNotNull("truck_cargo_type_id");
        }
        if($safe_data["xo"] ?? "") {
            $query->where("is_mixed", true);
        }
        if($safe_data["xi"] ?? "") {
            $query->where("is_mixed", false);
        }
        if($safe_data["mo"] ?? "") {
            $query->where("is_moved_home", true);
        }
        if($safe_data["mi"] ?? "") {
            $query->where("is_moved_home", false);
        }
        if($safe_data["l"] ?? "") {
            $query->where("id", $safe_data["l"]);
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
            "carry_in_driver_work",
            "carry_out_driver_work",
            "truck_capacity_type",
            "truck_cargo_type",
        ];
        $loads = $query->ignoreOwner(Auth::user())->hasnotContract()->with($relations)->paginate(20);
        $prefectures = Prefecture::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();

        // TRABOX: 荷物検索ページ
        // 荷物の住所２は表示しないようにする。
        return view("user.load.find", [
            "param" => $safe_data,
            "loads" => $loads,
            "prefectures" => $prefectures,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function show($load_id)
    {
        $load = Load::with([
                "owner",
                "departure_prefecture",
                "arrival_prefecture",
                "carry_in_driver_work",
                "carry_out_driver_work",
                "truck_capacity_type",
                "truck_cargo_type",
            ])
            ->withTrashed()
            ->findOrFail($load_id)
        ;

        if($load->owner_company_id == Auth::user()->company_id) {
            abort_if($load->trashed(), 404);
            return view("user.load.show_mine", [
                "load" => $load,
            ]);
        }
        else {
            if($load->accessed_users) {
                if(!in_array(Auth::user()->id, $load->accessed_users)) {
                    // $load->accessed_users[] = Auth::user()->id;
                    $load->save();
                }
            }
            else {
                $load->accessed_users = [Auth::user()->id];
                $load->save();
            }
            return view("user.load.show_other", [
                "load" => $load,
            ]);
        }
    }

    public function create(Request $request)
    {
        // クエリストリングで指定された荷物を初期値としてコピーする。
        $load = new Load();
        if($load_id = $request->l) {
            $tmp = Load::find($load_id);
            if($tmp && $tmp->owner_company_id == Auth::user()->company_id) {
                $load = $tmp;
            }
        }

        $prefectures = Prefecture::get();
        $driver_works = DriverWork::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();

        // TRABOX: 荷物登録ページ
        // 発着日時の設定が固まってない。　＝＞　発日時の開始/終了、着日時の開始/終了の４つにする。
        // 住所１は、市または東京23区のような大まかな住所まで入力してもらう。
        // 住所２は、番地まで入力してもらう。必須項目にする。
        // 荷姿は、ラジオボタン廃止。詳細入力を表示する。
        // 荷物の体積は設定が固まってない。
        return view("user.load.make", [
            "is_create" => true,
            "load" => $load,
            "prefectures" => $prefectures,
            "driver_works" => $driver_works,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function store(Request $request)
    {
        $safe_data = $this->validateMakeRequest($request);

        $load = new Load($safe_data);
        $load->owner_company_id = Auth::user()->company_id;
        $load->save();

        return back()->with("flush_message", "荷物を登録しました。");
    }

    public function edit(Load $load)
    {
        abort_unless($load->owner_company_id == Auth::user()->company_id, 404);

        $prefectures = Prefecture::get();
        $driver_works = DriverWork::get();
        $truck_capacity_types = TruckCapacityType::get();
        $truck_cargo_types = TruckCargoType::get();
        // TORABOX: マイ荷物・成約ページ　＝＞　募集中タブ　＝＞　荷物明細の変更ボタンをクリック
        return view("user.load.make", [
            "is_create" => false,
            "load" => $load,
            "prefectures" => $prefectures,
            "driver_works" => $driver_works,
            "truck_capacity_types" => $truck_capacity_types,
            "truck_cargo_types" => $truck_cargo_types,
        ]);
    }

    public function update(Request $request, Load $load)
    {
        abort_unless($load->owner_company_id == Auth::user()->company_id, 404);

        $safe_data = $this->validateMakeRequest($request);

        $load->update($safe_data);

        return back()->with("flush_message", "荷物情報を変更しました。");
    }

    public function destroy(Load $load)
    {
        abort_unless($load->owner_company_id == Auth::user()->company_id, 404);

        $load->delete();
        return back();
    }

    private function validateMakeRequest($request)
    {
        return $request->validate([
            "departure_date" => ["required", "date", "after_or_equal:today"],
            "departure_time" => ["nullable", "date_format:H:i"],
            "departure_prefecture_id" => ["required", "exists:prefectures,id"],
            "departure_address_1" => ["required", "string"],
            "departure_address_2" => ["nullable", "string"],
            "arrival_date" => ["required", "date", "after_or_equal:departure_date"],
            "arrival_time" => ["nullable", "date_format:H:i"],
            "arrival_prefecture_id" => ["required", "exists:prefectures,id"],
            "arrival_address_1" => ["required", "string"],
            "arrival_address_2" => ["nullable", "string"],
            "package_content" => ["required", "string"],
            "package_count" => ["nullable", "integer", "min:1"],
            "total_cubic_size" => ["nullable", "numeric", "min:0.1"],
            "total_weight" => ["nullable", "integer", "min:1"],
            "carry_in_driver_work_id" => ["nullable", "exists:driver_works,id"],
            "carry_out_driver_work_id" => ["nullable", "exists:driver_works,id"],
            "truck_capacity_type_id" => ["nullable", "exists:truck_capacity_types,id"],
            "truck_cargo_type_id" => ["nullable", "exists:truck_cargo_types,id"],
            "truck_count" => ["required", "integer", "min:1"],
            "fare_amount" => ["required", "integer", "min:1"],
            "is_highway_fare" => ["required", "boolean"],
            "memo" => ["nullable", "string"],
            "is_urgent" => ["nullable", "boolean"],
            "is_moved_home" => ["nullable", "boolean"],
            "is_mixed" => ["nullable", "boolean"],
            "contact_name" => ["required", "string"],
            "is_unsettled" => ["nullable", "boolean"],
        ]);
    }
}
