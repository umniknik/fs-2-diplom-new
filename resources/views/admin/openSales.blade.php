<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
    </header>
    <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <form action="/api/halls-is-active" method="POST">
            @csrf
            <button class="conf-step__button conf-step__button-accent" id="buttonOpenSales"></button>
        </form>

        <script type="text/javascript">
            /**
             * 1) Этот скрипт решает какую отобразить надпись на кнопке "открыть/закрыть продажу билетов"
             */

            checkOpenSales();

            //Отправляем запрос в базу данных, чтобы получить значение свойства "Открыта ли продажа бидетов"
            async function checkOpenSales() {
                try {
                    //С помощью функции getOpenSalesValue получаем true или fulse из столбца halls_is_active
                    const halls_is_active = await getOpenSalesValue();

                    //Если продажа билетов открыта, то пишем на кнопке 'Закрыть продажу билетов', иначе наоборот
                    if (halls_is_active) {
                        document.getElementById('buttonOpenSales').textContent = 'Закрыть продажу билетов';
                    } else {
                        document.getElementById('buttonOpenSales').textContent = 'Открыть продажу билетов';
                    }
                } catch (error) {
                    console.error('Ошибка при получении данных:', error);
                }
            };

            // функция получения значения столбца halls_is_active из баззы данных 
            async function getOpenSalesValue() {
                try {
                    const response = await fetch(`/api/halls-is-active`);
                    const data = await response.json();
                    return data; // Возвращаем данные как результат промиса
                } catch (error) {
                    console.error('Ошибка:', error);
                    throw error; // Прекращаем выполнение, если возникла ошибка
                }
            }
        </script>

    </div>
</section>