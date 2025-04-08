<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // Значит каждая запись в таблице мест связана с одной записью в таблице залов
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    } 

    protected $fillable = [
        'hall_id',
        'type',
        'price'
    ];
}
