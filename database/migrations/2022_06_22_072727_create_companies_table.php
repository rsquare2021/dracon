<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("name_hiragana");
            // 基本情報
            $table->string("zipcode");
            $table->unsignedBigInteger("prefecture_id");
            $table->foreign("prefecture_id")->on("prefectures")->references("id");
            $table->string("address_1");
            $table->string("address_2");
            $table->string("tel");
            $table->string("fax");
            $table->integer("truck_count");
            $table->string("company_web_url")->nullable();
            // 詳細情報
            $table->string("business_content")->nullable();
            $table->string("representative_name")->nullable();
            $table->date("established_at")->nullable();
            $table->integer("capital_amount")->nullable();
            $table->unsignedBigInteger("employee_size_id")->nullable();
            $table->foreign("employee_size_id")->on("employee_sizes")->references("id");
            $table->string("office_address")->nullable();
            $table->integer("sales_amount")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("main_trading_partner_name")->nullable();
            $table->string("business_area_name")->nullable();
            $table->integer("cut_off_month")->nullable();
            $table->integer("cut_off_day")->nullable();
            $table->integer("payment_month")->nullable();
            $table->integer("payment_day")->nullable();
            // 信用情報
            $table->string("union_name")->nullable();
            $table->string("government_license_number")->nullable();
            $table->integer("digi_tacho_count")->nullable();
            $table->integer("gps_count")->nullable();
            $table->boolean("has_safety_cert")->default(false);
            $table->boolean("has_green_cert")->default(false);
            $table->boolean("has_iso9000")->default(false);
            $table->boolean("has_iso14000")->default(false);
            $table->boolean("has_iso39001")->default(false);
            $table->string("insurance_company_name")->nullable();
            // お支払い情報
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
