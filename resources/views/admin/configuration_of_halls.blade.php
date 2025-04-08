<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
    </header>
    <div class="conf-step__wrapper">
        <form action="/create-seats" method="POST">
            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
            <ul class="conf-step__selectors-box">            
                    @csrf
                    @foreach($halls as $hall)
                        <li>
                            <input type="radio" class="conf-step__radio" name="idHall" value="{{ $hall->id }}" 
                                @if ($loop->first)
                                    checked
                                @endif>
                            <span class="conf-step__selector">{{ $hall->name }}</span>
                        </li>
                    @endforeach
            </ul>
            <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Рядов, шт<input type="text" class="conf-step__input" placeholder="10" name="rows"></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">Мест, шт<input type="text" class="conf-step__input" placeholder="8" name="seats_per_row"></label>
            </div>
            <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>

            <div class="conf-step__hall">
                <div class="conf-step__hall-wrapper">
                    
                    
                </div>
            </div>

                <!-- Скрытое поле для передачи массива arraySeats -->
                <input type="hidden" name="arraySeats" id="arraySeats">

            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </form>
    </div>
</section>
<!-- Подключение скрипта отображерния всех кресел в выбарнном зале -->
<script src="{{ asset('js\show-all-seats.js') }}"></script>
