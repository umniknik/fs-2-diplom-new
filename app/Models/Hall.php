<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Можедль создания экзапляра нового зала
 */
class Hall extends Model
{
   // protected $table = 'halls'; это делается автоматически поэтому не надо лишний раз писать т.к. имя таблицы не отличается стандартного

   /**
    * Запись один ко многим значит одна одна запись зала может иметь много связанных записей мест
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Seat, Hall>
    */
   public function seats()
   {
      return $this->hasMany(Seat::class);
   }

   public function sessions()
   {
      return $this->hasMany(Session::class); // один зал может иметь несколько сеансов
   }

}
