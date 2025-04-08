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

    protected $fillable = [
        'name',
        'description',
        'img_url',
        'duration',
        'start_rent_date',
        'end_rent_date'
    ];

}
