@include('layouts/header')

  <main>
    <section class="ticket">

      <header class="tichet__check">
        <h2 class="ticket__check-title">Электронный билет</h2>
      </header>

      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span
            class="ticket__details ticket__title">{{ $ticketInfo['filmName'] }}</span></p>
        <p class="ticket__info">Места: <span
            class="ticket__details ticket__chairs">{{ preg_replace('/,/', ', ', $ticketInfo['orderSeats'])  }}</span>
        </p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $ticketInfo['idHall'] }}</span>
        </p>
        <p class="ticket__info">Начало сеанса: <span
            class="ticket__details ticket__start">{{ $ticketInfo['timeSeans']}}</span></p>

        <div class="ticket__info-wrapper">

          <img class="ticket__info-qr" src=""> 	

        </div>

        <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>
  </main>

</body>

</html>