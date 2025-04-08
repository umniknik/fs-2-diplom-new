//Берем поля ввода количества рядов и мест в рядах
const htmlInputRows = document.querySelector('input[name="rows"]');
const htmlInputSeats = document.querySelector('input[name="seats_per_row"]');
//Привязываем слущатель на изменение поля ввода размера зала, будет запускать ф-ия отрисовывания мест
htmlInputRows.addEventListener('input', displaySeats);
htmlInputSeats.addEventListener('input', displaySeats);

//Берем место на странице куда будем вставлять код отображения сидений
const seatsElements = document.querySelector('.conf-step__hall-wrapper');

//Отправляем запрос в базу данных чтобы получить места для первого зала и отобразить их на странице. Если мест нет, то оставим поле мест пустым 
checkSeatInHall(1);

//Ф-ия отрисовки поля мест по данным введенным вручную в поле "количество рядов" и "количество мест"
function displaySeats() {

    //Берем введенные в инпут значения количества рядов и мест в рядах
    const rowsFromInput = htmlInputRows.value;
    const seatsFromInput = htmlInputSeats.value;

    // //Берем место на странице куда будем вставлять код отображения сидений
    seatsElements.innerHTML = ''; //очищаем поле место на странице куда будем вставлять код отображения сидений

    let seatNumberInArray = 0;  // для перебора кресел в массиве создадим переменную

    //Массив всех мест, который будем заполнять, чтобы потом отправить на сервер
    const arraySeats = [];

    for (let i = 0; i < rowsFromInput; i++) {
        const htmlRows = document.createElement('div');
        htmlRows.classList.add('conf-step__row');
        for (let j = 0; j < seatsFromInput; j++) {
            const htmlSeat = document.createElement('div');
            htmlSeat.classList.add('conf-step__chair', 'conf-step__chair_standart');
            htmlSeat.setAttribute('data-seat-number', seatNumberInArray);  //добавляем атрибут data с id места в таблице мест, чтобы потом менять в тип и соответсвующего места, т.к. у нового места ещё может не быть id

            htmlSeat.addEventListener('click', changeTypeOfSeat);   //вешаем слушатель, при клике будет запускаться функция смены цвета (типа) места
            htmlRows.appendChild(htmlSeat);

            //Формируем массив мест для отправки в базу данных
            arraySeats.push({
                id: null,  //потому что не знаем какой id будет присвоен при создании записи в таблице базы данных
                row_number: i + 1,
                seats_number: j + 1,
                seatNumber: seatNumberInArray, // это поле для поиска в массиве json для изменения типа места перед отправкой на сервер
                type: 'regular',
                price: null
            })

            seatNumberInArray++;   //берем слудующее кресло из массива   

        }

        //Вставляем массив всех мест в скрытое поле input, чтобы потом отправить на сервер после кнопки submit
        fillInInput(arraySeats);

        seatsElements.appendChild(htmlRows);
    }
}

//Функция заполнения невилимого поля input массиво всех мест, чтобы потом отправить на сервер после кнопки submit
function fillInInput(arraySeats) {
    const inputArraySeats = document.getElementById('arraySeats');
    inputArraySeats.value = JSON.stringify(arraySeats);
}

