<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAroundPrefecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('around_prefectures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("empty_truck_id");
            $table->foreign("empty_truck_id")->on("empty_trucks")->references("id")->onDelete("cascade");
            $table->unsignedBigInteger("prefecture_id");
            $table->foreign("prefecture_id")->on("prefectures")->references("id");
            $table->boolean("is_departure");
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
        Schema::dropIfExists('around_prefectures');
    }
}
