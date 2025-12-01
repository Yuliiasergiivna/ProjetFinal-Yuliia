

// 1. Асинхронно загружаем API YouTube Iframe Player
let tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
let firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

let player; // Объявляем глобальную переменную для плеера YouTube

// 2. Функция, вызываемая API YouTube после его загрузки
function onYouTubeIframeAPIReady() {
    // Получаем элемент iframe
    const warVideoIframe = document.getElementById('warVideo');
    if (warVideoIframe) {
        // Создаем объект плеера
        player = new YT.Player('warVideo', {
            events: {
                // Привязываем функцию к событию "видео закончилось"
                'onStateChange': onPlayerStateChange
            }
        });
    }
}

// 3. Функция для обработки событий плеера
function onPlayerStateChange(event) {
    // Код 0 означает, что воспроизведение завершено
    if (event.data === YT.PlayerState.ENDED) {
        // Запускаем функцию возврата на главную
        returnToMain();
    }
}

// 4. Функция для скрытия видео и возврата к основному контенту
function returnToMain(hideOverlay = false) {
    const warVideoContainer = document.getElementById('warVideoContainer');
    const warOverlay = document.getElementById('warOverlay'); // Получаем оверлей

    // Скрываем контейнер видео
    if (warVideoContainer) {
        warVideoContainer.style.display = 'none';
        // Обязательно останавливаем видео, чтобы оно не играло в фоне
        if (player && player.stopVideo) {
             player.stopVideo();
        }
    }
        // 2. Если нажата кнопка "Вернуться на главную" на красном оверлее, скрываем и его.
    if (hideOverlay && warOverlay) {
        warOverlay.style.display = 'none';
    }
    // Прокручиваем страницу в начало (к карте)
    window.scrollTo({ top: 0, behavior: 'smooth' });
}


document.addEventListener('DOMContentLoaded', function() {
    const warTriggerLink = document.getElementById('warTriggerLink');
    const warOverlay = document.getElementById('warOverlay');
    const warVideoContainer = document.getElementById('warVideoContainer');
    const startVideoBtn = document.getElementById('startVideoBtn');
    const returnToMainBtn = document.getElementById('returnToMainBtn');
    // const warVideo = document.getElementById('warVideo');
    const body = document.body;

     if (warVideoContainer) {
        warVideoContainer.style.display = 'none';
    }
    if (warTriggerLink && warOverlay) {
        warTriggerLink.addEventListener('click', function(event) {
            event.preventDefault(); // П

            // 1. Экран мигает красным
            body.classList.add('flash-red');

            // Удаляем класс мигания после анимации (чтобы не мешать)
            setTimeout(() => {
                body.classList.remove('flash-red');
                // 2. Показываем красный блок с сообщением
                warOverlay.style.display = 'flex'; // Делаем блок видимым

                // // 3. Задержка 3 секунды, затем запускаем видео
                // setTimeout(() => {
                //     warOverlay.style.display = 'none';
                //     warVideoContainer.style.display = 'block';
                //     warVideoContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                //     warVideo.play(); // Запускаем видео
                // }, 3000); // 3-секундная задержка
                
            }, 500); // Длительность анимации мигания (0.5 секунды)
        });
    }
    if (startVideoBtn && warVideoContainer && warOverlay) {
        startVideoBtn.addEventListener('click', function() {
            // 1. Скрываем красный блок со словами и кнопками
            warOverlay.style.display = 'none'; 

            // 2. Показываем контейнер видео
            warVideoContainer.style.display = 'flex'; // Используем flex для центрирования

            // 3. Запускаем видео через API (самый надежный способ)
            if (player && player.playVideo) {
                 player.playVideo();
            }
            
            // Переводим окно просмотра к видео
            // warVideoContainer.scrollIntoView({ behavior: 'smooth', block: 'center' }); 
        });
    }

    // Обработчик для кнопки "Вернуться на главную"
    if (returnToMainBtn) {
        returnToMainBtn.addEventListener('click', () => returnToMain (true));
    }
});
