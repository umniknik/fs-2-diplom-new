<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <!-- <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/styles.css"> -->
  <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  
  <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">
          <h2 class="buying__info-title">{{ $filmInfo['filmName'] }}</h2>
          <p class="buying__info-start">Начало сеанса: {{ $filmInfo['timeSeans'] }}</p> 
          
          <p class="buying__info-hall">Зал {{ $filmInfo['idHall'] }}</p>          
        </div>
        <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div>
      </div>

      <!-- Объявим функцию, которая в зависимости от типа кресла, будет выдавать соответ-й класс -->
      @php
          $classChair = function($type) {
            switch ($type) {
              case 'blocked':
                return 'buying-scheme__chair_disabled';
              case 'vip':
                return 'buying-scheme__chair_vip';
              default:
                return 'buying-scheme__chair_standart';
            }
          }
      @endphp

      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">

          @foreach ( $filmInfo['seatsNew'] as $row)
            <div class="buying-scheme__row">
              @foreach ($row as $seat )
                {{ $seat['id'] }}
                <span class="buying-scheme__chair {{$classChair($seat['type'])}}"></span>
              @endforeach
            </div>
          @endforeach

        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">250</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">350</span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      <button class="acceptin-button" onclick="location.href='payment.html'" >Забронировать</button>
    </section>     
  </main>
  
</body>
</html>




