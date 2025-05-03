<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Seat;
use App\Models\Session;
use App\Models\Ticket;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Метод отображения мест в зале на лицевой части
    public function showHall($idHall, $idSession)
    {
        //Получаем все места для указанного зала
        $seats = Seat::where('hall_id', $idHall)->get()->toArray();

        //Переделываем массив мест для удобного чтения в представлении
        //Берем последний элемент массива, он содержит количество мест и рядов в зале
        $lastSeats = $seats[array_key_last($seats)];

        $countRow = $lastSeats['row_number'];
        $countSeatsInRow = $lastSeats['seats_number'];

        $seatsNew = [];

        $number = 0;
        // dd($lastSeats[$number]);

        for ($i = 0; $i < $countRow; $i++) {
            $seatsInRow = [];
            for ($j = 0; $j < $countSeatsInRow; $j++) {
                $seatsInRow[] = $seats[$number];
                $number++;
            }
            $seatsNew[] = $seatsInRow;
        }

        //Получаем время сеанса
        $seans = Session::findOrFail($idSession);
        $timeSeans = $seans->start_time;

        //Получаем название фильма
        $filmName = $seans->film->name;

        //Получаем стоимость мест
        $priceRegular = Price::where('hall_id', $idHall)->where('type', 'regular')->first()->price;
        $priceVip = Price::where('hall_id', $idHall)->where('type', 'vip')->first()->price;

        //Получаем из таблицы билетов все занятые места на этот сеанс
        $buyingSeats = Ticket::where('film_sessions_id', $idSession)->pluck('seat_id')->toArray() ;
        // dd($buyingSeats);
        //Ищем в массиве всех мест зала те, которые уже куплены и меняем их тип на 'buying'
        foreach($seatsNew as &$row) {
            foreach($row as &$seat) {
                if (in_array($seat['id'], $buyingSeats)) {
                    $seat['type'] = 'buying';
                }
            }
        }

        // dd($seatsNew);

        //Формируем переменную со всеми данными о сеансе, местах и фильме для отправки в представление 
        $filmInfo = [
            'seatsNew' => $seatsNew,
            'idSession' =>  $idSession,
            'idHall' => $idHall,
            'timeSeans' => $timeSeans,
            'filmName' => $filmName,
            'priceRegular' => $priceRegular,
            'priceVip' => $priceVip,
            'buyingSeats' => $buyingSeats,
        ];

        // dd($buyingSeats , $seatsNew);

        return view('hall', compact('filmInfo'));
    }
}