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
        Schema::create('lotto_res_642', function (Blueprint $table) {
            $table->id();
            $table->json('combination')->nullable();
            $table->integer('draw_time')->nullable();
            $table->string('draw_date')->nullable();
            $table->decimal('prize',20,2)->nullable();
            $table->integer('winners')->nullable();
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
        Schema::dropIfExists('lotto_res_642');
    }
};
