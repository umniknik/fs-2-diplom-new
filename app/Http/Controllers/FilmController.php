<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    //
    public function createFilm(Request $request)
    {
        ////Обработка постера фильма
        //Проверка наличия файла
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            //Получаем файл
            $file = $request->file('poster');

            //Генерация уникального имени
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Сохраняем файл в папку public/i/posters 
            Storage::disk('public')->putFileAs('posters', $file, $filename);
        }

        // dd($request->input());
        $film = new Film;
        $film->name = $request->input('nameFilm');
        $film->description = $request->input('descriptionFilm');
        $film->img_url = $request->input('imgFilm');
        $film->duration = $request->input('durationFilm');
        $film->start_rent_date = $request->input('startRentFilm');
        $film->end_rent_date = $request->input('endRentFilm');
        $film->img_url = 'i/posters/' . $filename;
        $film->save();

        return redirect()->back()->with('success', 'Фильм создан');
    }

    public function getallfilms()
    {
        $films = Film::all();

        // return view('admin.index', compact('films'));
        return response()->json($films);
    }
}
