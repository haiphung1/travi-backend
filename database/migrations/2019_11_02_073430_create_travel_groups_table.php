<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner_id');
            $table->dateTime('planning_from');
            $table->dateTime('planning_to');
            $table->dateTime('travel_time_from');
            $table->dateTime('travel_time_to');
            $table->integer('max_member');
            $table->string('title');
            $table->text('description');
            $table->integer('created_by');
            $table->string('start_place');
            $table->float('start_place_lat', 10, 6);
            $table->float('start_place_lng', 10, 6);
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
        Schema::dropIfExists('travel_groups');
    }
}
