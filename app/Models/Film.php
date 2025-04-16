<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    //
    public function sessions()
    {
       return $this->hasMany(Session::class);
    }

    //Эта связь многие ко многим, здесь мы через таблицу filmsessions возвращаем все залы связынные с конкретным фильмом (для главной страницы)
    public function halls()
    {
        return $this->belongsToMany(Hall::class, 'film_sessions', 'film_id', 'hall_id');
    }

    protected $fillable = [
        'name',
        'description',
        'img_url',
        'duration',
        'start_rent_date',
        'end_rent_date'
    ];

}
