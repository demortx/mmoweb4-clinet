<?php
if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}
/**
* Это главный ключ группы он хранится в админ панеле
* This is the main key of the group it is stored in the admin panel.
*/
define('API_KEY',       "q08YmsGbX0lC)54U7ZJ1");
/**
* Это URL центрального API
* This is the central API URL.
*/
define('API_URL',       "https://api.mmoweb.ru/");

/**
* Тут настраивается подключение к базе хостинга
* This is where the connection to the hosting database is configured.
*/
define('DB_HOST',       'localhost');
define('DB_NAME',       'mw4BSp');
define('DB_USER',       'u_mw4BSp');
define('DB_PASSWORD',   'fSf8D2UT');

/**
* Прочии настройки
* Other settings
*/
define('DEBUG',          TRUE);
define('DEBUG_IP',       '0.0.0.0');
define('DETECT_LANG',    TRUE);
define('UTF8_ENABLED',   TRUE);
define("VIEWPATH",       '/template');
define("CACHEPATH",      '/cache');


/**
* Готовые шаблоны можно купить в админ панели ммовеб
* Шаблон сайта. Находится: /template/site
* Ready-made templates can be bought in the admin panel of mmoweb
* Site template. Location: /template/site
*/
define('TEMPLATE',       'default'); //По умолчанию: default
define('TEMPLATE_DIR',   VIEWPATH . '/site/'.TEMPLATE); //Sys: полный путь к файлам шаблона

/**
* Настройки обрашений к АПИ
* API Settings
*/
define('CONNECTION_MAX_COUNT',  1);  //MAX Count connection
define('CONNECTION_TIME',       2);  //Sec

/**
* Доступ в панель управления базой данных предметов
* Access to the item database control panel
*/
define('ADMIN_PANEL',       true);
define('ADMIN_LOGIN',       'admin');
define('ADMIN_PASSWORD',    'admin');
define('ADMIN_IP',          '*'); //All ip: *

define('TEMPLATE_WYSIWYG',  true); //Использовать WYSIWYG HTML Editor или textarea
/**
* Продвинутые настройки
* Advanced settings
*/
define('CLOUD_FLARE',        true);         // Переопределение IP адресов от https://www.cloudflare.com/
define('HEADER_IP',         'REMOTE_ADDR'); // Источник ип адреса по умолчанию: REMOTE_ADDR

/**
* Кеширование информации сайт и лк. Время в секундах
* Caching information site and cp. Time in seconds
*/
define('CACHE_NEWS',            600);
define('CACHE_IBLOCK',          600);
define('CACHE_FORUM',           600);
define('CACHE_ONLINE',          600);
define('CACHE_RATING',          600);
define('CACHE_HISTORY_ONLINE',  86400);
define('CACHE_STREAM',          600);
#TODO Реализовать очистку временных файлов
define('DEL_CACHE_THROTTLER',   86400);
define('DEL_CACHE_DEBUG',       604800);

/**
 * Ключи стриминговых площадок
 * Streaming Keys
 */
define('TWITCH',                '3ayqtffruo2goxf0cvyp75wjm28g4pq');
define('YOUTUBE',               'AIzaSyDYcMbUnQGYPFTO-ADy1D4MrYI4xt-0_FY');

/**
 * Визуальная подгрузка предметов из базы данных кабинета
 * Visual loading of items from the cabinet database
 * /template/webdb.js  -- <span class='webdb-item' webdb-id="3936" title="" s-sid="8" s-name="true" s-add="true" s-icon="true" s-descr="true"></span>
 */
define('WEB_ITEM_DB',            true);
//Access-Control-Allow-Origin
define('ACAO_DB_GETAWAY',        '*');