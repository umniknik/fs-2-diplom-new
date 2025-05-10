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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('halls_is_active')->default(false);
            $table->timestamps();
        });

        //Сразу создаем первую запись
        DB::table('settings')->insert([
            'halls_is_active' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
// Создаем первую запись
DB::table('settings')->insert([
    'halls_is_active' => false,
    'created_at' => now(),
    'updated_at' => now()
]);