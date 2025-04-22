/**
 * Написал код с двумя меню. Первое меню без кнопки "назад", а второе уже с кнопкой "назад"
 * Когда мы первый раз открываем страницу, то создается первое меню (без "назад") по умолчания createMenuDefault(), 
 * а когда мы нажимаем кнопку дальше или переходим по ссылке с датой то отрисовывается меню (с "назад") createMenu(date)
 * когда мы нажимая кнопку "назад" и увидим кнопку с сегодняшней датой, то отрисуется снова меню по умолчанию (без назад) createMenuDefault()
 * Решил сделать так, потому что в первой версии кода -top_date_menu.js сильно запутался в коде, прибавить кнопку назад, удалить последнюю и снова
 * что ришил все упростить таким образом.
 */

let menuWrp = document.querySelector('.page-nav');

createMenuDefault();
//Ф-ия создания меню по умолчанию, т.е. начинающееся с сегодняшней даты
//Меню, которое получается при первой загрузке страницы
function createMenuDefault() {
    //Очищаем предыдущее меню
    document.querySelector('.page-nav').innerHTML = '';

    //Получаем сегодняшнюю дату
    let date = new Date();

    //Отрисовываем семи кнопок с датами
    for (let i = 0; i < 7; i++) {
        const buttonDate = createButtonDate(date);
        menuWrp.appendChild(buttonDate);

        //Устанвливаем в дату следующий день
        date.setDate(date.getDate() + 1);
    }

    //Отрисовываем кнопку "дальше"
    const buttonNext = document.createElement('a');
    buttonNext.classList.add('page-nav__day', 'page-nav__day_next');
    buttonNext.setAttribute('href', '/#')
    menuWrp.appendChild(buttonNext);

    //Вешаем слушатель на кнопку следующий день и запускаем функцию сдвига дней в меню
    document.querySelector('.page-nav__day_next').addEventListener('click', nextDays);

    //Ф-ия отображения слова "Сегодня" на кнопке с тукущей датой
    addCaptionToday();

    //Ф-ия выделения кнопки в меню, которая соответсвует просматриваемой странице
    buttonChosen()

    //Ф-ия выделения СБ и ВС красным в кнопках
    colorWeekend();
}

//Берем текущуюю дату
let dateCurrent = new Date();

//Ф-ия запуска отрисовки меню для следующего дня при клике по кнопке "Вперед"
function nextDays(event) {
    event.preventDefault();

    //Получаем дату из первой кнопки меню в виде строки "2025-04-19"
    let lastdate = datefromFirstButton();

    //Преобразовываем строку типа "2025-04-19" в объект Date
    lastdate = new Date(lastdate);

    //Увеличиваем дату на один день, что потом запустить меню по этой дате
    lastdate.setDate(lastdate.getDate() + 1);
    createMenu(lastdate);
}

//Ф-ия запуска отрисовки меню для предыдущего дня при клике по кнопке "Назад"
function previousDays(event) {
    event.preventDefault();
    //Получаем дату из первой кнопки меню в виде строки "2025-04-19"
    let lastdate = datefromFirstButton();

    //Преобразовываем строку типа "2025-04-19" в объект Date
    lastdate = new Date(lastdate);

    lastdate.setDate(lastdate.getDate() - 1);

    // Метод toDateString() преобуразует объект Date в строку даты без времени пример "Mon Apr 21 2025"
    //Если дата в первой кнопке НН равна сегодняшней дате, то отображаем меню с кнопкой назад, если равна то меню без кнопки назад
    if (lastdate.toDateString() !== dateCurrent.toDateString()) {
        createMenu(lastdate);
    } else {
        createMenuDefault();
    }
}


//Функция создания меню с кнопкой назад
function createMenu(date) {
    //Очищаем предыдущее меню
    document.querySelector('.page-nav').innerHTML = '';

    //Создаем кнопку "назад"
    const buttonPrevious = document.createElement('a');
    buttonPrevious.href = '/#';
    buttonPrevious.classList.add('page-nav__day', 'page-nav__day_previous');
    menuWrp.appendChild(buttonPrevious);
    //Вешаем слушатель на кнопку предыдущий день и запускаем функцию сдвига дней в меню
    document.querySelector('.page-nav__day_previous').addEventListener('click', previousDays);

    //Отрисовываем шесть кнопок с датами
    for (let i = 0; i < 6; i++) {
        const buttonDate = createButtonDate(date);
        menuWrp.appendChild(buttonDate);

        //Устанвливаем в дату следующий день, для следующей кнопки
        date.setDate(date.getDate() + 1);
    }

    //Отрисовываем кнопку "дальше"
    const buttonNext = document.createElement('a');
    buttonNext.classList.add('page-nav__day', 'page-nav__day_next');
    buttonNext.setAttribute('href', '/#')
    menuWrp.appendChild(buttonNext);

    //Вешаем слушатель на кнопку следующий день и запускаем функцию сдвига дней в меню
    document.querySelector('.page-nav__day_next').addEventListener('click', nextDays);

    //Ф-ия отображения слова "Сегодня" на кнопке с тукущей датой
    addCaptionToday();

    //Ф-ия выделения кнопки в меню, которая соответсвует просматриваемой странице
    buttonChosen()

    //Ф-ия выделения СБ и ВС красным в кнопках
    colorWeekend();
}

