//Вешаем слушатель открытия попапа на кнопку "Добавить фильм" 
const buttonAddFilmUpPopup = document.getElementById('add-film-button');
buttonAddFilmUpPopup.addEventListener('click', popupFilmActive);
//Вешаем слушатель открытия попапа на кнопку "Закрыть попап" 
//const buttonDismissFilmUpPopup = document.getElementById('dismiss-film-button');
//buttonDismissFilmUpPopup.addEventListener('click', popupFilmActive);

//Функция добавляения/удаления класса active попапу добавить фильм
function popupFilmActive() {
    const popupAddFilm = document.getElementById('popup-add-film');
    popupAddFilm.classList.toggle('active');
}

//Проверяем есть ли фильмы в базе данных и отрисовываем их 
chechFilms();

//ф-ия проверки наличия фильмов и отрисовки их на страницу
async function chechFilms() {
    try {
        //Получаем все фильмы из базы данных с помощью функции getFetchAllfilms
        const allFilmFromDataBase = await getFetchAllfilms();

        //Если фильмы есть, то отрисовываем их
        if (allFilmFromDataBase.length != 0) {
            displayFilms(allFilmFromDataBase);

            //Сразу заполняем поле фильмы в попапе "Добавить сеанс"
            fillFieldFilmsInSessionsPopup(allFilmFromDataBase);
        }
    } catch (error) {
        console.error('Ошибка при получении данных фильмов', error);
    }
}

//Функция получения всех фильмов из базы данных
async function getFetchAllfilms() {
    try {
        const responce = await fetch('/api/get-all-films');
        const data = await responce.json();
        return data;  // Возвращаем данные как результат промиса
    } catch (error) {
        console.error('Ошибка', error);
        throw error; // Прекращаем выполнение, если возникла ошибка
    }
}

//Проверяем есть ли залы в базе данных и отрисовываем их
chechHalls();

async function chechHalls() {
    try {
        //Получаем все фильмы из балы данных с помощью функции getFetchAllfilms
        const allHallFromDataBase = await getFetchAllHalls();

        //Если залы есть, то отрисовываем их
        if (allHallFromDataBase.length != 0) {

            //Заполняем поле залы в попапе "Добавить сеанс"
            fillFieldHallsInSessionsPopup(allHallFromDataBase);

            //Отрисовываем сеансы в залах на временных шкалах
            displaySeancesTimeline(allHallFromDataBase);
        }
    } catch (error) {
        console.error('Ошибка при получении данных залов', error);
    }
}

//Функция получения всех залов из базы данных
async function getFetchAllHalls() {
    try {
        const responce = await fetch('/api/get-all-halls');
        const data = await responce.json();
        return data;  // Возвращаем данные как результат промиса
    } catch (error) {
        console.error('Ошибка', error);
        throw error; // Прекращаем выполнение, если возникла ошибка
    }
}

// Ф-ия отрисовки блоков фильмы ПОД кнопкой "добавить фильм"
function displayFilms(arrayfilms) {
    const filmsWrapper = document.querySelector('.conf-step__movies');

    arrayfilms.forEach(el => {
        const htmlFilm = document.createElement('div');
        htmlFilm.setAttribute('data-film-id', el.id);
        htmlFilm.classList.add('conf-step__movie');

        const img = document.createElement('img');
        img.classList.add('conf-step__movie-poster');
        img.alt = "poster";
        img.src = el.img_url;
        htmlFilm.appendChild(img);

        const h3 = document.createElement('h3');
        h3.classList.add('conf-step__movie-title');
        h3.textContent = el.name;
        htmlFilm.appendChild(h3);

        const p = document.createElement('p');
        p.classList.add('conf-step__movie-duration');
        p.textContent = el.duration;
        htmlFilm.appendChild(p);

        filmsWrapper.appendChild(htmlFilm);

        //На каждую иконку фильма вешаем слушатель запуска функции openEditSessions открывания своего поля редактирования сеансов
        htmlFilm.addEventListener('click', openEditSessions);
    });
}

////////////////////////////  Блок кода попап окна "Добавить сеанс" //////////////////////

//Функция открытия поля редактирования сеансов для кликнутого фильма
function openEditSessions(event) {
    //Запускаем Функцию добавляения/удаления класса active попапу добавить сеанс
    popupSessionActive();

    //Вешаем слушатель на крестик закрытие попап окна "Добавление сеанса"
   // const buttonDismissSessionUpPopup = document.getElementById('dismiss-session-button');
    //buttonDismissSessionUpPopup.addEventListener('click', popupSessionActive);
}

