<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealtimeCheckingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realtime_checkings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('code');
            $table->integer('price')->nullable();   //現在値
            $table->integer('pre_price')->nullable();   //前回(1分前)現在値
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
        Schema::dropIfExists('realtime_checkings');
    }
}
