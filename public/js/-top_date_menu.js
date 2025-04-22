//---Этот код вставлял даты и кнопку назад в существующий код html , но при нажатии вперед назад все время возникали какие-то ошибки
//---запутался в коде поэтому решил написать код заново и создать кнопки меню через js

//При открытии страницы запускаем функцию вписывания дат по сегодняшнему дню
//Получаем сегодняшнюю дату
let date = new Date();

//Если в локальном хранилище есть дата, сохраненна до перезагрузки старницы, то date присваиваем это сохраненное значение
const lastDateFirstButtonStr = localStorage.getItem('dateForFirstButton');
if (lastDateFirstButtonStr !== null) {
    let lastDateFirstButton = new Date(JSON.parse(lastDateFirstButtonStr)); // Преобразование строки обратно в объект Date
    //Сохраняем в нашу глабальную переменную полеченное значение даты
    date = lastDateFirstButton;
}

//Запускаем ф-ию вписывния дат в топ меню
addInButtonDates(date);

//Ф-ия вписывания дат в меню
function addInButtonDates(date) {
    //Счетчик количесва вписанных дней в кнопки
    let countDais = 0;

    //Записываем в состояние дату для первой кнопки, чтобы после перезагрузки страницы отобразить последнее состояниее меню дат
    localStorage.setItem('dateForFirstButton', JSON.stringify(date));

    //Берем все кнопки в меню с датами в массив
    let buttomMenu = document.querySelectorAll('.page-nav__day');

    //Проходимся по всем кнопкам с датами и вписываем день, дату и ссылку
    buttomMenu.forEach(el => {
        //Получаем название дня нашей ф-ей
        const dayWeek = getWeekDay(date);
        //Получаем дату дня
        const dayNumber = date.getDate();
        // Запускуем ф-ию получаения даты в формате "2025-04-19"
        const fullDate = dateFormat(date);

        //Если у кнопки есть поле куда вписываь дату, то...
        if (el.querySelector('.page-nav__day-number')) {
            //Вписываем название дня в кнопку меню
            el.querySelector('.page-nav__day-week').textContent = dayWeek;
            //Вписываем номер дня в месяце в кнопку меню
            el.querySelector('.page-nav__day-number').textContent = dayNumber;
            //Вписываем ссылку с датой в значение атрибута
            el.setAttribute('href', `/movies/${fullDate}`);

            //Устанвливаем в дату следующий день
            date.setDate(date.getDate() + 1);

            countDais++;
        }
    });

    //Поскольку внутри ф-ии объект date по ссылке изменяется в и глобавльной области видимости, то приводим его в первоначальный вид
    // вычитаем обратно прибавленные countDais(колич изменных дней) дней, чтобы работать дальше с этим объектом 
    date.setDate(date.getDate() - countDais);

    // //Запускаем функцию добавления кнопки "назад" в меню дат
    addButtonPrevious();
    deleteButtonPrevious();
}


//Функция показывающая день недели взято от сюда https://learn.javascript.ru/task/get-week-day
function getWeekDay(date) {
    let days = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];

    return days[date.getDay()];
}

//Функция получаения даты в формате "2025-04-19"
function dateFormat(date) {
    //получаем год
    const dateYear = date.getFullYear();
    //получаем месяц, поскольку отсчет месяцев начинается с 0 то +1, прибавляем ноль в начале, и если чисел больше двух то берем последние две с помощью slice
    const dateMonth = ("0" + (date.getMonth() + 1)).slice(-2);
    //Получаем дату дня
    const dayNumber = ("0" + (date.getDate())).slice(-2);

    const fullDate = `${dateYear}-${dateMonth}-${dayNumber}`

    return fullDate;
}

    //Вешаем слушатель на кнопку следующий день и запускаем функцию сдвига дней в меню
    document.querySelector('.page-nav__day_next').addEventListener('click', nextDays);

//Функция сдвига дат
function nextDays(event) {
    //Устанвливаем в дату следующий день
    date.setDate(date.getDate() + 1);
    //Запускаем функцию вписывания дат, и она впишет следующие дни
    addInButtonDates(date)
}

// // Запускаем функцию добавления кнопки "назад" в меню дат
// addButtonPrevious();

//Ф-ия вставки внопки "назад" в верхнее меню
// function addButtonPrevious() {
//     //Логикак вкратце: проверяем в первую кнопку вписана сегодняшняя дата или нет, если нет тот отображаем кнопку назад
//     //Берем все кнопки в меню с датами в массив
//     let buttomMenu = document.querySelectorAll('.page-nav__day');
//     //Получаем значение даты из ссылки в первой кнопке в меню
//     // let firstButtonUrl = buttomMenu[0].getAttribute('href');

//     // console.log(firstButtonUrl);
//     // const dateFirstButton = firstButtonUrl.match(/\d{4}-\d{2}-\d{2}/)[0];

//     // //Получаем сегодняюшнюю дату в нужном формате "2025-04-19"
//     // const dateNow = dateFormat(new Date());

//     // if (dateFirstButton === dateNow) {

