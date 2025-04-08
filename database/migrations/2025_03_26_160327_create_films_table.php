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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->string('img_url')->nullable(true);
            $table->integer('duration')->nullable(true);
            $table->date('start_rent_date')->nullable(true);
            $table->date('end_rent_date')->nullable(true);
            $table->timestamps();
        });
    }
          
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
