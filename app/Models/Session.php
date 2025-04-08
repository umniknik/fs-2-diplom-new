<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'film_sessions';
    public function film()
    {
        return $this->belongsTo(Film::class);
    } 

    public function hall()
    {
        return $this->belongsTo(Hall::class); //значит каждый сеанс принадлежит одному залу
    }
}