//     const dateNow = dateFormat(new Date());
//     const dateLast = dateFormat(date);
//     console.log(dateNow);
//     console.log(dateLast);
//     if (dateLast === dateNow) {
//         console.log('ravny');
//     } else {
//         console.log('ne ravny');
//         //Создаем кнопку "назад" 
//         const buttonPrevious = document.querySelector('.page-nav__day_previous');
//         if (!buttonPrevious) {
//             //buttonPrevious.remove();
//             const buttonPrevious = document.createElement('a');
//             buttonPrevious.classList.add('page-nav__day', 'page-nav__day_previous');
//             buttonPrevious.addEventListener('click', () => {
//                 date.setDate(date.getDate() - 1);
//                 addInButtonDates(date)
//             });
            
//         }

//         // Преобразуем NodeList в обычный массив
//         let menuButtons = Array.from(buttomMenu);
//         //Добавляем кнопку в начале массива, т.е. в начао меню
//         menuButtons.unshift(buttonPrevious);
//         // удаляем предпоследний элемент, т.к. не влезет кнопка "вперед"
//         menuButtons.splice(-2, 1);

//         // Переприсваиваем обновлённому списку элементов обратно DOM-элементы
//         buttomMenu.forEach((el, index) => el.parentNode.replaceChild(menuButtons[index], el));
//         // console.log(menuButtons);
//     }

// }

function addButtonPrevious() {
    // Получаем список всех кнопок в меню
    let buttons = document.querySelectorAll('.page-nav__day');

    const dateNow = dateFormat(new Date());
    const dateLast = dateFormat(date);

    if (dateLast !== dateNow) {
        // Проверяем наличие кнопки "Назад"
        const existingButtonPrevious = document.querySelector('.page-nav__day_previous');
        
        if (!existingButtonPrevious) {
            // Создаем кнопку "Назад"
            const buttonPrevious = document.createElement('a');
            buttonPrevious.href = '#'; // Укажите нужный адрес или обработайте событие клика
            buttonPrevious.textContent = 'Назад';
            buttonPrevious.classList.add('page-nav__day', 'page-nav__day_previous');
            
            // Определяем родителя первой кнопки
            const parentContainer = buttons[0].parentNode;
            
            // Добавляем кнопку перед первой кнопкой
            parentContainer.insertBefore(buttonPrevious, buttons[0]);
        }

        // Если надо удалить какую-то кнопку (например, последнюю),
        // находим нужную кнопку и удаляем её напрямую
        const lastButtonToRemove = buttons[buttons.length - 2]; // Предположим, последняя кнопка должна исчезнуть
        lastButtonToRemove.parentNode.removeChild(lastButtonToRemove);
    }
}

//Функция удаления кнопки "назад" из меню дат
function deleteButtonPrevious() {

    //Логикак вкратце: проверяем в первую кнопку вписана сегодняшняя дата или нет, если нет тот отображаем кнопку назад
    //Берем все кнопки в меню с датами в массив
    let buttomMenu = document.querySelectorAll('.page-nav__day');
    //Получаем значение даты из ссылки в первой кнопке в меню
    // let firstButtonUrl = buttomMenu[0].getAttribute('href');
    // if (!firstButtonUrl) {
    //     firstButtonUrl = buttomMenu[1].getAttribute('href');
    // }
    // console.log(firstButtonUrl);

    // const dateFirstButton = firstButtonUrl.match(/\d{4}-\d{2}-\d{2}/)[0];

    // //Получаем сегодняюшнюю дату в нужном формате "2025-04-19"
    // const dateNow = dateFormat(new Date());

    // if (dateFirstButton === dateNow) {

    const dateNow = dateFormat(new Date());
    const dateLast = dateFormat(date);
    console.log(dateNow);
    console.log(dateLast);
    if (dateLast === dateNow) {

        const buttonPrevious = document.querySelector('.page-nav__day_previous');
        if (buttonPrevious) {
            buttonPrevious.remove();


            console.log('ravny запускаем удаление кнопки и добавление кнопки с датой');
            const buttonFirst = document.createElement('a');
            buttonFirst.classList.add('page-nav__day');
            const spanDayWeek = document.createElement('span');
            spanDayWeek.classList.add('page-nav__day-week');
            const spanDayNumber = document.createElement('span');
            spanDayNumber.classList.add('page-nav__day-number');
            buttonFirst.appendChild(spanDayWeek);
            buttonFirst.appendChild(spanDayNumber);

            // Преобразуем NodeList в обычный массив
            let menuButtons = Array.from(buttomMenu);
            menuButtons.shift();
            //Добавляем кнопку в начале массива, т.е. в начао меню
            menuButtons.unshift(buttonFirst);
            // Переприсваиваем обновлённому списку элементов обратно DOM-элементы
            buttomMenu.forEach((el, index) => el.parentNode.replaceChild(menuButtons[index], el));
            console.log('Переприсваиваем обновлённому списку элементов обратно DOM-элементы');
            // debugger;
            //Запускаем ф-ию вписывния дат в топ меню
            addInButtonDates(date);
            console.log(' Запускаем ф-ию вписывния дат в топ меню');
        }
    }



}