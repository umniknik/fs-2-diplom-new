@include('layouts/header')
  
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
              case 'buying':
                return 'buying-scheme__chair_taken';
              default:
                return 'buying-scheme__chair_standart';
            }
          }
      @endphp

      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">
        
        @if( $filmInfo['hallIsActive'] )
          <!-- Если в БД в таблице settings не стоит false то отображаем места в зале, если нет то надпись "закрыто" -->
          @foreach ( $filmInfo['seatsNew'] as $row)
            <div class="buying-scheme__row">
              @foreach ($row as $seat )
                
                <span class="buying-scheme__chair {{$classChair($seat['type'])}}" data-seat-id='{{ $seat['id'] }}'></span>
              @endforeach
            </div>
          @endforeach

        @else
        <div class="buying-scheme__row"><p style="font-size: 20px; color: white; border: 4px dotted #730d0d;">Продажа билетов закрыта</p></div>
        @endif 


        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{ $filmInfo['priceRegular'] }}</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{ $filmInfo['priceVip'] }}</span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      <form action="/payment">
              @csrf
              <input type="hidden" name="idHall" value="{{ $filmInfo['idHall'] }}">
              <input type="hidden" name="idSession" value="{{ $filmInfo['idSession'] }}">
              <input type="hidden" name="orderSeats" value="">
              <button class="acceptin-button">Забронировать</button>
      </form>
    </section>     
  </main>

<script src="{{ asset('js/order_hall.js') }}"></script>

</body>
</html>




