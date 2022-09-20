<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmptyTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empty_trucks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("owner_company_id");
            $table->foreign("owner_company_id")->on("companies")->references("id");
            $table->date("departure_date");
            $table->time("departure_time")->nullable();
            $table->unsignedBigInteger("departure_prefecture_id");
            $table->foreign("departure_prefecture_id")->on("prefectures")->references("id");
            $table->string("departure_address_1");
            $table->date("arrival_date");
            $table->time("arrival_time")->nullable();
            $table->unsignedBigInteger("arrival_prefecture_id");
            $table->foreign("arrival_prefecture_id")->on("prefectures")->references("id");
            $table->string("arrival_address_1");
            $table->unsignedBigInteger("truck_capacity_type_id")->nullable();
            $table->foreign("truck_capacity_type_id")->on("truck_capacity_types")->references("id");
            $table->unsignedBigInteger("truck_cargo_type_id")->nullable();
            $table->foreign("truck_cargo_type_id")->on("truck_cargo_types")->references("id");
            $table->integer("fare_amount");
            $table->string("contact_name");
            $table->string("memo")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empty_trucks');
    }
}
