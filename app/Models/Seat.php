<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    /**
     * Значит каждая запись в таблице мест связана с одной записью в таблице залов
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Hall, Seat>
     */
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    } 

}
