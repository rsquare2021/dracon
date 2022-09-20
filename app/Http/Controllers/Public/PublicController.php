<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AccountRegistration;
use App\Models\Company;
use App\Models\Prefecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicController extends Controller
{
    public function register()
    {
        $prefectures = Prefecture::get();
        return view("public.register", [
            "prefectures" => $prefectures,
        ]);
    }

    public function record(Request $request)
    {
        $safe_data = $request->validate([
            "user_name" => ["required", "string"],
            "user_email" => ["required", "string"],
            "user_password" => ["required", "string", "min:8"],
            "company_tel" => ["required", "string"],
            "company_fax" => ["required", "string"],
            "company_name" => ["required", "string"],
            "zipcode" => ["required", "string"],
            "prefecture_id" => ["required", "integer", "exists:prefectures,id"],
            "address_1" => ["required", "string"],
            "address_2" => ["required", "string"],
            "truck_count" => ["required", "integer", "min:0"],
            "introducer_name" => ["nullable", "string"],
            "company_web_url" => ["nullable", "string"],
        ]);

        $safe_data["user_password"] = Hash::make($safe_data["user_password"]);
        AccountRegistration::create($safe_data);

        return back();
    }

    public function test_createAccount(AccountRegistration $registration)
    {
        abort_if($registration->same_email_users->isNotEmpty(), 403);

        DB::transaction(function() use($registration) {
            $company = Company::create([
                "name" => $registration->company_name,
                "name_hiragana" => "",
                "zipcode" => $registration->zipcode,
                "prefecture_id" => $registration->prefecture_id,
                "address_1" => $registration->address_1,
                "address_2" => $registration->address_2,
                "tel" => $registration->company_tel,
                "fax" => $registration->company_fax,
                "truck_count" => $registration->truck_count,
                "company_web_url" => $registration->company_web_url,
            ]);
            $user = User::create([
                "name" => $registration->user_name,
                "email" => $registration->user_email,
                "password" => $registration->user_password,
                "company_id" => $company->id,
                "user_role_id" => 1,
                "is_manager" => true,
            ]);
        });
    }
}
