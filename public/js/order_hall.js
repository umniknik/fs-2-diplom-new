/**
 * Файл отвечает за добавление функций выбора и заказа  мест на старницу hall
 */
const seats = document.querySelectorAll('.buying-scheme__chair');

//Запускаем функцию, которая делает кнопку забронировать неактивной, если не выбраны места
chechForButton();

//На кажде сиденье вешаем слушатель для изменения цвета выбранного места
seats.forEach(seat => {
    seat.addEventListener('click', orderSeat);
});

//Функция изменения цвета выбранного места
function orderSeat(event) {
    // console.log(event.target);
    //Проверяем на куплено ли место
    if (!event.target.classList.contains('buying-scheme__chair_taken')) {
        //Изменяем цвет у выбранног места
        event.target.classList.toggle('buying-scheme__chair_selected');

        //Сохраняем в массив номера всех выбранных мест с помощью ф-ии chekAllSeatsByOrder
        const arrOrderSeats = chekAllSeatsByOrder();

        //Вписываем выбарные места в скрытое поле формы
        document.querySelector('input[name="orderSeats"]').value = arrOrderSeats;
    }

    //Запускаем функцию, которая делает кнопку забронировать неактивной/активной, если (не) выбраны места
    chechForButton();
}

//Проверяем все места на то выбарны они или нет
function chekAllSeatsByOrder() {
    //Выбираем все места, которые выбраны
    const allSeatsOrder = document.querySelectorAll('.buying-scheme__chair_selected');

    const orderSeats = [];

    //Берем у каждого выбранного места номер места хранящегося в атрибуте data-seat-id и добавляе в конец массива
    allSeatsOrder.forEach(seat => {
        if (seat.getAttribute('data-seat-id')) {
            orderSeats.push(seat.getAttribute('data-seat-id'));
        }
    });

    return orderSeats;
}

//Проверка выбраны ли места что сделать кнопку "ЗАБРОНИРОВАТь" активной/неактивной
function chechForButton() {
    //Берем кнопку "ЗАБРОНИРОВАТь"
    const button = document.querySelector('.acceptin-button');

    //Берем выбарные места из скрытого поле формы
    const arrOrderSeats = document.querySelector('input[name="orderSeats"]').value;

    //Если в скрытом поле были места до удаляем класс невидимости, иначе наоборот
    if (arrOrderSeats) {
        button.classList.remove('button_disabled');
        button.disabled = false; // активируем кнопку
    } else {
        button.classList.add('button_disabled');
        button.disabled = true; // деактивируем кнопку
    }
}