<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    //
    public function createFilm(Request $request) 
    {
       // dd($request->input());

        $film = new Film;
        $film->name = $request->input('nameFilm');
        $film->description = $request->input('descriptionFilm');
        $film->img_url = $request->input('imgFilm');
        $film->duration = $request->input('durationFilm');
        $film->start_rent_date = $request->input('startRentFilm');
        $film->end_rent_date = $request->input('endRentFilm');
        $film->save();

        return redirect()->back()->with('success','Фильм создан');
    }

    public function getallfilms() {
        $films = Film::all();

       // return view('admin.index', compact('films'));
       return response()->json($films);
    }
}