//Функция добавляения/удаления класса active попапу добавить сеанс
function popupSessionActive() {
    const popupAddFilm = document.getElementById('popup-add-session');
    popupAddFilm.classList.toggle('active');
}

//Функция заполнения выпадающего поля фильмы в попапе "Добавление сеанса"
function fillFieldFilmsInSessionsPopup(films) {
    const htmlSelectFilm = document.getElementById('select-film');

    films.forEach(el => {
        const htmlOption = document.createElement('option');
        htmlOption.setAttribute('value', el.id);
        htmlOption.textContent = el.name;

        htmlSelectFilm.appendChild(htmlOption);
    });
}

//Функция заполнения выпадающего поля залы в попапе "Добавление сеанса"
function fillFieldHallsInSessionsPopup(halls) {
    const htmlSelectFilm = document.getElementById('select-hall');

    halls.forEach(el => {
        const htmlOption = document.createElement('option');
        htmlOption.setAttribute('value', el.id);
        htmlOption.textContent = el.name;

        htmlSelectFilm.appendChild(htmlOption);
    });
}

///////////////////////// Блок добавления временных шкал сеансов ///////////////////

//Добавление на временнуж шкалу сеансов
const htmlWrpSeancesTimeline = document.getElementById('wrp-seances-timeline');
// htmlWrpSeancesTimeline.innerHtml = '';

//Функция отрисовки временных шкал залов и с кирпичиками сеансов на них
async function displaySeancesTimeline(allHallFromDataBase) {

    //Проходимся по каждому залу и отрисовываем его как временную шкалу
    for (const el of allHallFromDataBase) {

        //Отрисовываем поля залов
        const wrphallSeancesTimeline = document.createElement('div');
        wrphallSeancesTimeline.classList.add('conf-step__seances-hall');
        wrphallSeancesTimeline.setAttribute('id', el.id); //добавляем id зала чтобы потом по нему удалять сеансы

        const h3 = document.createElement('h3');
        h3.classList.add('conf-step__seances-title');
        h3.textContent = el.name;
        wrphallSeancesTimeline.appendChild(h3);

        const hallSeancesTimeline = document.createElement('div');
        hallSeancesTimeline.classList.add('conf-step__seances-timeline');
        wrphallSeancesTimeline.appendChild(hallSeancesTimeline);

        ///////Отрисовываем в каждом поле зала =КИРПИЧИКИ= сеансов //////
        try {
            //Получаем массив seanses в котором находятся все сеансы на сегодняшний день в данном зале по id зала
            const seanses = await getFetchAllSeanses(el.id);

            //Проходимся по каждому сеансу из массива seanses и отрисовываем его 
            for (const seansFilm of seanses) {
                console.log(seansFilm.id);
                const htmlSeancesMovie = document.createElement('div');
                htmlSeancesMovie.classList.add('conf-step__seances-movie');
                htmlSeancesMovie.setAttribute('id', seansFilm.id); //добавляем id сеанса чтобы потом по нему удалять

                const title = document.createElement('p');
                title.classList.add('conf-step__seances-movie-title');
                title.textContent = seansFilm.nameFilm;
                console.log(title.textContent);
                htmlSeancesMovie.appendChild(title);

                const time = document.createElement('p');
                time.classList.add('conf-step__seances-movie-start');
                time.textContent = seansFilm.start_time;
                htmlSeancesMovie.appendChild(time);

                //// Добавляем каждому кирпичику стиль, который опередлит его цвет и место на шкале времени
                //С помощью функции timeToProcent получаем количетсво пикселей, на которое надо сдвинуть кирпичик сеанса вправо
                const left = timeToProcent(seansFilm.start_time);
                //Высчитываем ширину кирпичика сеанса
                const width = howWidthIs(seansFilm.durationFilm);
                //Получаем цвет кирпичика сеанса
                const backgroundColor = howColorIs(seansFilm.film_id);
                //Заполняем полученными значениями инлайн стиль кирпичика
                htmlSeancesMovie.style.cssText = `width: ${width}px; background-color: ${backgroundColor}; left: ${left}px;`;
                //Вешаем удаление сеанса
                htmlSeancesMovie.addEventListener('click', deleteSeans);


                hallSeancesTimeline.appendChild(htmlSeancesMovie);
            }

        } catch (error) {
            console.error(`Ошибка при получении сеансов для зала ${el.name}:`, error);
        }

        //Делаем проверку совместимости сеансов

        htmlWrpSeancesTimeline.appendChild(wrphallSeancesTimeline);
    };
}

