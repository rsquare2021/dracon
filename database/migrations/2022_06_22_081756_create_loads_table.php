<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("owner_company_id");
            $table->foreign("owner_company_id")->on("companies")->references("id");
            $table->date("departure_date");
            $table->time("departure_time")->nullable();
            $table->unsignedBigInteger("departure_prefecture_id");
            $table->foreign("departure_prefecture_id")->on("prefectures")->references("id");
            $table->string("departure_address_1");
            $table->string("departure_address_2")->nullable();
            $table->date("arrival_date");
            $table->time("arrival_time")->nullable();
            $table->unsignedBigInteger("arrival_prefecture_id");
            $table->foreign("arrival_prefecture_id")->on("prefectures")->references("id");
            $table->string("arrival_address_1");
            $table->string("arrival_address_2")->nullable();
            $table->string("package_content");
            $table->integer("package_count")->nullable();
            $table->float("total_cubic_size")->nullable();
            $table->integer("total_weight")->nullable();
            $table->unsignedBigInteger("carry_in_driver_work_id")->nullable();
            $table->foreign("carry_in_driver_work_id")->on("driver_works")->references("id");
            $table->unsignedBigInteger("carry_out_driver_work_id")->nullable();
            $table->foreign("carry_out_driver_work_id")->on("driver_works")->references("id");
            $table->unsignedBigInteger("truck_capacity_type_id")->nullable();
            $table->foreign("truck_capacity_type_id")->on("truck_capacity_types")->references("id");
            $table->unsignedBigInteger("truck_cargo_type_id")->nullable();
            $table->foreign("truck_cargo_type_id")->on("truck_cargo_types")->references("id");
            $table->integer("truck_count");
            $table->integer("fare_amount");
            $table->boolean("is_highway_fare");
            $table->string("memo")->nullable();
            $table->boolean("is_mixed")->default(false);
            $table->boolean("is_urgent")->default(false);
            $table->boolean("is_moved_home")->default(false);
            $table->string("contact_name");
            $table->boolean("is_unsettled")->default(false);
            $table->json("accessed_users")->nullable();
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
        Schema::dropIfExists('loads');
    }
}
