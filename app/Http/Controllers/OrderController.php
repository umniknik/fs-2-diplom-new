<?php

namespace App\Http\Controllers;

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

        //Формируем переменную со всеми данными о сеансе, местах и фильме для отправки в представление 
        $filmInfo = [
            'seatsNew' => $seatsNew,
            'idHall' => $idHall,
            'timeSeans' => $timeSeans,
            'filmName' => $filmName,
        ];

        return view('hall', compact('filmInfo'));
        //   return response()->json($seats);
    }
    // return view('admin.index', compact('halls'));
}

// "id" => 24
// "row_number" => 4
// "seats_number" => 6
// "type" => "regular"
// "price" => null
// "hall_id" => 1
// "created_at" => "2025-03-18T16:16:19.000000Z"
// "updated_at" => "2025-03-18T16:16:19.000000Z"