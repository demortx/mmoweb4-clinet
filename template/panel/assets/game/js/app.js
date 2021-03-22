document.addEventListener("DOMContentLoaded", function (event) {
    /* game */
    let gameListBox = $('[data-game-list]');
    let btnStart = $('[data-game-start]');
    /*let casesListBox = $('[data-cases-list]');*/

    let activeApp = false;

    if (gameListBox.length == 0) return;
    /* Вставляем стартовые итемы */
    gameListBox.append(gameListItemsBuilder(game.items, game.styles, 32));
    gameListBox.find('.itm:nth-child(3)').addClass('itm_active');

    btnStart.on('click', function () {

        if (activeApp) return;
        activeApp = true;

        const __this = $(this);

        /* Звук клика */
        gameSoundCheck(
            function () {
                makeSound(game.urlSounds + 'click.mp3')
            }
        );

        /* Дактивируем кнопку */
        __this.attr('data-game-start', 'false');

        /* Деактивируем активный итем */
        $('.itm_active, .itm_win').removeClass('itm_active itm_win');

        /* Очищаем содержимое кейса */
        // casesListBox.find('.case').remove();

        /* Отправляем запрос */
        $.ajax({
            url: '/input',
            type: "post",
            dataType: "json",
            data: {
                module_form: game.module_form,
                module: game.module,
                cases_id: game.cases_id
            },
            // после получения ответа сервера
            success: function (data) {
                console.log(data);
                if (data.result != 'success') {
                    jQuery.notify({
                        icon: data.icon || '',
                        message: data.text,
                        url: data.url || ''
                    }, {
                        element: 'body',
                        type: data.status || 'info',
                        allow_dismiss: true,
                        newest_on_top: true,
                        showProgressbar: false,
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 10000,
                        delay: data.time_show || 5000,
                        timer: 1000,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOutDown'
                        }
                    });
                    return;
                }

                //  добавляем полученый кейс в объект
                if (data.item && data.item != '') {
                    game.win.item = data.item
                }

                //  добавляем содержимое полученного кейса в объект
                /*if (data.items && data.items != '') {
                    game.win.items = data.items
                }*/

                $('.balance_html').html(data.balance);

                /* Вставляем выиграшный итем последним и добавляем класс itm_win */
                gameListBox.append(gameListItemsBuilder([game.win.item], game.styles, 1, 'itm_win'));
                /* Вставляем в конце еще два итем чтобы заполнить пустоту*/
                gameListBox.append(gameListItemsBuilder(game.items, game.styles, 2));

                setTimeout(() => {
                    /* Запускаем анимацию */
                    gameListBox.attr('data-game-list', 'animated');

                    gameListBox.css("left", getRandomInt(-100, 70) + "px")

                    /* Запускаем звук анимации */
                    gameSoundCheck(
                        function () {
                            makeSound(game.urlSounds + 'ticking.mp3')
                        }
                    );

                }, 1000);

            }
        });

    });

    /* Вешаем событие на окончание анимации  */
    gameListBox.on("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", function () {

        /* Добавляем класс itm_active к itm_win */
        $('.itm_win').addClass('itm_active');

        /* Запускаем звук победы */
        gameSoundCheck(
            function () {
                makeSound(game.urlSounds + 'win.mp3')
            }
        );

        /* Очищаем содержимое кейса */
        /*casesListBox.find('.case').remove();*/

        /* Вставляем содержимое кейса */
        /*casesListBox.html(CasesItemsBuilder(game.win.items));*/

        /* Обрезаем все итемы слева оставляя видимыми текущие 5 */
        gameListBox.find('.itm').slice(0, 30).remove();

        /* Убираем анимацию */
        gameListBox.attr('data-game-list', '');

        /* Вставляем новые итемы справа с учетом того что с лева остаются 5 итемов */
        gameListBox.append(gameListItemsBuilder(game.items, game.styles, 27));

        /* Разрешаем запустить приложение вновь */
        activeApp = false;

        /* Активируем кнопку старт */
        btnStart.attr('data-game-start', 'true');

    });


});


function gameListItemsBuilder(items, styles, count, cls) {
    let itmClass = cls || '';
    let stylesLength = styles.length;
    let itemsHTML = '';
    for (let i = 0; i < count; i++) {
        let item = items[getRandomInt(0, items.length)]
        itemsHTML += `
        <div class="itm ${styles[getRandomInt(0, stylesLength)]} ${itmClass}">
            <div class="itm__pic">
                <img src="${item.img}" alt="" class="itm__img">
            </div>
            <div class="itm__container">
                <div class="itm__title">${item.name}</div>
                <div class="itm__count">x${item.count}</div>
            </div>
        </div>
        `
    }
    return itemsHTML;
}

function CasesItemsBuilder(items) {
    let itemsHTML = '';
    items.forEach(item => {
        itemsHTML += `
         <a href="#" class="cases__case case">
            <div class="case__pic">
                <img src="${item.img}" alt="" class="case__img">
            </div>
            <div class="case__title">${item.name}</div>
            <div class="case__content">${item.desc}</div>
            ${item.count>1?'<div class="case__type">x'+item.count+'</div>':""}
        </a>
        `
    });
    return itemsHTML;
}


document.addEventListener("DOMContentLoaded", function (event) {
    /* wheel */
    let wheelBox = $('[data-wheel-box]');
    let wheelListBox = $('[data-wheel-list]');
    let btnStart = $('[data-wheel-start]');
    let prize = $('[data-bprize]');
    let prizeContainer = $('[data-bprize-container]');
    let prizeMore = $('[data-bprize-more]');
    let historyNow = $('[data-history-now]');

    let activeApp = false;

    if (wheelListBox.length == 0) return;

    /* Генерируем стартовые итемы */

    wheel.itemsStorage = itemsStorageBuilder(wheel.items, wheel.styles, 2);
    wheel.itemsStorage.push(...itemsStorageBuilder(wheel.items, wheel.styles, 1, 'itm_active'));
    wheel.itemsStorage.push(...itemsStorageBuilder(wheel.items, wheel.styles, 34));

    /* Вставляем стартовые итемы */
    wheelListBox.append(wheelItemsBuilder(wheel.itemsStorage));

    btnStart.on('click', function () {

        if (activeApp) return;
        activeApp = true;

        const __this = $(this);

        /* Звук клика */
        gameSoundCheck(
            function () {
                makeSound(wheel.urlSounds + 'click.mp3')
            }
        );

        /* Дактивируем кнопку */
        __this.attr('data-wheel-start', 'false');

        /* Отправляем запрос */
        $.ajax({
            url: '/input',
            type: "post",
            dataType: "json",
            data: {
                module_form: wheel.module_form,
                module: wheel.module
            },
            // после получения ответа сервера
            success: function (data) {
                console.log(data);
                if (data.result != 'success') {

                    jQuery.notify({
                        icon: data.icon || '',
                        message: data.text,
                        url: data.url || ''
                    }, {
                        element: 'body',
                        type: data.status || 'info',
                        allow_dismiss: true,
                        newest_on_top: true,
                        showProgressbar: false,
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 10000,
                        delay: data.time_show || 5000,
                        timer: 1000,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOutDown'
                        }
                    });
                    return;
                }

                //  добавляем полученый кейс в объект
                if (data.item && data.item != '') {
                    wheel.win.item = data.item
                }

                $('.balance_html').html(data.balance);
                $('.gbal__num').html(data.count);

                /* Вставляем выиграшный итем последним и добавляем класс itm_win */

                wheel.itemsStorage.push(...itemsStorageBuilder([wheel.win.item], wheel.styles, 1, 'itm_win'));

                /* Вставляем в конце еще два итем чтобы заполнить пустоту */
                wheel.itemsStorage.push(...itemsStorageBuilder(wheel.items, wheel.styles, 2));

                /* Заменяем html итемы */
                wheelListBox.html(wheelItemsBuilder(wheel.itemsStorage));

                /* Деактивируем активный итем */
                setTimeout(() => {
                    $('.itm_active, .itm_win').removeClass('itm_active_tmp');
                }, 0);

                setTimeout(() => {
                    $('.itm_active, .itm_win').removeClass('itm_win itm_active');
                }, 0);

                setTimeout(() => {
                    /* Запускаем анимацию */
                    wheelListBox.attr('data-wheel-list', 'animated');

                    let rotate = getRandomInt(-3, 3);

                    wheelBox.css("transform", `rotate(${rotate}deg)`)

                    /* Запускаем звук анимации */
                    gameSoundCheck(
                        function () {
                            setTimeout(() => {
                                makeSound(wheel.urlSounds + 'wheel-ticking.mp3')
                            }, rotate < 0 ? rotate * 30 : 40);
                        }
                    );

                }, 1000);

            }
        });

    });

    /* Вешаем событие на окончание анимации  */
    wheelListBox.on("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", function () {

        /* Вставляем выигрышный итем */
        prizeContainer.html(prizeBuilder(wheel.win.item));

        /* Обрезаем все итемы слева оставляя видимыми текущие 5 */
        wheel.itemsStorage = wheel.itemsStorage.slice(-5);

        /* Вставляем новые итемы в массив к первым пяти 5 итемам */
        wheel.itemsStorage.push(...itemsStorageBuilder(wheel.items, wheel.styles, 32));

        /* Заменяем html итемы */
        wheelListBox.html(wheelItemsBuilder(wheel.itemsStorage));

        /* Убираем анимацию */
        wheelListBox.attr('data-wheel-list', '');

        setTimeout(() => {
            /* Добавляем класс itm_active к itm_win */
            $('.itm_win').addClass('itm_active');
            wheel.itemsStorage[2].class = 'itm_win itm_active itm_active_tmp';
        }, 0);

        setTimeout(() => {
            /* Показываем приз */
            prize.attr('data-bprize', 'visible');

            /* Запускаем звук победы */
            gameSoundCheck(
                function () {
                    makeSound(wheel.urlSounds + 'win.mp3')
                }
            );

            /* Показываем приз в истории */
            historyNow.removeClass('history__box_hidden');
            historyNow.find('.history__list').prepend(historyItemBilder(wheel.win.item));

        }, 1000);



    });

    prizeMore.on('click', function () {

        /* Прячем приз */
        prize.attr('data-bprize', 'hidden');

        /* Очищаем выигрышный итем */
        prizeContainer.html(prizeBuilder(wheel.win.item));

        /* Разрешаем запустить приложение вновь */
        activeApp = false;

        /* Активируем кнопку старт */
        btnStart.attr('data-wheel-start', 'true');

    });


});

