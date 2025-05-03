<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //Метод отображения заказа на старнице ticket
    public function showTicket(Request $request)
    {
        //Берем переданные значения из запроса
        $idHall = $request->input('idHall');
        $idSession = $request->input('idSession');
        $filmName = $request->input('filmName');
        $timeSeans = $request->input('timeSeans');
        $ticketCost = $request->input('ticketCost');
        //Получаем места в виде строки
        $orderSeats = $request->input('orderSeats');

        //Переменная для передачи в представление на страницу ticket
        $ticketInfo = [
            'idHall' => $idHall,
            'orderSeats' => $orderSeats,
            'timeSeans' => $timeSeans,
            'filmName' => $filmName,
            'ticketCost' => $ticketCost,
        ];

        //Переделываем строку мест в массив
        $arrSeatsOrderStr = explode(',', $orderSeats);
        //Приводим элементы мыссива из строк в числа
        $arrSeatsOrder = array_map('intval', $arrSeatsOrderStr);

        //Проходимся по каждому заказанному месту и создаем запись в таблице билетов
        foreach ($arrSeatsOrder as $idSeat) {
            //Создаем новую запись в таблице билетов
            $ticket = new Ticket();
            $ticket->user_id = 1;
            $ticket->film_sessions_id = $idSession;
            $ticket->seat_id = $idSeat;
            $ticket->paid = true;

            $ticket->save();
        };

        // dd($ticketInfo);

        return view('ticket', compact('ticketInfo'));
    }
}

// "_token" => "cqDU5FMOeQvSKwXUXyZuuaaMhoehPIzdCaIDxe1c"
// "idHall" => "1"
// "filmName" => "Аватар"
// "idSession" => "186"
// "orderSeats" => "8,9"
// "timeSeans" => "09:15"
// "ticketCost" => "300"


// "idHall" => "1"
// "orderSeats" => "8,9"
// "timeSeans" => "09:15"
// "filmName" => "Аватар"
// "ticketCost" => "300"