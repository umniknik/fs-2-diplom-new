//Вешаем слушатели на кнопки выбора залов
const buttonsPriceHall = Array.from(document.querySelectorAll('input[name="prices-hall"]'));
buttonsPriceHall.forEach(element => {
    element.addEventListener('click', (event) => {
        const idHall = event.target.value;
        //очищаем поля
        document.querySelector('input[name="priceForRegularChair"]').value = '';
        document.querySelector('input[name="priceForVipChair"]').value = '';
        //Запускаем функцию отображения цен из базы данных
        checkPriceSeatInHall(idHall);
    });
});

//Запускаем функцию проверки цена по первому залу и отображения 
checkPriceSeatInHall(1);

//Отправляем запрос в базу данных чтобы получить места для первого зала и отобразить их на странице. Если мест нет, то оставим поле мест пустым 
async function checkPriceSeatInHall(idHall) {
    try {
        //С помощью функции getPricesByHallId получаем места из первого зала
        const allPricesFromDatabase = await getPricesByHallId(idHall);

        //Проверяем есть ли места в зале, если есть то отрисовываем их
        if (allPricesFromDatabase.length != 0) {
            //console.log(allPricesFromDatabase);
            //есть в зале есть места то заполняем поля инпут и отрисовываем их, если нет то
            displayPricesFromDatabase(allPricesFromDatabase);
        } else {
            // PricesElements.innerHTML = ''; //очищаем поле место на странице куда будем вставлять код отображения сидений
        }
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
};

// функция получения списка всех мест выбранного зала из баззы данных 
async function getPricesByHallId(idHall) {
    try {
        const response = await fetch(`/api/halls/${idHall}/prices`);
        const data = await response.json();
        return data; // Возвращаем данные как результат промиса
    } catch (error) {
        console.error('Ошибка:', error);
        throw error; // Прекращаем выполнение, если возникла ошибка
    }
}

//Функция добавления значений полученных из базы данных в поля input 
function displayPricesFromDatabase(oldPrices) {
    //Ищем в массиве, полученном с сервера, запись у которой есть type === 'regular'
    const regularPriceItem = oldPrices.find(item => item.type === 'regular');
    if (regularPriceItem) {
        //Если есть то в значение инпут добавляем цену типа места
        document.querySelector('input[name="priceForRegularChair"]').value = regularPriceItem.price;
    }

    //Ищем в массиве, полученном с сервера, запись у которой есть type === 'vip'
    const vipPriceItem = oldPrices.find(item => item.type === 'vip');
    if (vipPriceItem) {
        //Если есть то в значение инпут добавляем цену типа места
        document.querySelector('input[name="priceForVipChair"]').value = vipPriceItem.price;
    }
}

