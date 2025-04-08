//Запускаем отображение всех залов если они есть в база данных
chechHalls();

//Проверяем есть ли фильмы в базе данных и отрисовываем их
async function chechHalls() {
    try {
        //Получаем все фильмы из базы данных с помощью функции getFetchAllHalls
        const allHallFromDataBase = await getFetchAllHalls();

        //Если фильмы есть, то отрисовываем их
        if (allHallFromDataBase.length != 0) {
            displayHalls(allHallFromDataBase);
        }
    } catch (error) {
        console.error('Ошибка при получении данных залов', error);
    }
}

//Функция получения всех фильмов из базы данных
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

//Отрисовывание списка всех залов
function displayHalls(halls) {
    // console.log(halls);

    const htmlHallListManagement = document.getElementById('hall-list-management');
    htmlHallListManagement.textContent = '';

    halls.forEach(el => {
        const htmlLiHall = document.createElement('li');
        htmlLiHall.textContent = el.name;
        const buttonDelete = document.createElement('button');
        buttonDelete.classList.add('conf-step__button', 'conf-step__button-trash');
        buttonDelete.setAttribute('id', el.id);
        htmlLiHall.appendChild(buttonDelete);
        buttonDelete.addEventListener('click', deleteHall);
        htmlHallListManagement.appendChild(htmlLiHall);
    });
};

//Функция удаления залов
function deleteHall(event) {

    console.log(event.target.id);

    const hallId = event.target.id; // замените на реальный id зала
    const url = `/delete-hall/${hallId}`;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '', // обязательно для защиты от CSRF атак
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    }).then(data => {
        console.log('Зал успешно удалён:', data);
    }).catch(error => {
        console.error('Ошибка:', error.message);
    });

    chechHalls();
}

//js код удаления залов
// document.addEventListener("DOMContentLoaded", function () {
//     const token = document.head.querySelector('meta[name="csrf-token"]')?.content;

//     if (token) {
//         const buttonsDeleteHall = Array.from(document.querySelectorAll('.conf-step__button-trash'));
//         buttonsDeleteHall.forEach(button => button.addEventListener('click', async () => {
//             const hallId = button.dataset.hallId;
//             const closestLi = button.closest('li');

//             try {
//                 const response = await fetch('/delete-hall', {
//                     method: 'POST',
//                     headers: {
//                         'X-CSRF-TOKEN': token, // Здесь используем токен из метатега
//                         'Content-Type': 'application/json'
//                     },
//                     body: JSON.stringify({ hall_id: hallId })
//                 });

//                 if (!response.ok) {
//                     throw new Error('Ошибка при удалении зала');
//                 }

//                 const data = await response.json();
//                 console.log(data.message);
//                 closestLi.remove(); // Удаляем элемент из DOM
//             } catch (error) {
//                 alert('Ошибка при удалении зала');
//                 console.error(error);
//             }
//         }));
//     }
// });