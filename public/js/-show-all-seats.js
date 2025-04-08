function displaySeats(seats) {
    const seatsElements = document.querySelector('.conf-step__hall-wrapper');
    seatsElements.innerHTML = '';

    const lastSeats = seats[seats.length - 1]; // получаем последний элемент массива, т.к. в нем записаны максимальные значения рядов и мест в ряду в данном зале
    const rows_count = lastSeats.row_number; // рядов в зале
    const seats_per_row = lastSeats.seats_number;  // мест в ряду

    const htmlRows = document.createElement('div');
    htmlRows.classList.add('conf-step__row');

    let seatNumberInArray = 0;  // для перебора кресел в массиве создадим переменную

    for (let i = 0; i < rows_count; i++) {
        const htmlRows = document.createElement('div');
        htmlRows.classList.add('conf-step__row');
        for (let j = 0; j < seats_per_row; j++) {
            console.log('ряд', i, 'место', j, 'номер', seatNumberInArray);
            const htmlSeat = document.createElement('div');
            htmlSeat.classList.add('conf-step__chair', 'conf-step__chair_standart');
            htmlSeat.setAttribute('data-seat-id', seats[seatNumberInArray]['id']);  //добавляем атрибут data с id места в таблице мест

            htmlSeat.addEventListener('click', changeTypeOfSeat);   //вешаем слушатель, при клике будет запускаться функция смены цвета (типа) места
            htmlRows.appendChild(htmlSeat);
            // console.log(seats[i][j]);
            seatNumberInArray++;   //берем слудующее кресло из массива
        }
        seatsElements.appendChild(htmlRows);
    }

    console.log(rows_count, seats_per_row);
}

//функция изменения типа места в зале после клика по нему
function changeTypeOfSeat(event) {
    const htmlSeats = event.target;
    // console.log(event.target);
    if (htmlSeats.classList.contains('conf-step__chair_standart')) {
        htmlSeats.classList.replace('conf-step__chair_standart', 'conf-step__chair_vip');
    } else if (htmlSeats.classList.contains('conf-step__chair_vip')) {
        htmlSeats.classList.replace('conf-step__chair_vip', 'conf-step__chair_disabled');
    } else {
        htmlSeats.classList.replace('conf-step__chair_disabled', 'conf-step__chair_standart');
    }
}

$hallId = '1';

fetch(`/api/halls/1/seats`)
    .then(response => response.json())
    .then(data => {
        // Обработка полученных данных о местах
        console.log(data);
        displaySeats(data);
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });