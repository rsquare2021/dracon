<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("user_name");
            $table->string("user_email");
            $table->string("user_password");
            $table->string("company_tel");
            $table->string("company_fax");
            $table->string("company_name");
            $table->string("zipcode");
            $table->unsignedBigInteger("prefecture_id");
            $table->foreign("prefecture_id")->on("prefectures")->references("id");
            $table->string("address_1");
            $table->string("address_2");
            $table->integer("truck_count");
            $table->string("introducer_name")->nullable();
            $table->string("company_web_url")->nullable();
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
        Schema::dropIfExists('account_registrations');
    }
}
