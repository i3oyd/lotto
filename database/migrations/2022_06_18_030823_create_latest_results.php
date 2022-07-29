<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest_results', function (Blueprint $table) {
            $table->id();
            $table->string('game')->nullable();
            $table->json('combination')->nullable();
            $table->string('draw_date')->nullable();
            $table->decimal('jackpot',20,2)->nullable();
            $table->integer('winners')->nullable();
            $table->integer('draw_time')->nullable();
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
        Schema::dropIfExists('latest_results');
    }
};
