<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 三ヶ根
        DB::table("companies")->insert([
            "id" => 1,
            "name" => "三ヶ根運輸有限会社",
            "name_hiragana" => "さんがねうんゆゆうげんがいしゃ",
            "zipcode" => "4440116",
            "prefecture_id" => 23,
            "address_1" => "額田郡幸田町",
            "address_2" => "芦谷坂下2-1",
            "tel" => "0564561413",
            "fax" => "0564561414",
            "truck_count" => 78,
            "company_web_url" => "http://www.sangane.com",
            "created_at" => "2014-10-01",
            "updated_at" => "2014-10-01",
        ]);
        DB::table("users")->insert([
            "id" => 1,
            "name" => "牧野 篤人",
            "email" => "info@sangane.com",
            "password" => Hash::make("makimaki"),
            "company_id" => 1,
            "user_role_id" => 1,
            "is_manager" => true,
        ]);
        DB::table("users")->insert([
            "id" => 2,
            "name" => "濱田",
            "email" => "hamada@sangane.com",
            "password" => Hash::make("hamahama"),
            "company_id" => 1,
            "user_role_id" => 2,
            "is_manager" => false,
        ]);

        DB::table("loads")->insert([
            "owner_company_id" => 1,
            "departure_date" => "2022-08-04",
            "departure_time" => null,
            "departure_prefecture_id" => 23,
            "departure_address_1" => "蒲郡市",
            "departure_address_2" => null,
            "arrival_date" => "2022-08-05",
            "arrival_time" => null,
            "arrival_prefecture_id" => 2,
            "arrival_address_1" => "青森市",
            "arrival_address_2" => null,
            "package_content" => "パレット",
            "package_count" => 2,
            "total_cubic_size" => 3.5,
            "total_weight" => 1500,
            "carry_in_driver_work_id" => 1,
            "carry_out_driver_work_id" => null,
            "truck_capacity_type_id" => 3,
            "truck_cargo_type_id" => 18,
            "truck_count" => 1,
            "fare_amount" => 125000,
            "is_highway_fare" => false,
            "memo" => null,
            "is_mixed" => false,
            "is_urgent" => false,
            "is_moved_home" => false,
            "contact_name" => "濱田",
            "is_unsettled" => false,
            "created_at" => "2022-07-25 15:00:00",
            "updated_at" => "2022-07-25 15:00:00",
        ]);

        // Rスクエア
        DB::table("companies")->insert([
            "id" => 2,
            "name" => "合同会社Rスクエア",
            "name_hiragana" => "ごうどうがいしゃあーるすくえあ",
            "zipcode" => "4418029",
            "prefecture_id" => 23,
            "address_1" => "豊橋市",
            "address_2" => "広小路1-18 ユメックスビル8階",
            "tel" => "",
            "fax" => "",
            "truck_count" => 1,
            "company_web_url" => "https://rsquare.co.jp/",
            "created_at" => "2022-06-01",
            "updated_at" => "2022-06-01",
        ]);
        DB::table("users")->insert([
            "id" => 3,
            "name" => "中田",
            "email" => "info@rsquare.co.jp",
            "password" => Hash::make("nakanaka"),
            "company_id" => 2,
            "user_role_id" => 1,
            "is_manager" => true,
        ]);
        DB::table("users")->insert([
            "id" => 4,
            "name" => "加納",
            "email" => "kano@rsquare.co.jp",
            "password" => Hash::make("kanokano"),
            "company_id" => 2,
            "user_role_id" => 2,
            "is_manager" => false,
        ]);

        DB::table("loads")->insert([
            "owner_company_id" => 2,
            "departure_date" => "2022-08-01",
            "departure_time" => "14:00",
            "departure_prefecture_id" => 23,
            "departure_address_1" => "豊橋市",
            "departure_address_2" => null,
            "arrival_date" => "2022-08-02",
            "arrival_time" => null,
            "arrival_prefecture_id" => 28,
            "arrival_address_1" => "姫路市",
            "arrival_address_2" => null,
            "package_content" => "パレット",
            "package_count" => 2,
            "total_cubic_size" => 3.5,
            "total_weight" => 1500,
            "carry_in_driver_work_id" => 1,
            "carry_out_driver_work_id" => null,
            "truck_capacity_type_id" => 3,
            "truck_cargo_type_id" => 18,
            "truck_count" => 1,
            "fare_amount" => 65000,
            "is_highway_fare" => false,
            "memo" => "テストデータ１",
            "is_mixed" => true,
            "is_urgent" => false,
            "is_moved_home" => false,
            "contact_name" => "加納",
            "is_unsettled" => false,
            "created_at" => "2022-07-25 15:00:00",
            "updated_at" => "2022-07-25 15:00:00",
        ]);
        DB::table("loads")->insert([
            "owner_company_id" => 2,
            "departure_date" => "2022-08-04",
            "departure_time" => null,
            "departure_prefecture_id" => 23,
            "departure_address_1" => "豊橋市",
            "departure_address_2" => null,
            "arrival_date" => "2022-08-04",
            "arrival_time" => "20:00",
            "arrival_prefecture_id" => 28,
            "arrival_address_1" => "姫路市",
            "arrival_address_2" => null,
            "package_content" => "パレット",
            "package_count" => 2,
            "total_cubic_size" => 3.5,
            "total_weight" => 1500,
            "carry_in_driver_work_id" => null,
            "carry_out_driver_work_id" => 4,
            "truck_capacity_type_id" => 3,
            "truck_cargo_type_id" => 18,
            "truck_count" => 1,
            "fare_amount" => 70000,
            "is_highway_fare" => false,
            "memo" => "テストデータ２",
            "is_mixed" => false,
            "is_urgent" => false,
            "is_moved_home" => true,
            "contact_name" => "加納",
            "is_unsettled" => false,
            "created_at" => "2022-07-25 15:00:00",
            "updated_at" => "2022-07-25 15:00:00",
        ]);
    }
}
