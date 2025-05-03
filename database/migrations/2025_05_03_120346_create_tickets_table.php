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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('film_sessions_id')->index();
            $table->foreign('film_sessions_id')->references('id')->on('film_sessions')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('seat_id')->index();
            $table->foreign('seat_id')
                ->references('id')
                ->on('seats')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->boolean('paid')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