function itemsStorageBuilder(items, styles, count, cls) {
    let itmClass = cls || '';
    let stylesLength = styles.length;
    let itemsArr = [];
    for (let i = 0; i < count; i++) {
        let item = items[getRandomInt(0, items.length)];
        itemsArr.push({
            name: item.name,
            desc: item.desc,
            count: item.count,
            enc: item.enc,
            img: item.img,
            style: styles[getRandomInt(0, stylesLength)],
            class: itmClass,
        });
    }
    return itemsArr;
}

function wheelItemsBuilder(items) {

    itemsHTML = '';

    items.forEach(item => {
        let count = item.count > 1 ? `<div class="itm__count" title="Count">x${item.count}</div>` : '';
        let enc = item.enc > 0 ? ` +${item.enc}` : '';
        itemsHTML += `
        <div class="wheel__itm itm ${item.style} ${item.class}">
            <div class="itm__pic">
                <img src="${item.img}" alt="${item.name}" class="itm__img">
            </div>
            <div class="itm__container">
                <div class="itm__title">${item.name} ${enc}</div>
                ${count}
            </div>
        `
    });

    items.forEach(item => {
        itemsHTML += `
        </div>
        `
    });

    return itemsHTML;
}

function prizeBuilder(item) {
    let name = item.name || '';
    let desc = item.desc || '';
    let img = item.img || '';
    let count = item.count > 1 ? `<div class="bprize__rate" title="Count">x${item.count}</div>` : '';
    let enc = item.enc > 0 ? `<div class="bprize__type" title="Enchantments">+${item.enc}</div>` : '';
    return itemsHTML = `
    <div class="bprize__item">
        <div class="bprize__name">${name}</div>
        <div class="bprize__pic">
            <img src="${img}" class="bprize__img">
        </div>
        <div class="bprize__desc">${desc}</div>
        <div class="bprize__info">
            ${count}
            ${enc}
        </div>
    </div>
    `;
}

function historyItemBilder(item) {
    let name = item.name || '';
    let desc = item.desc || '';
    let img = item.img || '';
    let count = item.count > 1 ? `<div class="hitem__rate" title="Count">x${item.count}</div>` : '';
    let enc = item.enc > 0 ? `<div class="hitem__type" title="Enchantments">+${item.enc}</div>` : '';
    return `<div class="history__hitem hitem">
        <div class="hitem__pic pic-style-0">
            <img src="${img}" class="hitem__img">
        </div>
        <div class="hitem__container">
            <div class="hitem__title">${name}</div>
            <div class="hitem__desc">${desc}</div>
            <div class="hitem__info">
                ${count}
                ${enc}
            </div>
        </div>
    </div>`
}

/* General scripts   */

document.addEventListener("DOMContentLoaded", function (event) {
    /* tippy */
    (function toolTIP() {
        tippy('[data-tlt]', {
            delay: 0,
            flip: true,
            arrow: false,
            followCursor: true,
            placement: 'right-start',
            theme: 'tlt',
            maxWidth: '250px',
            content(reference) {
                return $(reference).find('[data-tlt-content]').html() || "";
            }
        });
    })();
});

document.addEventListener("DOMContentLoaded", function (event) {
    /* sound */
    let gameSound = $('[data-game-sound]');
    if (localStorage.getItem('gameSound') == 'false') {
        gameSound.attr('data-game-sound', 'false');
    }
    gameSound.on('click', function () {
        const __this = $(this);

        //  localStorage.getItem('gameSound') == null || localStorage.getItem('gameSound') == 'false'
        if (localStorage.getItem('gameSound') == 'false') {
            localStorage.setItem('gameSound', 'true');
            __this.attr('data-game-sound', 'true');
        } else {
            localStorage.setItem('gameSound', 'false');
            __this.attr('data-game-sound', 'false');
        }
    });
});

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function makeSound(soundURL) {
    var audio = new Audio(soundURL);
    audio.play();
}

function gameSoundCheck(fn) {
    if (localStorage.getItem('gameSound') == null || localStorage.getItem('gameSound') == 'true') {
        fn();

    }
}

window.raf = (function () {
    return (
        window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function ( /* function */ callback, /* DOMElement */ element) {
            window.setTimeout(callback, 1000 / 60);
        }
    );
})();