//Функция получения всех фильмов из базы данных по id зала
async function getFetchAllSeanses(idHall) {
    try {
        const responce = await fetch(`/api/halls/${idHall}/seanses`);
        const data = await responce.json();
        return data;  // Возвращаем данные как результат промиса
    } catch (error) {
        console.error('Ошибка', error);
        throw error; // Прекращаем выполнение, если возникла ошибка
    }
}

//Функция перевода часов в минуты и в процентное соотношение к дню и итоговое значение в пикселях 
//(для расположения на временной шкале)
function timeToProcent(time) {
    const [hours, minutes] = time.split(':');
    //Переводим время в минуты
    const allMinutes = (hours * 60) + +(minutes);
    //Высчитываем процентное соотношение времени старта фильма по отношению к целому дню (24*60=1440)
    const procent = allMinutes / 1440 * 100;
    // Поскольку величина временного поля зара 720 px = 100%, то получаем количество пикселей, на которое надо сдвинуть кирпичик сеанса вправо
    const result = Math.ceil(720 * procent * 0.01);
    return result;
}

//функция определения цвета фильма для кирпичика сеанса
function howColorIs(id) {
    //Находим блок с фильмов по id, чтобы зате музнать его цвет
    const film = document.querySelector(`[data-film-id="${id}"]`)
    //Берем стили у блока фильма
    const computedStyle = window.getComputedStyle(film);
    //Берем из стилей цвет фона, чтобы передать в какой окрасить кирпичик сеанса
    const backgroundColor = computedStyle.getPropertyValue('background-color');
    return backgroundColor;
}

//Функция определения ширины кирпичика сеанса
function howWidthIs(duration) {
    //Делим длину фильма на длину суток в минутах(1440 минут в сутках) и получаем соотношение. 
    //Затем умножаем это соотнощение на длину поля в пикселях (720) и получаем длину кирпичика сеанса
    const width = duration / 1440 * 720;
    return width;
};

//Функция открытия попапа "Удаление сеанса"
function deleteSeans(event) {
    //Открываем попап
    popupDeleteSessionActive();

    //Берём id кликнутого сеанса
    const seans = event.target.closest('.conf-step__seances-movie');
    // const idSeans = seans.id;  
    //Берем имя фильмы
    const nameSeans = seans.querySelector('.conf-step__seances-movie-title').textContent;
    //Берем время фильма
    const timeSeans = seans.querySelector('.conf-step__seances-movie-start').textContent;
    //Берем id зала
    const idHall = event.target.closest('.conf-step__seances-hall').id;
    console.log(timeSeans, nameSeans, idHall);

    //Вписываем название фильма в попап удаления сеанса "Вы действительно хотите снять с сеанса фильм "название фильма"?"
    document.getElementById('nameFilmDeleteSeans').textContent = `"${nameSeans}"`;

    //Заполняем время сеанса в скрытом поле формы в папопе "Удалоить сеанс"
    document.querySelector('input[name="timeSeansDelete"]').value = timeSeans;

    //Заполняем id зала в скрытом поле формы в папопе "Удалоить сеанс"
    document.querySelector('input[name="hallSeansDelete"]').value = idHall;
    // console.log(document.querySelector('input[name="timeSeansDelete"]'));

    //Вешаем слушатель на крестик закрытие попап окна "Удаление сеанса"
   // const buttonDismissSessionUpPopup = document.getElementById('dismiss-delete-session-button');
    //buttonDismissSessionUpPopup.addEventListener('click', popupDeleteSessionActive);
}

//Функция добавляения/удаления класса active попапу удалить сеанс
function popupDeleteSessionActive() {
    const popupDeleteFilm = document.getElementById('delete-add-session');
    popupDeleteFilm.classList.toggle('active');
}

const btnClosePopup = document.querySelectorAll('.popup__dismiss');
btnClosePopup.forEach(el => {
    el.addEventListener('click',(event)=>{
        // console.log(event.target.closest('.popup'));
        event.target.closest('.popup').classList.remove('active');
    })
});

