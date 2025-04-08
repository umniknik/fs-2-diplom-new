<section class="conf-step">
    <!-- // Отображение ошибки если произошло пересечении сеансов при добавлении нового сеанса -->
    <!-- @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}  приветттттт</li>
            @endforeach
        </ul>
    @endif -->

    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">

            <button class="conf-step__button conf-step__button-accent" id="add-film-button">Добавить фильм</button>

        </p>
        <div class="conf-step__movies">

            <!-- Форма открывающая при клике по фильму для добавления сеансов -->
            <!-- <form action="/create-session" method="POST" class="hide" style="width: 100%;" id="formaddsession"> -->
            <!-- @csrf -->
            <!-- <h3 id="nameFilm"></h3> -->

            <!-- <div class="conf-step__legend">
                <label class="conf-step__label">Добавьте время сенса
                    <input type="time" class="conf-step__input" name="addsession" placeholder="">
                </label>
            </div> -->

            <!-- Скрытое поле для передачи id фильма -->
            <!-- <input type="hidden" name="idFilm" id="idFilmAddSession"> -->

            <!-- <button class="conf-step__button conf-step__button-accent" id="add-session-button">Добавить сеанс</button> -->
            <!-- </form> -->

        </div>

        <div class="conf-step__seances" id="wrp-seances-timeline">
            <!-- <div class="conf-step__seances-hall">
                <h3 class="conf-step__seances-title">Зал 1</h3>
                <div class="conf-step__seances-timeline">
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">00:00</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">12:00</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                        <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                        <p class="conf-step__seances-movie-start">14:00</p>
                    </div>
                </div>
            </div>
            <div class="conf-step__seances-hall">
                <h3 class="conf-step__seances-title">Зал 2</h3>
                <div class="conf-step__seances-timeline">
                    <div class="conf-step__seances-movie"
                        style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                        <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                        <p class="conf-step__seances-movie-start">19:50</p>
                    </div>
                    <div class="conf-step__seances-movie"
                        style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                        <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                        <p class="conf-step__seances-movie-start">22:00</p>
                    </div>
                </div>
            </div> -->
        </div>

        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>
</section>

<!-- Если попали на странице с ошибкой, то отобразится Попап  "Ошибка Диапазоны сеансов пересекаются" -->
@if(request()->has('error'))    
    <div class="popup active">
        <div class="popup__container">
            <div class="popup__content">
                <div class="popup__header">
                    <h2 class="popup__title">
                        Ошибка
                        <a class="popup__dismiss" href="admin"><img src="i/admin/close.png" alt="Закрыть"></a>
                    </h2>
                </div>
                <div class="popup__wrapper">

                    <p class="conf-step__paragraph">Ошибка {{ request()->input('error') }}</p>
                    <div class="conf-step__buttons text-center">

                    </div>

                </div>
            </div>
        </div>
    </div>
@endif

<!-- Попап добавить фильм -->
<div class="popup" id="popup-add-film">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление фильма
                    <a class="popup__dismiss" href="#" id="dismiss-film-button"><img src="i/admin/close.png"
                            alt="Закрыть"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form action="create-film" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="popup__container">
                        <div class="popup__poster"></div>
                        <div class="popup__form">
                            <label class="conf-step__label conf-step__label-fullsize" for="nameFilm">
                                Название фильма
                                <input class="conf-step__input" type="text"
                                    placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="nameFilm" required>
                            </label>
                            <label class="conf-step__label conf-step__label-fullsize" for="name">
                                Продолжительность фильма (мин.)
                                <input class="conf-step__input" type="text" name="durationFilm" data-last-value=""
                                    required>
                            </label>
                            <label class="conf-step__label conf-step__label-fullsize" for="name">
                                Описание фильма
                                <textarea class="conf-step__input" type="text" name="descriptionFilm"
                                    required></textarea>
                            </label>
                            <label class="conf-step__label conf-step__label-fullsize" for="name">
                                Страна
                                <input class="conf-step__input" type="text" name="countryFilm" data-last-value=""
                                    required>
                            </label>
                        </div>
                    </div>
                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent"
                            data-event="film_add">
                        <input type="submit" value="Загрузить постер"
                            class="conf-step__button conf-step__button-accent">
                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Попап добавить сеанс  -->
<div class="popup" id="popup-add-session">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Добавление сеанса
                    <a class="popup__dismiss" href="#" id="dismiss-session-button"><img src="i/admin/close.png"
                            alt="Закрыть"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form action="/create-session" method="post" accept-charset="utf-8">
                    @csrf
                    <label class="conf-step__label conf-step__label-fullsize" for="hall">
                        Название зала
                        <select class="conf-step__input" name="hall" required id="select-hall">
                        </select>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="hall">
                        Название фильма
                        <select class="conf-step__input" name="film" required id="select-film">
                        </select>
                    </label>
                    <label class="conf-step__label conf-step__label-fullsize" for="name">
                        Время начала
                        <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
                    </label>

                    <div class="conf-step__buttons text-center">
                        <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent"
                            data-event="seance_add">
                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Попап удалить сеанс  -->
<div class="popup" id="delete-add-session">
    <div class="popup__container">
        <div class="popup__content">
            <div class="popup__header">
                <h2 class="popup__title">
                    Снятие с сеанса
                    <a class="popup__dismiss" href="#"><img src="i/admin/close.png" alt="Закрыть"
                            id="dismiss-delete-session-button"></a>
                </h2>
            </div>
            <div class="popup__wrapper">
                <form action="/delete-session" method="post" accept-charset="utf-8">
                    @csrf
                    <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм <span
                            id="nameFilmDeleteSeans">"Название фильма"</span>?</p>
                    <div class="conf-step__buttons text-center">
                        <input type="hidden" name="timeSeansDelete" value="">
                        <input type="hidden" name="hallSeansDelete" value="">
                        <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
                        <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/configuration_of_sessions.js') }}"></script>





<!-- <div class="conf-step__movie">
                <img class="conf-step__movie-poster" alt="poster" src="i/admin/poster.png">
                <h3 class="conf-step__movie-title">Звёздные войны XXIII: Атака клонированных клонов</h3>
                <p class="conf-step__movie-duration">130 минут</p>
            </div>

            <div class="conf-step__movie">
                <img class="conf-step__movie-poster" alt="poster" src="i/admin/poster.png">
                <h3 class="conf-step__movie-title">Миссия выполнима</h3>
                <p class="conf-step__movie-duration">120 минут</p>
            </div>

            <div class="conf-step__movie">
                <img class="conf-step__movie-poster" alt="poster" src="i/admin/poster.png">
                <h3 class="conf-step__movie-title">Серая пантера</h3>
                <p class="conf-step__movie-duration">90 минут</p>
            </div>

            <div class="conf-step__movie">
                <img class="conf-step__movie-poster" alt="poster" src="i/admin/poster.png">
                <h3 class="conf-step__movie-title">Движение вбок</h3>
                <p class="conf-step__movie-duration">95 минут</p>
            </div>

            <div class="conf-step__movie">
                <img class="conf-step__movie-poster" alt="poster" src="i/admin/poster.png">
                <h3 class="conf-step__movie-title">Кот Да Винчи</h3>
                <p class="conf-step__movie-duration">100 минут</p>
            </div> -->