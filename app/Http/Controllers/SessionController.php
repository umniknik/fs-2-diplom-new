<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
  //
  public function createSession(Request $request)
  {
    //Получаем даные старта и конца фильма и зала для сеансов
    $hall_id = $request->input('hall');
    $film_id = $request->input('film');

    //Получаем временной диапазон начала и конца сеанса в минутах от начала дня
    $rangeA = $this->toMinute($request->input('start_time'), $film_id);

    //Получаем все сеансы в указанный день в выбранном зале
    $seansesForChek = Session::whereDate('session_date', today())->where('hall_id', $hall_id)->get();

    //Проверяем есть ли сеансы в этот день
    if (!$seansesForChek->isEmpty()) { //если в этот день есть сеансы, т.е. он не пустой, то ....

      //Делаем проверку на пересечение деапазонов для каждого сеанса в этот день
      foreach ($seansesForChek as $ell) {
        //Получаем диапазон следующего сеанса из базы данных
        $rangeB = $this->toMinute($ell->start_time, $ell->film_id);

        // Проверка пересечения
        if (
            // Проверка, входит ли начало одного диапазона в другой
          ($rangeA[0] >= $rangeB[0] && $rangeA[0] <= $rangeB[1]) ||
          ($rangeA[1] >= $rangeB[0] && $rangeA[1] <= $rangeB[1]) ||

            //Проверка, входит ли начало второго диапазона в первый
          ($rangeB[0] >= $rangeA[0] && $rangeB[0] <= $rangeA[1]) ||
          ($rangeB[1] >= $rangeA[0] && $rangeB[1] <= $rangeA[1])
        ) {

          // return response()->json(['message' => 'Диапазоны пересекаются'], 200);

        //  return redirect()->back()->with('error', 'Диапазоны пересекаются'); 
          // return response()->json(['message' => 'Диапазоны пересекаются'], 400);
          // return redirect()->back()->withInput()->with('error', 'Диапазоны пересекаются');
          // return redirect()->route('admin')->withErrors(['error' => 'Диапазоны пересекаются']);
          // dd($rangeA, $rangeB, "Диапазоны пересекаются");
          //////////////// Выкидываем сообщение
          /////////////// Не удается выкинуть сообщение 
          return redirect('/admin?error=Диапазоны+сеансов+пересекаются'); // - только этот способ работает
        }
      }
    }

    //Проверка пройдены диапазоны сеансов не пересекаются, можно создавать новый сеанс
    // dd($rangeA, $rangeB, "Диапазоны не пересекаются");  
    $startDate = today(); //получаем сегодняшну дату
    $daysInMonth = today()->daysInMonth(); //получаем количество дней в данном месяце

    //Создаемся сеансы по этому времени на месяц вперед, значит прокат фильма будет месяц
    for ($i = 0; $i <= $daysInMonth; $i++) {
      $startDate = today();
      $session = new Session();
      $session->hall_id = $request->input('hall');
      $session->film_id = $request->input('film');
      $session->start_time = $request->input('start_time');
      $session->session_date = $startDate->addDays($i)->format('Y-m-d');

      $session->save();
    }

    return redirect()->back()->with('success', 'Сеанс успешно добавлен');
  }

  //Ф-ия перевода времени в минуты от начала дня
  private function toMinute($time, $film_id)
  {
    //Получаем длительность фильма
    $filmDuration = Film::find($film_id)->duration;
    //Переводим начало сеанса в минуты 
    list($hours, $minutes) = explode(':', $time);
    $startMinutes = $hours * 60 + $minutes;
    //Переводим конца сеанса в минуты
    $endMinates = $startMinutes + $filmDuration;

    $range = [$startMinutes, $endMinates]; // Диапазон добавляемого сеанса
    return $range;
  }

  //Метод получения сеансов по id зала (на сегодня)
  public function getSeansesByHallId($idHall)
  {
    //Получаем сегодняшнюю дату
    $today = today();
    //Получаем все сеансы для указанного зала
    $seanses = Session::
      where('hall_id', $idHall)
      ->whereDate('session_date', $today)
      ->get();

    //Добавляем в каждый сеанс название фильма
    foreach ($seanses as $el) {
      // $el->film->name;  здесь используем связь моделей фильм и сеанс, и получаем название фильма Крутаю фишка!!! мне нравится
      $el->nameFilm = $el->film->name;
    }

    //Добавляем в каждый сеанс продолжительность фильма
    foreach ($seanses as $el) {
      $el->durationFilm = $el->film->duration;
    }

    return response()->json($seanses);

  }

  //Метод удаления всех сеансов по указанному времени в указанном зале
  public function deleteSession(Request $request)
  {
    // dd($request->input());
    $idHall = $request->input('hallSeansDelete');
    $time = $request->input('timeSeansDelete');
    $seanses = Session::
      where('hall_id', $idHall)
      ->where('start_time', $time)
      ->delete();

    return redirect()->back()->with('success', 'Сеанс успешно удален');
  }
  //->daysInMonth(); количесвто лней в месяце
  //->format('d-m-Y'); // Выведет дату в формате dd-mm-yyyy
  //dd($startDate->addDays(30)->toDateString());
  // dd($daysInMonth);
  //  dd($startDate->addDays(30)->format('d-m-Y'));
  //dd($startDate->addDays(30)->format('Y-m-d'));

  //     array:4 [▼ // app\Http\Controllers\SessionController.php:13
//   "_token" => "BeTxSkab2LVfpRFUFvdkOQrfJn1tSH7dNAklj5N3"
//   "hall" => "19"
//   "film" => "2"
//   "start_time" => "12:36"
// ]
}
