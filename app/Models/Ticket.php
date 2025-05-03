<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //Массив защищенных полей, чтобы избежать массового присваивания значений
    protected $fillable = [
        'user_id',
        'film_sessions_id',
        'seat_id',
        'paid'
    ];
}
