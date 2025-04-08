<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('film_sessions', function (Blueprint $table) {
            $table->date('session_date')->nullable()->after('hall_id'); // Добавление нового поля 'session_date' после hall_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('film_sessions', function (Blueprint $table) {
            $table->dropColumn('session_date'); // Удаление поля при откате миграции
        });
    }
};
