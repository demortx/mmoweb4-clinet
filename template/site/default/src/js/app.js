/* Google fonts */
let WebFontConfig = {
    google: {
        families: __config.gFonts.fonts
    },
    timeout: __config.gFonts.delay // Set the timeout to two seconds
};
(function () {
    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();


hidePreload(function () {
    mediaInit();
    Copy();
});

/* hidePreload */

function hidePreload(fn) {
    setTimeout(function () {
        $('.preload').addClass('preload_fade').fadeOut(400, function () {
            $('.preload').remove();
            if (typeof fn == 'function') fn();
        });
    }, __config.preloader.timeMax * 1000);
    if (__config.preloader.hideByClick) {
        $('.preload').on('click', function () {
            $('.preload').addClass('preload_fade').fadeOut(400, function () {
                $('.preload').remove();
            });
        });
    }
}

// navigation
$(function () {
    // Front-end developer: L2Banners | Get-Web.Site
    var burgerBtn = $('.gw-burger');
    var menuWrp = $('.gw-nav');
    var menuLink = $('.gw-nav__link');

    burgerBtn.click(function () {
        burgerBtn.toggleClass('gw-burger_active');
        menuWrp.toggleClass('gw-nav_active');
    });
});

function calcTime(offset) {

    // create Date object for current location
    let d = new Date();

    // convert to msec
    // add local time zone offset 
    // get UTC time in msec
    let utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    let nd = new Date(utc + (3600000 * offset));

    // return time as a string
    return nd;

}


var newDate = calcTime(__config.eDate.timeZone);
__config.eDate.month = __config.eDate.month - 1;

var expiryDate = new Date(__config.eDate.year, __config.eDate.month, __config.eDate.day, __config.eDate.hour, __config.eDate.minute, __config.eDate.second);
var nowDate = new Date();
if (expiryDate.getTime() > newDate.getTime()) {
    $('.counter_js').countdown({
        until: expiryDate,
        format: __config.eDate.format,
        layout: '<div class="gw-timer">' +
            '{y<}<div class="gw-timer__item"><div class="gw-timer__amount">{yn}</div><div class="gw-timer__desc">{yl}</div></div>{y>}' +
            '{o<}<div class="gw-timer__item"><div class="gw-timer__amount">{on}</div><div class="gw-timer__desc">{ol}</div></div>{o>}' +
            '{d<}<div class="gw-timer__item"><div class="gw-timer__amount">{dnn}</div><div class="gw-timer__desc">{dl}</div></div>{d>}' +
            '{h<}<div class="gw-timer__item"><div class="gw-timer__amount">{hnn}</div><div class="gw-timer__desc">{hl}</div></div>{h>}' +
            '{m<}<div class="gw-timer__item"><div class="gw-timer__amount">{mnn}</div><div class="gw-timer__desc">{ml}</div></div>{m>}' +
            '{s<}<div class="gw-timer__item"><div class="gw-timer__amount">{snn}</div><div class="gw-timer__desc">{sl}</div></div>{s>}' +
            '</div>',
        timezone: __config.eDate.timeZone,
        // until: shortly,
        // onExpiry: liftOff,
        // onTick: watchCountdown,
        // format: 'dHMS',
    });
} else {
    $('.counter_js').html('<div class="end-time">' + __config.eDate.endTimeMSG + '</div>');
}

/* servers */

$(function () {
    var server_1 = $('.server__progress:eq(0)');

    server_1.circleProgress({
        value: server_1.attr('data-online') / __config.server.maxOnline["server 1"],
        thickness: 4,
        startAngle: 4.73,
        size: 100,
        fill: {
            image: __config.server.progressImg
        }
    });
    var server_2 = $('.server__progress:eq(1)');
    server_2.circleProgress({
        value: server_2.attr('data-online') / __config.server.maxOnline["server 2"],
        thickness: 4,
        startAngle: 4.73,
        size: 100,
        fill: {
            image: __config.server.progressImg
        }
    });
});

/* media */

function mediaInit() {
    setTimeout(function () {
        $('[data-video-youtube]').each(function (indx, element) {
            const el = $(element);
            el.html('<iframe width="300" height="200" src="https://www.youtube.com/embed/' + el.attr('data-video-youtube') +
                '?autoplay=' + (el.attr('data-video-autoplay') == 'false' ? 0 : 1) +
                '&mute=1" frameborder="0"' +
                'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"' +
                'allowfullscreen></iframe>');
        });

    }, __config.streams.delay);

    setTimeout(function () {
        $('[data-video-twitch]').each(function (indx, element) {
            const el = $(element);
            el.html('<iframe src="https://player.twitch.tv/?channel=' + el.attr('data-video-twitch') +
                '&autoplay=' + (el.attr('data-video-autoplay') == 'false' ? 'false' : 'true') +
                '&parent=' + document.domain + '" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe>');
        });

    }, __config.streams.delay);
}

// tabs
$(function () {
    // Front-end developer: L2Banners | Get-Web.Site

    $('.rating-btn').on("click", function () {
        if (!$(this).is('.rating-btn_active')) {
            const __this = $(this);
            const ratingBtns = __this.closest('[data-rating-btns]');
            ratingBtns.find('.rating-btn_active').removeClass('rating-btn_active');
            ratingBtns.siblings('[data-rating]').find('[data-rating-tab]').removeClass('rating__tab_active');
            ratingBtns.siblings('[data-rating]').find('[data-rating-tab]').eq(__this.index()).addClass('rating__tab_active');
            __this.addClass('rating-btn_active');

        }
    });

    $('.rating-sub-btn').on("click", function () {
        if (!$(this).is('.rating-btn-sub_active')) {
            const __this = $(this);
            const ratingBtns = __this.closest('[data-sub-rating-btns]');
            ratingBtns.find('.rating-sub-btn_active ').removeClass('rating-sub-btn_active ');
            ratingBtns.siblings('[data-sub-rating]').find('[data-sub-rating-tab]').removeClass('rating__tab_active');
            ratingBtns.siblings('[data-sub-rating]').find('[data-sub-rating-tab]:eq(' + __this.index() + ')').addClass('rating__tab_active');
            __this.addClass('rating-sub-btn_active ');

        }
    });


    $('.rating-btn:nth-child(1)').trigger('click');
    $('.rating-sub-btn:nth-child(1)').trigger('click');

});



/* fancybox */

$.fancybox.defaults.animationDuration = 300;
$.fancybox.defaults.autoFocus = false;
$.fancybox.defaults.touch = false;

$('body').on('click', '[data-open-window]', function () {
    $.fancybox.getInstance('close');
    let target = $(this).attr('data-open-window');
    $.fancybox.open({
        src: '#' + target,
        type: 'inline',
        selectable: true,
        opts: {
            smallBtn: false,
            toolbar: false,
            touch: false,
            afterShow: function (instance, current) {

            }
        }
    });
})


$(document).on('submit', 'form', function () {
    if (!verifyСheckboxInForm($(this))) return !1
});

function verifyСheckboxInForm(a) {
    let b = a.find('[data-checkbox-required]:not(:checked)');
    return !(0 < b.length) || (colorBoxOpen(b.eq(0).attr('data-checkbox-required')), !1)
}


function colorBoxOpen(txt, ttl) {
    let title = ttl || 'Warning',
        text = txt || 'Что-то пошло не так';
    $.fancybox.open('<div class="warning warning_animated"><div><div class="warning__title">' + title + '</div>' + text + '</div></div>');
}

/* Copyright */

function Copy() {
    console.log('%c Жулик, не воруй! ', 'background: #222; color: red; font-size: 30px');
    console.log("Front-end developer: L2Banners | Get-Web.Site");
    console.log("Designer: Mex-vision");
    console.log("for MMOweb");
}

/* Ramdom number */

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

/* Rounding number */

function roundingNum(x, n) {
    return parseFloat(Number.parseFloat(x).toFixed(n || 2));
}