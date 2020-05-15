<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->unique();
            $table->string('name');
            $table->integer('market_id');
            $table->integer('industry_id');
            //minitly check
            $table->integer('price')->nullable();
            $table->float('rate')->nullable();
            //daily check
            $table->integer('pre_end_price')->nullable();
            $table->integer('start_price')->nullable();
            $table->integer('end_price')->nullable();
            $table->integer('highest_price')->nullable();
            $table->integer('lowest_price')->nullable();
            $table->integer('volume')->nullable();
            
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
        Schema::dropIfExists('stocks');
    }
}
