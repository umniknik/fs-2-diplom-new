<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('film_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->foreign('film_id')->references('id')->on('films');

            $table->unsignedBigInteger('hall_id'); // Поле для хранения ID зала
            $table->foreign('hall_id')->references('id')->on('halls'); // Связь с таблицей halls

            $table->time('start_time'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_sessions');
    }
};
