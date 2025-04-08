<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

/**
 * контроллер с функцикй createHall для создания записи нового зала в таблице halls базы данных и функцией showAllHalls отобаржения всех залов
 */

class HallController extends Controller
{
    public function createHall(Request $request)
    {
        //Автоматически генерируем часть имени нового зала
        $lastHall = Hall::orderBy('id', 'desc')->first();  //сортируем все залы в таблице и берем последний созданный
        $hallNumber = $lastHall ? $lastHall->id + 1 : 1;  //если последний зал существует, то просто прибавляем к id 1 это будет номер нового зала

        //Создаем новый зал
        $hall = new Hall();
        $hall->name = "Зал $hallNumber";
        $hall->save();

        return redirect()->back()->with('success', 'Зал создан:' . $hall->name);

    }

    //метод получения всех залов и передачи их на страницу администрирования зало
    public function showAllHalls()
    {
        $halls = Hall::all();  //получаем все записи из таблицы halls

        return view('admin.index', compact('halls'));
    }

    //метод получения всех залов и передачи их на страницу администрирования зало
    public function showAllHallss()
    {
        $halls = Hall::all();  //получаем все записи из таблицы halls

        return response()->json($halls);
        // return view('admin.index', compact('halls'));
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();

        // return redirect()->back()->with('success', 'Зал успешно удалён.');
        return response()->json(['message' => 'Зал успешно удалён'], 200);
    }
}
