<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\EmployeeSize;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function find()
    {
        // TRABOX: 企業検索ページ
        return view("user.company.find", [
            //
        ]);
    }

    public function show(Company $company)
    {
        // TRABOX: 企業検索ページ　＝＞　企業セルをクリックすると出てくるモーダル
        // このページで、企業情報・荷物一覧・空車一覧を３つとも表示する予定。
        // タブ表示着替えにするのか、ただの横並びにするのかは未定。
        return view("user.company.show", [
            //
        ]);
    }

    public function editBasic()
    {
        $prefectures = Prefecture::get();
        // TRABOX: 設定　＝＞　企業情報管理　＝＞　基本情報ページ
        return view("user.company.edit_basic", [
            "company" => Auth::user()->company,
            "prefectures" => $prefectures,
        ]);
    }

    public function updateBasic(Request $request)
    {
        $safe_data = $request->validate([
            "zipcode" => ["required", "string", "min:7"],
            "prefecture_id" => ["required", "exists:prefectures,id"],
            "address_1" => ["required", "string"],
            "address_2" => ["required", "string"],
            "tel" => ["required", "string", "min:10"],
            "fax" => ["required", "string", "min:10"],
            "truck_count" => ["required", "integer", "min:1"],
            "company_web_url" => ["required", "string"],
        ]);

        $company = Auth::user()->company;
        $company->fill($safe_data);
        $company->save();

        return back()->with("flush_message", "保存しました。");
    }

    public function editDetail()
    {
        $employee_sizes = EmployeeSize::get();
        // TRABOX: 設定　＝＞　企業情報管理　＝＞　詳細情報ページ
        return view("user.company.edit_detail", [
            "company" => Auth::user()->company,
            "employee_sizes" => $employee_sizes,
        ]);
    }

    public function updateDetail(Request $request)
    {
        $safe_data = $request->validate([
            "business_content" => ["nullable", "string"],
            "representative_name" => ["nullable", "string"],
            "established_at" => ["nullable", "date"],
            "capital_amount" => ["nullable", "integer", "min:1"],
            "employee_size_id" => ["nullable", "exists:employee_sizes,id"],
            "office_address" => ["nullable", "string"],
            "sales_amount" => ["nullable", "integer", "min:1"],
            "bank_name" => ["nullable", "string"],
            "main_trading_partner_name" => ["nullable", "string"],
            "business_area_name" => ["nullable", "string"],
            "cut_off_day" => ["nullable", "integer", "min:1"],
            "payment_month" => ["nullable", "integer", "min:0"],
            "payment_day" => ["nullable", "integer", "min:1"],
        ]);

        $safe_data["established_at"] = $safe_data["established_at"] ? Carbon::parse($safe_data["established_at"]) : null;

        $company = Auth::user()->company;
        $company->fill($safe_data);
        $company->save();

        return back()->with("flush_message", "保存しました。");
    }

    public function editTrust()
    {
        // TRABOX: 設定　＝＞　企業情報管理　＝＞　信用情報ページ
        return view("user.company.edit_trust", [
            "company" => Auth::user()->company,
        ]);
    }

    public function updateTrust(Request $request)
    {
        $safe_data = $request->validate([
            "union_name" => ["nullable", "string"],
            "government_license_number" => ["nullable", "string"],
            "digi_tacho_count" => ["nullable", "integer", "min:0"],
            "gps_count" => ["nullable", "integer", "min:0"],
            "has_safety_cert" => ["nullable", "boolean"],
            "has_green_cert" => ["nullable", "boolean"],
            "has_iso9000" => ["nullable", "boolean"],
            "has_iso14000" => ["nullable", "boolean"],
            "has_iso39001" => ["nullable", "boolean"],
            "insurance_company_name" => ["nullable", "string"],
        ]);

        $company = Auth::user()->company;
        $company->fill($safe_data);
        $company->save();

        return back()->with("flush_message", "保存しました。");
    }
}
