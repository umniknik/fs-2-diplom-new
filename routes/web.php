<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [HomeController::class, 'index']);

//Маршрут загрузки фильмов на главной по датам
Route::get('/movies/{data}', [HomeController::class, 'filmsByDate']);

//Маршрут перехода на страницу выбора мест в зале после клика по сеансу
Route::get('hall/{hallId}/{sessionId}', [OrderController::class, 'showHall']);


// Route::get('hall', function() {
//     return view('hall');
// } );

Route::get('payment', [PaymentController::class, 'showOrder']);

Route::get('ticket', [TicketController::class, 'showTicket']);

// Route::get('admin', function() {
//     return view('admin.index');
// });
Route::get('admin', function () {
    return view('admin.index');
})->name('admin');

//Роутер создания нового зала
Route::post('create-hall', [HallController::class, 'createHall']);
// Route::post('/create-hall', 'HallController@createHall');  // такая запись не работает, похоже устарела

//Роутер отображения всех залов на странице администрирования залов
Route::get('admin', [HallController::class, 'showAllHalls']);

//Роутер отображения всех залов на странице администрирования залов
Route::get('api/get-all-halls', [HallController::class, 'showAllHallss']);

// Route::post('delete-hall', [HallController::class, 'destroy']);
Route::delete('/delete-hall/{hall}', [HallController::class, 'destroy'])->name('hall.destroy');

Route::post('create-seats', [SeatController::class, 'createSeats']);

//Маршрут получаения всех мест в зале по id зала
Route::get('/api/halls/{hallId}/seats', [App\Http\Controllers\SeatController::class, 'getSeatsByHallId']);

//Маршрут для создания новых записей цен на места
Route::post('create-prices', [PricesController::class, 'createPrices']);

//Маршрут получаения всех цен на места в зале по id зала
Route::get('/api/halls/{hallId}/prices', [App\Http\Controllers\PricesController::class, 'getPricesByHallId']);

//Маршрут для создания нового фильма 
Route::post('create-film', [FilmController::class, 'createFilm']);

//Маршрут для получения из базы данных всех фильмов
Route::get('api/get-all-films', [FilmController::class, 'getallfilms']);

//Маршрут для добавления нового сенсана фильма
Route::post('create-session', [SessionController::class, 'createSession']);

//Маршрут получаения всех сеансов в зале по id зала
Route::get('/api/halls/{hallId}/seanses', [App\Http\Controllers\SessionController::class, 'getSeansesByHallId']);

//Маршрут удаления фильма
Route::post('/delete-session', [SessionController::class, 'deleteSession']);

//Маршрут Удаление фильма 
Route::post('delete-film',[FilmController::class, 'deleteFilm']);
// Route::delete('/delete-film/{film}', [FilmController::class, 'destroy'])->name('film.destroy');

//Маршрут для получения значения открыта ли продажа билетов
Route::get('/api/halls-is-active', [SettingController::class, 'hallsIsActive']);

//Маршрут изменения значения, чтобы открыть или закрыть продажу билетов
Route::post('/api/halls-is-active', [SettingController::class, 'changeHallsIsActive']);

//Маршрут загрузки всех фильмов на главную страницу
Route::post('/',[FilmController::class, 'allFilm']);
// Route::delete('/delete-film/{film}', [FilmController::class, 'destroy'])->name('film.destroy');


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
