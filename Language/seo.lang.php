<?php

/**
 *  %site_name%             => Имя проекта,
 *  %server_name%           => Имя текушего сервера,
 *  %platform_server_name%  => Платформа и имя сервера пример: Lineage2 > Gracia Final,
 *  %url%                   => ссылка на сайт пример: https://mw4.mmoweb.ru/,
 *  %this_url%              => текуший адрес пример: https://mw4.mmoweb.ru/shop,
 *
 *  Class/SeoX.php method initReplaceTeg() Добовление тегов
 */


return array(
    'ru' => array(
        //Общий конфиг для лк
        'init' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Личный кабинет сервер %server_name%.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Личный кабинет сервер %server_name%.'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Личный кабинет сервер %server_name%!'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Личный кабинет сервер %server_name%!'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Личный кабинет сервер %server_name%!'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница супорта
        'panel_support' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Служба техподдержки.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Служба техподдержки.'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Служба техподдержки.'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Служба техподдержки.'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Служба техподдержки.'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница пожертвования
        'panel_donations' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Пополнения баланса.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Пополнения баланса'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Пополнения баланса'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Пополнения баланса'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Пополнения баланса'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница пожертвования не для авторизованного
        'donations' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Пополнения баланса персонажа на сервере %server_name%.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Пополнения баланса персонажа на сервере %server_name%'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Пополнения баланса персонажа на сервере %server_name%'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Пополнения баланса персонажа на сервере %server_name%'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Пополнения баланса персонажа на сервере %server_name%'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница пожертвования
        'panel_shop' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Магазин сервера %server_name%.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Магазин сервера %server_name%.'],
                ['idx' => 'og:site_name','typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница пожертвования не для авторизованного
        'shop' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Магазин сервера %server_name%.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Магазин сервера %server_name%'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Магазин, покупка внутриигровых ценностей на сервере %server_name%'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Страница настроек
        'panel_settings' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Персональные настройки профиля.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Персональные настройки профиля'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Персональные настройки профиля'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Персональные настройки профиля'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Персональные настройки профиля'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Авторизация в панель управления
        'sign-in' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Авторизация в панель управления.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Авторизация в панель управления'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Авторизация в панель управления'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Авторизация в панель управления'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Авторизация в панель управления'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Регистрации нового мастер аккаунта
        'sign-up' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Регистрации нового мастер аккаунта.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Регистрации нового мастер аккаунта'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Регистрации нового мастер аккаунта'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Регистрации нового мастер аккаунта'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Регистрации нового мастер аккаунта'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        //Восстановить пароль от мастер аккаунта
        'reminder' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Восстановить пароль от мастер аккаунта.'],
                ['idx' => 'og:title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Восстановить пароль от мастер аккаунта'],
                ['idx' => 'og:site_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og:type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og:url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%this_url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Восстановить пароль от мастер аккаунта'],
                ['idx' => 'og:description',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Восстановить пароль от мастер аккаунта'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Восстановить пароль от мастер аккаунта'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),

    ),
	'en'=> array(

        // General config for your personal account,
        'init' => array(
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Personal account server %server_name%.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Personal account server %server_name%.'] ,
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '% site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Personal account server %server_name%!'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Personal account server %server_name%!'] ,
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '% site_name% Personal account server %server_name%!'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Support page
        'panel_support' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Technical Support.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Technical Support.'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Technical Support.'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Technical Support.'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Technical Support.'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page
        'panel_donations' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Top up balance.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Top up balance'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Top up balance'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Top up balance'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Top up balance'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page is not for an authorized User
        'shop' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Server store% server_name%.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Server store %server_name%'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '% site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '% this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Store, purchase of in-game items on the server %server_name%'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Shop, purchase of in-game items on the server %server_name% '],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Shop, purchase of in-game items on the server %server_name%' ],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Settings page
        'panel_settings' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Personal profile settings.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Personal Profile Settings'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Personal Profile Settings'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Personal Profile Settings'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Personal Profile Settings'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Login to the control panel
        'sign-in' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Login to the control panel.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Login to the control panel'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Login to the control panel'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Login to the control panel'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Login to the control panel'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Register a new master account
        'sign-up' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Register a new master account.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Register a new master account'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Register a new master account'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Register a new master account'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Register a new master account'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),

        // Reset the password from the master account
        'reminder' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% Reset the password from the master account.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% Reset password from the master account'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% Reset password from the master account'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Reset password from the master account'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Reset password from the master account'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
	
	)

);