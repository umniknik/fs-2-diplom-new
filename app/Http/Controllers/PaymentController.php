<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Seat;
use App\Models\Session;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
     /**
     * Перенаправление на авторизацию.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Метод отображения заказа на старнице payment
    public function showOrder(Request $request)
    {
        //dd($request->input());
        $idHall = $request->input('idHall');
        $idSession = $request->input('idSession');

        //Получаем места в виде строки
        $orderSeats = $request->input('orderSeats');
        //Переделываем строку в массив
        $arrSeatsOrderStr = explode(',', $orderSeats);
        //Приводим элементы мыссива из строк в числа
        $arrSeatsOrder = array_map('intval', $arrSeatsOrderStr);

        $ticketCost = 0;

        //Подсчитываем итоговую стоимость всех мест из заказа
        foreach ($arrSeatsOrder as $idSeat) {
            //Получае тип места
            $type = Seat::where('id', $idSeat)->first()->type;

            //Получаем стоимость места
            $price = Price::where('hall_id', $idHall)->where('type', $type)->first()->price;

            $ticketCost += $price;

        };

        //Получаем время сеанса
        $seans = Session::findOrFail($idSession);
        $timeSeans = $seans->start_time;

        //Получаем название фильма
        $filmName = $seans->film->name;



        $paymentInfo = [
            'idHall' => $idHall,
            'orderSeats' => $orderSeats,
            'idSession' => $idSession,
            'timeSeans' => $timeSeans,
            'filmName' => $filmName,
            'ticketCost' => $ticketCost,
            'arrSeatsOrder'=> $arrSeatsOrder,
        ];

        return view('payment', compact('paymentInfo'));


    }
}

// array:4 [▼ // app\Http\Controllers\PaymentController.php:12
//   "_token" => "cqDU5FMOeQvSKwXUXyZuuaaMhoehPIzdCaIDxe1c"
//   "idHall" => "1"
//   "idSession" => "246"
//   "orderSeats" => "8,9"
// ]