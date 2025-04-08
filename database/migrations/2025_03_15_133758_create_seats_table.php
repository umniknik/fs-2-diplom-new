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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->integer('row_number')->unsigned()->nullable(); //номер ряда
            $table->integer('seats_number')->unsigned()->nullable();  // номер места в ряду
            $table->enum('type', ['regular', 'vip', 'blocked'])->default('regular'); //тип кресла
            $table->decimal('price', 8, 2)->nullable(); //цена билета на это кресло            
            $table->foreignId('hall_id')->constrained('halls')->onDelete('cascade'); //ссылка на зал
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
