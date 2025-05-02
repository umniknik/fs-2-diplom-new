<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Seat;
use App\Models\Session;
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

        //Формируем переменную со всеми данными о сеансе, местах и фильме для отправки в представление 
        $filmInfo = [
            'seatsNew' => $seatsNew,
            'idSession' =>  $idSession,
            'idHall' => $idHall,
            'timeSeans' => $timeSeans,
            'filmName' => $filmName,
            'priceRegular' => $priceRegular,
            'priceVip' => $priceVip,
        ];

        return view('hall', compact('filmInfo'));
    }
}