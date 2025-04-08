<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    //Метод создания и обновления записей мест в таблице seast
    public function createSeats(Request $request)
    {
        //Берем массив мест из запроса
        $arraySeats = json_decode($request->input('arraySeats'), true);       

        //проходимся по полученному массиву мест 
        foreach ($arraySeats as $seatFromArray) {
            $seat = Seat::find($seatFromArray['id']);
            if (!$seat) { // Если запись с таким id не найдена
                $seat = new Seat(); // Создаем новый экземпляр
            }
        
            //Заполняем переданные из формы данные в свойства экземпляра места
            $seat->id = $seatFromArray['id'];
            $seat->row_number = $seatFromArray['row_number'];
            $seat->seats_number = $seatFromArray['seats_number'];
            $seat->type = $seatFromArray['type'];
            $seat->hall_id = $request->input('idHall');
            $seat->save();
        }

        // dd($rows, $seats_per_row);
        return redirect()->back()->with('success', 'Места создаы:');
    }   

    //Метод получения из базы данных мест по id зала 
    public function getSeatsByHallId($idHall)
    {
        //Получаем все места для указанного зала
        $seats = Seat::where('hall_id', $idHall)->get();

        return response()->json($seats);

    }
}