//Ф-ия отрисовки поля мест по данным полученным из базы данных
function displaySeatsFromDatabase(seats) {
    const seatsElements = document.querySelector('.conf-step__hall-wrapper');
    seatsElements.innerHTML = '';

    // получаем последний элемент массива, т.к. в нем записаны максимальные значения рядов и мест в ряду в данном зале, 
    //чтобы использовать как ограничение в цикле
    const lastSeats = seats[seats.length - 1];
    const rows_count = lastSeats.row_number; // рядов в зале
    const seats_per_row = lastSeats.seats_number;  // мест в ряду

    //втсавляем полученные значения в поля input "Рядов, шт Мест, шт"
    htmlInputRows.value = rows_count;
    htmlInputSeats.value = seats_per_row;

    const htmlRows = document.createElement('div');
    htmlRows.classList.add('conf-step__row');

    let seatNumberInArray = 0;  // для перебора кресел в массиве создадим переменную

    //Массив всех мест, который будем заполнять, чтобы потом отправить на сервер
    const arraySeats = [];

    for (let i = 0; i < rows_count; i++) {
        const htmlRows = document.createElement('div');
        htmlRows.classList.add('conf-step__row');
        for (let j = 0; j < seats_per_row; j++) {
            const htmlSeat = document.createElement('div');

            let type;
            switch (seats[seatNumberInArray]['type']) {
                case 'regular':
                    type = 'conf-step__chair_standart';
                    break;
                case 'vip':
                    type = 'conf-step__chair_vip';
                    break;
                case 'blocked':
                    type = 'conf-step__chair_disabled';
                    break;
            }

            htmlSeat.classList.add('conf-step__chair', type);
            htmlSeat.setAttribute('data-seat-id', seats[seatNumberInArray]['id']);  //добавляем атрибут data с id места в таблице мест
            htmlSeat.setAttribute('data-seat-number', seatNumberInArray);  //добавляем атрибут data с id места в таблице мест, чтобы потом менять в тип и соответсвующего места, т.к. у нового места ещё может не быть id

            htmlSeat.addEventListener('click', changeTypeOfSeat);   //вешаем слушатель, при клике будет запускаться функция смены цвета (типа) места
            htmlRows.appendChild(htmlSeat);            

            //Формируем массив мест для отправки в базу данных
            arraySeats.push({
                id: seats[seatNumberInArray]['id'],  //берем id из полученного массив с сервера
                row_number: i + 1,
                seats_number: j + 1,
                seatNumber: seatNumberInArray,
                type: seats[seatNumberInArray]['type'],
                price: null
            })

            seatNumberInArray++;   //берем слудующее кресло из массива            
        }
        //Вставляем массив всех мест в скрытое поле input, чтобы потом отправить на сервер после кнопки submit
        fillInInput(arraySeats);

        seatsElements.appendChild(htmlRows);
    }
};

//функция изменения типа места в зале после клика по месту
function changeTypeOfSeat(event) {
    //Полкчаем номер кликнутой ячейки
    const number = event.target.dataset['seatNumber'];

    const htmlSeats = event.target;
    // console.log(event.target);
    if (htmlSeats.classList.contains('conf-step__chair_standart')) {
        htmlSeats.classList.replace('conf-step__chair_standart', 'conf-step__chair_vip');
        //Меняем в переменной массива всех мест тип места. Переменная хранится в скрытом поле input
        document.getElementById('arraySeats').value = document.getElementById('arraySeats').value.replace(`:${number},"type":"regular"`, `:${number},"type":"vip"`);
    } else if (htmlSeats.classList.contains('conf-step__chair_vip')) {
        htmlSeats.classList.replace('conf-step__chair_vip', 'conf-step__chair_disabled');
        //Меняем в переменной массива всех мест тип места. Переменная хранится в скрытом поле input
        document.getElementById('arraySeats').value = document.getElementById('arraySeats').value.replace(`:${number},"type":"vip"`, `:${number},"type":"blocked"`);
    } else {
        htmlSeats.classList.replace('conf-step__chair_disabled', 'conf-step__chair_standart');
        document.getElementById('arraySeats').value = document.getElementById('arraySeats').value.replace(`:${number},"type":"blocked"`, `:${number},"type":"regular"`);
    }
}

// функция получения списка всех мест выбранного зала из баззы данных 
async function getSeatsByHallId(idHall) {
    try {
        const response = await fetch(`/api/halls/${idHall}/seats`);
        const data = await response.json();
        return data; // Возвращаем данные как результат промиса
    } catch (error) {
        console.error('Ошибка:', error);
        throw error; // Прекращаем выполнение, если возникла ошибка
    }
}

//Вешаем слушатели на кнопки выбора залов
const buttonsHall = Array.from(document.getElementsByClassName('conf-step__radio'));
buttonsHall.forEach(element => {
    element.addEventListener('click', (event) => {
        const idHall = event.target.value;
        checkSeatInHall(idHall);
    });
});


//Отправляем запрос в базу данных чтобы получить места для первого зала и отобразить их на странице. Если мест нет, то оставим поле мест пустым 
async function checkSeatInHall(idHall) {
    try {
        //С помощью функции getSeatsByHallId получаем места из первого зала
        const allSeatsFromDatabase = await getSeatsByHallId(idHall);

        //Проверяем есть ли места в зале, если есть то отрисовываем их
        if (allSeatsFromDatabase.length != 0) {
          //  console.log(allSeatsFromDatabase);
            //есть в зале есть места то заполняем поля инпут и отрисовываем их, если нет то
            displaySeatsFromDatabase(allSeatsFromDatabase);
        } else {
            seatsElements.innerHTML = ''; //очищаем поле место на странице куда будем вставлять код отображения сидений
        }
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};