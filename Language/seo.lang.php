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
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Account Panel for %server_name%'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Account Panel for %server_name%'] ,
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '% site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Account Panel for %server_name%!'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Account Panel for %server_name%!'] ,
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '% site_name% Account Panel for %server_name%!'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Support page
        'panel_support' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Support'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Support'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Support'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Support'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Support'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page
        'panel_donations' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Top-up Balance.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Top-up Balance'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Top-up Balance'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Top-up Balance'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Top-up Balance'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page is not for an authorized User
        'shop' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Store for %server_name%'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Store for %server_name%'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Store - Purchase of in-game items on the %server_name% server'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Store - Purchase of in-game items on the %server_name% server'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Store - Purchase of in-game items on the %server_name% server' ],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Settings page
        'panel_settings' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Profile Settings'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Profile Settings'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Profile Settings'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Profile Settings'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Profile Settings'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Login to the control panel
        'sign-in' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Login to the Account Panel'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Login to the Account Panel'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Login to the Account Panel'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Login to the Account Panel'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Login to the Account Panel'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Register a new master account
        'sign-up' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Create a New Master Account'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Create a new Master Account'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Create a new Master Account'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Create a new Master Account'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Create a new Master Account'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),

        // Reset the password from the master account
        'reminder' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Master Account Password Reset'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Master Account Password Reset'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Master Account password reset'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Master Account password reset'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Master Account password reset'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
	
    ),
    'gr'=> array(

        // General config for your personal account,
        'init' => array(
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Account Panel για %server_name%'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Account Panel για %server_name%'] ,
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '% site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Account Panel για %server_name%!'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Account Panel για %server_name%!'] ,
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '% site_name% Account Panel για %server_name%!'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Support page
        'panel_support' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Υποστήριξη'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Υποστήριξη'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Υποστήριξη'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Υποστήριξη'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Υποστήριξη'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page
        'panel_donations' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Ανανέωση Υπολοίπου.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Ανανέωση Υπολοίπου'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Ανανέωση Υπολοίπου'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Ανανέωση Υπολοίπου'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Ανανέωση Υπολοίπου'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Donation page is not for an authorized User
        'shop' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Μαγαζί για %server_name%.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Μαγαζί για %server_name%'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Μαγαζί - Αγορά items για τον server «%server_name%»'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% Store - Αγορά items για τον server «%server_name%»'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% Store - Αγορά items για τον server «%server_name%»' ],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Settings page
        'panel_settings' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Ρυθμίσεις'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Ρυθμίσεις'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Ρυθμίσεις'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Ρυθμίσεις'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Ρυθμίσεις'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Login to the control panel
        'sign-in' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Είσοδος στο Account Panel.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Είσοδος στο Account Panel'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Είσοδος στο Account Panel'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Είσοδος στο Account Panel'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Είσοδος στο Account Panel'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Register a new master account
        'sign-up' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Δημιουργία Νέου Master Account.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Δημιουργία Νέου Master Account'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Δημιουργία Νέου Master Account'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Δημιουργία Νέου Master Account'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Δημιουργία Νέου Master Account'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),

        // Reset the password from the master account
        'reminder' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Ανάκτηση Password Master Account.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Ανάκτηση Password Master Account'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'website'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Ανάκτηση Password Master Account'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Ανάκτηση Password Master Account'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Ανάκτηση Password Master Account'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
	
    ),  
	'es'=> array(

        // Configuración general para tu cuenta personal,
        'init' => array(
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Panel de cuenta para %server_name%'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Panel de cuenta para %server_name%'] ,
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '% site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Panel de cuenta para %server_name%!'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Panel de cuenta para %server_name%!'] ,
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '% site_name% Panel de cuenta para %server_name%!'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Página de soporte
        'panel_support' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Soporte'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Soporte'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Soporte'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Soporte'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Soporte'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Página de donación
        'panel_donations' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Recarga de Saldo.'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Recarga de Saldo'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Recarga de Saldo'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Recarga de Saldo'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Recarga de Saldo'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // La página de donación no es para un usuario autorizado
        'shop' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Tienda para %server_name%'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Tienda para %server_name%'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Tienda - Compra de artículos dentro del juego para el servidor %server_name%'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Tienda - Compra de artículos dentro del juego en el servidor %server_name%'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Tienda - Compra de artículos dentro del juego en el servidor %server_name%' ],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Página de ajustes
        'panel_settings' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Ajustes de Perfil'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Ajustes de Perfil'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Ajustes de Perfil'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Ajustes de Perfil'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Ajustes de Perfil'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Inicio de sesión al panel de control
        'sign-in' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Inicio de sesión al Panel de Control'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Inicio de sesión al Panel de Control'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Inicio de sesión al Panel de Control'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Inicio de sesión al Panel de Control'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Inicio de sesión al Panel de Control'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
        // Registrar una nueva cuenta maestra
        'sign-up' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Crear una Nueva Cuenta Maestra'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Crear una Nueva Cuenta Maestra'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Crear una Nueva Cuenta Maestra'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Crear una Nueva Cuenta Maestra'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Crear una Nueva Cuenta Maestra'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),

        // Restablecer la contraseña de la cuenta maestra
        'reminder' => array (
            'head' => array (
                ['idx' => 'title', 'typex' => 'title', 'content' => '%site_name% - Restablecimiento de Contraseña de la Cuenta Maestra'],
                ['idx' => 'og: title', 'typex' => 'meta', 'property' => 'og: title', 'content' => '%site_name% - Restablecimiento de Contraseña de la Cuenta Maestra'],
                ['idx' => 'og: site_name', 'typex' => 'meta', 'property' => 'og: site_name', 'content' => '%site_name%'],
                ['idx' => 'og: type', 'typex' => 'meta', 'property' => 'og: type', 'content' => 'sitio web'],
                ['idx' => 'og: url', 'typex' => 'meta', 'property' => 'og: url', 'content' => '%this_url%'],

                ['idx' => 'desc', 'typex' => 'meta', 'name' => 'description', 'content' => '%site_name% - Restablecimiento de Contraseña de la Cuenta Maestra'],
                ['idx' => 'og: description', 'typex' => 'meta', 'property' => 'og: description', 'content' => '%site_name% - Restablecimiento de Contraseña de la Cuenta Maestra'],
                ['idx' => 'tw_desc', 'typex' => 'meta', 'property' => 'twitter: description', 'content' => '%site_name% - Restablecimiento de Contraseña de la Cuenta Maestra'],

                ['idx' => 'keywords', 'typex' => 'meta', 'name' => 'keywords', 'content' => 'mmoweb, mmoweb4'],

            ),
        ),
	
    ),
);