//Ф-ия получения даты из первой кнопки меню
function datefromFirstButton() {
    const buttons = document.querySelectorAll('.page-nav__day');
    let button;
    //Если первая кнопка - это кнопка "Назад", то берем дату не из первой кнопки, а из второй
    if (!buttons[0].classList.contains('page-nav__day_previous')) {
        button = buttons[0];
        // console.log('Первая кнопка содержит дату');
        // console.log(button);
    } else {
        button = buttons[1];
        // console.log('Вторая кнопка содержит дату');
        // console.log(button);
    }

    const href = button.getAttribute('href');
    const dateStr = href.match(/\d{4}-\d{2}-\d{2}/)[0];
    // console.log(dateStr);

    return dateStr;
}


//Ф-ия создания кнопки с датой
function createButtonDate(date) {
    //== Получаем данные для вставки в кнопки ==
    //Получаем название дня нашей ф-ей
    const dayWeek = getWeekDay(date);
    //Получаем дату дня
    const dayNumber = date.getDate();
    // Запускуем ф-ию получаения даты в формате "2025-04-19"
    const fullDate = dateFormat(date);

    //== Отрисовываем кнопки ==
    const buttonDate = document.createElement('a');
    buttonDate.classList.add('page-nav__day');
    //Вписываем название дня в кнопку меню
    const spanDayWeek = document.createElement('span');
    spanDayWeek.classList.add('page-nav__day-week');
    spanDayWeek.textContent = dayWeek;
    //Вписываем номер дня в месяце в кнопку меню
    const spanDayNumber = document.createElement('span');
    spanDayNumber.classList.add('page-nav__day-number');
    spanDayNumber.textContent = dayNumber;
    //Вписываем ссылку с датой в значение атрибута
    buttonDate.setAttribute('href', `/movies/${fullDate}`);
    buttonDate.appendChild(spanDayWeek);
    buttonDate.appendChild(spanDayNumber);
    return buttonDate;
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


//Функция отображения слова "Сегодня" на кнопке с тукущей датой
function addCaptionToday() {
    const dateCurrentNew = new Date;
    // Запускуем ф-ию получаения даты в формате "2025-04-19"
    const fullDate = dateFormat(dateCurrentNew);
    const href = `/movies/${fullDate}`
    const button = document.querySelector(`[href*="${href}" ]`);
    if (button) {
        button.classList.add('page-nav__day_today');
    }
}


//Функция выделения кнопки в меню, которая соответсвует просматриваемой странице
function buttonChosen() {
    //Получаем ссылку из адресной строки, ту часть что после домена
    const hrefBrauzer = window.location.pathname;
    //Берем все кнопки из меню
    const allButtons = document.querySelectorAll('.page-nav__day');

    //Это условие для посвечивания первой кнопки когда мы находимся на главной и если первая кнопка не кнопка "назад"
    if (hrefBrauzer === '/' && !allButtons[0].classList.contains('page-nav__day_previous')) {
        allButtons[0].classList.add('page-nav__day_chosen')

        //Удаляем последнюю кнопку с датой, т.к. не влазит из-за того, что выбранная занимает две кнопки
        allButtons[allButtons.length - 2].remove();
        return;  
    };

    //Если мы не на главной(выяснили выше), то ищем кнопку у которой атрибут href равен ссылке из адресной строки браузера
    const button = document.querySelector(`[href*="${hrefBrauzer}" ]`);

    //Если такая ссылка существуйет и мы не на главной, то посвечиваем её 
    //(hrefBrauzer !== '/' добавил, т.к. все равно находит в документе где-то эту ссылку, (можно попроб сделать поиск в конрет элементе))
    if (button && hrefBrauzer !== '/') {
        button.classList.add('page-nav__day_chosen');

        //Удаляем последнюю кнопку с датой, т.к. не влазит из-за того, что выбранная занимает две кнопки
        allButtons[allButtons.length - 2].remove();
    }
}


//Ф-ия выделения СБ и ВС красным в кнопках
function colorWeekend() {
    const allButtons = document.querySelectorAll('.page-nav__day');

    allButtons.forEach(el => {
        const nameDay = el.getElementsByTagName('span');
  
        if (nameDay[0]) {
            if (nameDay[0].textContent === 'СБ' || nameDay[0].textContent === 'ВС') {
                el.classList.add('page-nav__day_weekend');
            }
        }

    })
}