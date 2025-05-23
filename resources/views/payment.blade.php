@include('layouts/header')
  
  <main>
    <section class="ticket">
      
      <header class="tichet__check">
        <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
      </header>
      
      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $paymentInfo['filmName'] }}</span></p>
        <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">{{ preg_replace('/,/', ', ', $paymentInfo['orderSeats'])  }}</span></p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $paymentInfo['idHall']}}</span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $paymentInfo['timeSeans']}}</span></p>
        <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ $paymentInfo['ticketCost'] }}</span> рублей</p>

        <form action="/ticket">
            @csrf
            <input type="hidden" name="idHall" value="{{ $paymentInfo['idHall'] }}">
            <input type="hidden" name="filmName" value="{{ $paymentInfo['filmName'] }}">
            <input type="hidden" name="idSession" value="{{ $paymentInfo['idSession'] }}">
            <input type="hidden" name="orderSeats" value="{{ $paymentInfo['orderSeats'] }}">
            <input type="hidden" name="timeSeans" value="{{ $paymentInfo['timeSeans']}}">
            <input type="hidden" name="ticketCost" value="{{ $paymentInfo['ticketCost']}}">
          <button class="acceptin-button">Получить код бронирования</button>
        </form>

        <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>     
  </main>
  
</body>
</html>