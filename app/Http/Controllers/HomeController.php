<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Session;
use Illuminate\Http\Request;
use function React\Promise\all;

class HomeController extends Controller
{
    //Метод отображения фильмов на главной странице
    public function index()
    {
        //Получаем сегодняшнюю дату
        // $today = today();
        $today = now()->format('Y-m-d');

        $films = Film::all()->toArray();

        $halls = Hall::all()->toArray();

        //Добавляем в каждый элемент массива фильмов в каждый фильм поле 'залы' со списком всех залов
        foreach ($films as &$film) {

            $film['halls'] = $halls;

            //Добавляем в каждый элемент массива залы поле 'сеансов'
            //Берем только те сеансы, которые содержат id фильмы, id зала, и дату (сегодняшнюю), переделываем в массив и вовзращаем
            foreach ($film['halls'] as &$hall) {
                $hall['sessions'] = Session::
                where('film_id',  $film['id']) 
                ->where('hall_id', $hall['id'])
                ->where('session_date',  $today)
                ->get()
                ->toArray();
            }

        }

     // dd($films, $halls);

        return view('index', compact(var_name: 'films'));
        // return view('index', compact('halls'));
    }

    public function filmsByDate($date) {
      //  dd($date);
        //Получаем сегодняшнюю дату
        // $today = today();
        $today = now()->format('Y-m-d');

        $films = Film::all()->toArray();

        $halls = Hall::all()->toArray();

        //Добавляем в каждый элемент массива фильмов в каждый фильм поле 'залы' со списком всех залов
        foreach ($films as &$film) {

            $film['halls'] = $halls;

            //Добавляем в каждый элемент массива залы поле 'сеансов'
            //Берем только те сеансы, которые содержат id фильмы, id зала, и дату (сегодняшнюю), переделываем в массив и вовзращаем
            foreach ($film['halls'] as &$hall) {
                $hall['sessions'] = Session::
                where('film_id',  $film['id']) 
                ->where('hall_id', $hall['id'])
                ->where('session_date',  $date)
                ->get()
                ->toArray();
            }

        }

     // dd($films, $halls);

        return view('index', compact(var_name: 'films'));
    }
}
