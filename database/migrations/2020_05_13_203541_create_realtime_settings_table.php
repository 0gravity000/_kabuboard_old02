<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealtimeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realtime_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('code_id');
            $table->integer('upperlimit')->nullable();  //上限値
            $table->dateTime('upperlimit_settingat')->nullable();
            $table->integer('lowerlimit')->nullable();  //下限値
            $table->dateTime('lowerlimit_settingat')->nullable();
            $table->float('changerate')->nullable();    //変化率
            $table->dateTime('changerate_changerate')->nullable();
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
        Schema::dropIfExists('realtime_settings');
    }
}
