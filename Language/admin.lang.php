<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 04.10.2019
 * Time: 17:46
 */

return array(
    'ru' => array(

        'btn_title_Advertising'=> 'Рекламная аналитика',
        'btn_desc_Advertising'=> 'Google adwords, Yandex direct.',

        'btn_title_Broadcast'=> 'Трансляции',
        'btn_desc_Broadcast'=> 'Stream youtube, twitch.',

        'btn_title_ClearCache'=> 'Временные файлы',
        'btn_desc_ClearCache'=> 'Очистка кеша',

        'btn_title_ForumConnect'=> 'Форум',
        'btn_desc_ForumConnect'=> 'новости с форума',

        'btn_title_IBlock'=> 'Инфо блоки',
        'btn_desc_IBlock'=> 'слайдеры инфо блоки на сайте',

        'btn_title_LangEditor'=> 'Языки',
        'btn_desc_LangEditor'=> 'языковые настройки сайта',

        'btn_title_NewsSite'=> 'Новости',
        'btn_desc_NewsSite'=> 'управление новостями',

        'btn_title_ParsFileGame'=> 'Предметы',
        'btn_desc_ParsFileGame'=> 'для серверов (парсер)',

        'btn_title_ServerSettings'=> 'Серверы',
        'btn_desc_ServerSettings'=> 'информация о сервере на сайте',

        'btn_title_StaticPages'=> 'Страницы сайта',
        'btn_desc_StaticPages'=> 'статичные страницы',



        'title_lang' => 'Админ панель',

        //LangEditor
        'LangEditor_title' => 'Доступные шаблоны',
        'LangEditor_shop_btn' => 'Магазин шаблонов',
        'LangEditor_panel_btn' => 'Языки личного кабинета',
        'LangEditor_select' => 'Выбран',
        'LangEditor_not_found_lang' => 'Нет языковых пакетов',
        'LangEditor_edit_lang' => 'Открыть языковой пакет:',
        'LangEditor_btn_save' => 'Сохранить',
        'LangEditor_btn_reset' => 'Сбросить',
        'LangEditor_btn_add' => 'Добавить',
        'LangEditor_add_key_name' => 'Укажите желаемое название ключа',
        'LangEditor_add_key_low' => 'Ключ не может быть короче 4х символов. Пример: L_KEYNAME_1',
        'LangEditor_title_files' => 'Доступные файлы',
        //StaticPages
        'StaticPages_title' => 'Список статических страниц',
        'StaticPages_btn_add' => 'Создать страницу',
        'StaticPages_go_page' => 'Перейти',
        'StaticPages_edit_page' => 'Редактировать',
        'StaticPages_desc_input' => 'Описание <small>для админов</small>',
        'StaticPages_url_input' => 'URL Страницы',
        'StaticPages_url_desc' => 'Пример чтоб получить страницу /about указываем <code>about</code> или /about/server_x10 указываем <code>about/server_x10</code><br>
                                Примечание. url вы можете создать не более 2х уровней, например: "/about/server"',
        'StaticPages_show_input' => 'Доступна',
        'StaticPages_name_input' => 'Заголовок',
        'StaticPages_example_input' => 'Пример',
        'StaticPages_show_template' => 'Отрисовка страницы',
        'StaticPages_engine_tpl' => 'Обрабатывать контент страницы через шаблонизатор',
        'StaticPages_show_btn_site' => 'Сайт',
        'StaticPages_show_btn_cab' => 'Кабинет',
        'StaticPages_delete_news' => 'Удалить',
        'StaticPages_ajax_not_page' => 'Не передан идендификатор страницы',
        'StaticPages_ajax_not_url' => 'Не заполнено URL Страницы',
        'StaticPages_ajax_not_desc' => 'Не заполнено Описание для админов',
        'StaticPages_ajax_page_edit' => 'Страница успешно изменена',
        'StaticPages_ajax_page_already' => 'Такая страница уже существует',
        'StaticPages_ajax_not_dir' => 'Не создана директория: ',
        'StaticPages_ajax_page_add' => 'Страница успешно создана',


        //NewsSite
        'NewsSite_title' => 'Список новостей на сайте',
        'NewsSite_btn_add' => 'Добавить новость',
        'NewsSite_btn_delete_cache' => 'Очистить кеш',
        'NewsSite_th_title' => 'Заголовок',
        'NewsSite_th_public' => 'Опубликована',
        'NewsSite_th_fixed' => 'Закреплена',
        'NewsSite_in_author' => 'Автор',
        'NewsSite_in_date' => 'Дата',
        'NewsSite_in_date_desc' => 'Оставьте данное поле пустым, чтобы использовать текущую дату и время. Если установленная дата еще не наступила, новость будет опубликована автоматически, в указанное время.',
        'NewsSite_in_public' => 'Опубликовать новость на сайте',
        'NewsSite_in_fixed' => 'Зафиксировать новость',
        'NewsSite_ajax_add_news' => 'Новость успешно создана',
        'NewsSite_ajax_edit_news' => 'Новость успешно изменена',
        'NewsSite_ajax_not_id' => 'Не передан ид новости',

        //ForumConnect
        'ForumConnect_in_enable' => 'Состояние виджета',
        'ForumConnect_in_enable_desc' => 'В выключеном состоянии виджет в шаблон вернет пустую строку.',
        'ForumConnect_in_version' => 'Версия форума',
        'ForumConnect_in_url' => 'URL к апи',
        'ForumConnect_in_url_pa' => 'Полный URL к апи форума',
        'ForumConnect_in_url_desc' => 'Пример: <code>https://site.ru/forum/api-xenforo1.php</code> или <code>https://forum.site.ru/api-xenforo1.php</code>
                                    <br>Файлы API хранятся в <code>/Library</code> выбрав версию файл необходимо поместить в корень форума.',
        'ForumConnect_in_api' => 'API ключ',
        'ForumConnect_in_api_pa' => 'Секретный ключь к API форума',
        'ForumConnect_in_api_desc' => 'Пример: <code>JKBfir240ji</code> укажите рандомную строку для доступа к апи форума</code>
                                    <br>После чего этот ключ необходимо указать в файле форума, который будет размещен в корне форума.<br>Найти строку и указать свой ключ <code>public $api = \'JKBfir240ji\';</code>',
        'ForumConnect_in_count' => 'Кол-во сообщений',
        'ForumConnect_in_count_desc' => 'Укажите кол-во сообщений, которые будут получатся с форума',
        'ForumConnect_in_allow' => 'ID разделов разрешенных',
        'ForumConnect_in_allow_desc' => 'Укажите ID разделов из которых разрешено выводить темы. Пример: <code>1,2,3,4</code> указывать через запятую<br> Если поле оставить пустым, то выводить будет из всех разделов.',
        'ForumConnect_in_deny' => 'ID разделов запрещенных',
        'ForumConnect_in_deny_desc' => 'Укажите ID разделов, из которых запрещено выводить темы. Пример: <code>5,6,7,8</code> указывать через запятую',
        'ForumConnect_ajax_update' => 'Настройки успешно изменены',


        //ServerSettings
        'ServerSettings_enable' => 'Активен',
        'ServerSettings_disable' => 'Выключен',
        'ServerSettings_name' => 'Название',
        'ServerSettings_re_name' => 'Включить: подмену названия',
        'ServerSettings_rate' => 'Рейты',
        'ServerSettings_re_rate' => 'Включить: подмену рейтов',
        'ServerSettings_notice_tpl' => 'Если предусмотрено в шаблоне!',
        'ServerSettings_img' => 'Изображение',
        'ServerSettings_icon' => 'Иконка',
        'ServerSettings_icon_url' => 'Полный url к картинке',
        'ServerSettings_link' => 'Ссылка',
        'ServerSettings_chronicle' => 'Хроники',
        'ServerSettings_description' => 'Описание',
        'ServerSettings_info' => 'Настройки применимы только для сайта',
        'ServerSettings_date' => 'Дата',
        'ServerSettings_maxonline' => 'Max online (шкала)',
        'ServerSettings_online_s' => 'Статус сервера',
        'ServerSettings_online_sdesc' => 'Доступность',
        'ServerSettings_online_ls' => 'По логину',
        'ServerSettings_online_gs' => 'По гейм серверу',
        'ServerSettings_ajax_edit_success' => 'Настройки успешно изменены',

        'ServerSettings_hide_s' => 'Статус сервера',
        'ServerSettings_hide_sdesc' => 'Отображение сервера на сайте',
        'ServerSettings_hide_yes' => 'Виден',
        'ServerSettings_hide_no' => 'Скрыт',

        //IBlock
        'IBlock_title' => 'Инфо блоки',
        'IBlock_btn_add' => 'Добавить блок',
        'IBlock_btn_add_element' => 'Добавить элемент',
        'IBlock_in_public' => 'Опубликовать блок на сайте',
        'IBlock_in_name' => 'Название',
        'IBlock_btn_open_content' => 'Открыть блок',
        'IBlock_content_title' => 'Элементы блока',
        'IBlock_ajax_content_add_success' => 'Контент успешно добавлен',
        'IBlock_ajax_content_edit_success' => 'Контент успешно добавлен',
        'IBlock_ajax_create_success' => 'Блок успешно создан!',
        'IBlock_ajax_edit_success' => 'Блок успешно изменен',
        'IBlock_ajax_not_id' => 'Не передан ид блока',
        'IBlock_ajax_not_id_content' => 'Не передан ид контента',


        //Broadcast
        'Broadcast_title' => 'Список stream',
        'Broadcast_btn_add' => 'Добавить стрим',
        'Broadcast_btn_delete_cache' => 'Очистить кеш',
        'Broadcast_th_user' => 'Аккаунт',
        'Broadcast_th_publish' => 'Активность',
        'Broadcast_th_game' => 'Игра',
        'Broadcast_refresh_page' => 'Обновить',
        'Broadcast_delete_stream' => 'Удалить',
        'Broadcast_in_platform' => 'Площадка',
        'Broadcast_profile' => 'Профиль',
        'Broadcast_profile_desc' => 'Укажите имя аккаунта',
        'Broadcast_in_enable' => 'Активность',
        'Broadcast_in_enable_desc' => 'Отображать ли на сайте',
        'Broadcast_ajax_not_profile' => 'Не удалось определить тип трансляции',
        'Broadcast_ajax_add_stream' => 'Трансляция успешно добавлена',
        'Broadcast_ajax_error_add_stream' => 'Не удалось получить трансляцию!',
        'Broadcast_ajax_update_stream' => 'Трансляция обновлена',
        'Broadcast_ajax_update_status' => 'Статус обновлен',


        //Advertising
        'Advertising_title_gid' => 'ID для Google Analytics',
        'Advertising_title_gid_desc' => 'Вы можете ввести свой идентификатор веб-ресурса для <a href="https://www.google.com/analytics/" target="_blank">Google Analytics</a> в это поле. HTML-код для работы Google Analytics будет автоматически вставляться во все доступные страницы.',
        'Advertising_title_ganon' => 'Анонимизировать IP-адреса для Google Analytics',
        'Advertising_title_ganon_desc' => 'Если Google Analytics выше включён и Вы хотите анонимизировать IP-адреса для него, то включите данную опцию.',
        'Advertising_title_gt_manager' => 'Google Tag Manager',


        'Advertising_title_yam' => 'Яндекс.Метрика: Номер счётчика',
        'Advertising_title_yam_desc' => 'Вы можете ввести номер счётчика <a href="https://metrika.yandex.ru" target="_blank">Яндекс.Метрика</a> в поле выше. Код для работы Яндекс.Метрики будет автоматически вставляться во все доступные страницы.',
        'Advertising_title_yamwiz' => 'Яндекс.Метрика: Вебвизор, карта скроллинга, аналитика форм',
        'Advertising_title_yamwiz_desc' => 'Запись и анализ поведения посетителей сайта.',

        //ParsFileGame
        'ParsFileGame_title' => 'Управление базой данных предметов',
        'ParsFileGame_nav_title' => 'Навигация',
        'ParsFileGame_select_game_srv' => 'Выберите игровой сервер',
        'ParsFileGame_delete_db' => 'База успешно очищена!',
        'ParsFileGame_empty_server' => 'Серверов нет',
        'ParsFileGame_btn_item' => 'Предметов',
        'ParsFileGame_btn_item_no_icon' => 'Без иконок',
        'ParsFileGame_btn_del_bd_title' => 'Удалить',
        'ParsFileGame_btn_del_bd_desc' => 'Базу',
        'ParsFileGame_item_no_find' => 'Не найден',
        'ParsFileGame_item_find' => 'Найден',
        'ParsFileGame_img_dir' => 'Директория картинок',
        'ParsFileGame_files_format' => 'Формат файлов',
        'ParsFileGame_btn_pars' => 'Парсить файлы',



    ),
    'en' => array(

        'btn_title_Advertising'=> 'Advertising analytics',
        'btn_desc_Advertising'=> 'Google adwords, Yandex direct.',

        'btn_title_Broadcast'=> 'Broadcasts',
        'btn_desc_Broadcast'=> 'Stream youtube, twitch.',

        'btn_title_ClearCache'=> 'Temporary files',
        'btn_desc_ClearCache'=> 'Clearing the cache',

        'btn_title_ForumConnect'=> 'Forum',
        'btn_desc_ForumConnect'=> 'news from the forum',

        'btn_title_IBlock'=> 'Infoblocks',
        'btn_desc_IBlock'=> 'sliders info blocks on the site',

        'btn_title_LangEditor'=> 'Languages',
        'btn_desc_LangEditor'=> 'site language settings',

        'btn_title_NewsSite'=> 'News',
        'btn_desc_NewsSite'=> 'news management',

        'btn_title_ParsFileGame'=> 'Items',
        'btn_desc_ParsFileGame'=> 'for servers (parser)',

        'btn_title_ServerSettings'=> 'Servers',
        'btn_desc_ServerSettings'=> 'server information on the site',

        'btn_title_StaticPages'=> 'Site pages',
        'btn_desc_StaticPages'=> 'static pages',


        'title_lang' => 'Admin panel',
        //LangEditor
        'LangEditor_title' => 'Available templates',
        'LangEditor_shop_btn' => 'Shop of templates',
        'LangEditor_panel_btn' => 'All language files',
        'LangEditor_select' => 'Selected',
        'LangEditor_not_found_lang' => 'No language packages',
        'LangEditor_edit_lang' => 'Open language package:',
        'LangEditor_btn_save' => 'Save',
        'LangEditor_btn_reset' => 'Reset all current changes',
        'LangEditor_btn_add' => 'Add',
        'LangEditor_add_key_name' => 'Enter the desired key name',
        'LangEditor_add_key_low' => 'The key cannot be shorter, than 4 characters. For example: L_KEYNAME_1',
        'LangEditor_title_files' => 'Available files',
//StaticPages
        'StaticPages_title' => 'List of static pages',
        'StaticPages_btn_add' => 'Add page',
        'StaticPages_go_page' => 'Go to page',
        'StaticPages_edit_page' => 'Edit',
        'StaticPages_desc_input' => 'Description <small> for administrators </small>',
        'StaticPages_url_input' => 'Page URL',
        'StaticPages_url_desc' => 'Tutorial. To create "/about" url, please specify <code> of about </code>. To create "about/server_x10" url, please specify <code> of about/server_x10 </code> <br>
                                Warning! URL can be 2 level maximum. For instance: "/about/server" - correct url, but "about/server/project" - incorrect url ( because it has 3 levels )',
        'StaticPages_show_input' => 'Page is available',
        'StaticPages_name_input' => 'Page title',
        'StaticPages_example_input' => 'Example',
        'StaticPages_show_template' => 'Page template type',
        'StaticPages_engine_tpl' => 'Process page content through the template engine',
        'StaticPages_show_btn_site' => 'Website',
        'StaticPages_show_btn_cab' => 'Personal account',
        'StaticPages_delete_news' => 'Delete news',
        'StaticPages_ajax_not_page' => 'Page ID not specified (passed)',
        'StaticPages_ajax_not_url' => 'Page url is not specified',
        'StaticPages_ajax_not_desc' => 'Administrator\'s description is not specified',
        'StaticPages_ajax_page_edit' => 'The page is successfully changed',
        'StaticPages_ajax_page_already' => 'Page already exists',
        'StaticPages_ajax_not_dir' => 'Directory is not exists: ',
        'StaticPages_ajax_page_add' => 'The page is successfully created',


        //NewsSite
        'NewsSite_title' => 'List of news on the website',
        'NewsSite_btn_add' => 'Add news',
        'NewsSite_btn_delete_cache' => 'Clear cache',
        'NewsSite_th_title' => 'Title',
        'NewsSite_th_public' => 'Is published',
        'NewsSite_th_fixed' => 'Is pinned on page',
        'NewsSite_in_author' => 'Author',
        'NewsSite_in_date' => 'Public date',
        'NewsSite_in_date_desc' => 'Leave this field empty to set current date and time. If the determined date did not come yet, news will be published automatically, at the appointed time.',
        'NewsSite_in_public' => 'To publish news on the website',
        'NewsSite_in_fixed' => 'To pin news on page',
        'NewsSite_ajax_add_news' => 'News is successfully created',
        'NewsSite_ajax_edit_news' => 'News is successfully changed',
        'NewsSite_ajax_not_id' => 'News\'s ID hasn\'t been sent',

        //ForumConnect
        'ForumConnect_in_enable' => 'Widget state',
        'ForumConnect_in_enable_desc' => 'In the switched-off state a widget will return an empty line to a template.',
        'ForumConnect_in_version' => 'Forum\'s version',
        'ForumConnect_in_url' => 'URL to API (Application Programming Interface)',
        'ForumConnect_in_url_pa' => 'Absolute URL to forum\'s API',
        'ForumConnect_in_url_desc' => 'Example: <code>https://site.ru/forum/api-xenforo1.php</code> or <code>https://forum.site.ru/api-xenforo1.php</code>
                                    <br> API Files are stored in <code>/Library </code>. Choose necessary file version and place the file into a forum\'s root.',
        'ForumConnect_in_api' => 'API key',
        'ForumConnect_in_api_pa' => 'Secret key to a forum\'s API ',
        'ForumConnect_in_api_desc' => 'Example: <code>JKBfir240ji </code> specify a random sequence of characters to access the forum.
                                    <br> Then this key needs to be specified in the file of a forum which will be placed in a forum root. <br> Then you should find the line, specified above and define the key, like this <code>public $api = \'JKBfir240ji \'; </code>',
        'ForumConnect_in_count' => 'Number of messages',
        'ForumConnect_in_count_desc' => 'Specify messages count which will be will turn out from a forum',
        'ForumConnect_in_allow' => 'Specify sections ID\'s.',
        'ForumConnect_in_allow_desc' => 'Specify the identifiers (ID) of the sections from which articles will be not selected. No selected ID means to get articles from all sections. Example: <code> 1,2,3,4 </code> specify through a comma.',
        'ForumConnect_in_deny' => 'Specify forbidden sections ID\'s.',
        'ForumConnect_in_deny_desc' => 'Specify the identifiers (ID) of the sections from which articles will be not selected.. Example: <code> 5,6,7 </code> specify through a comma.',
        'ForumConnect_ajax_update' => 'Settings are successfully changed',


        //ServerSettings
        'ServerSettings_enable' => 'Enabled',
        'ServerSettings_disable' => 'Disabled',
        'ServerSettings_name' => 'Title',
        'ServerSettings_re_name' => 'Enable: substitution of the title',
        'ServerSettings_rate' => 'Rates',
        'ServerSettings_re_rate' => 'Enable: substitution of rates',
        'ServerSettings_notice_tpl' => 'If provided in the template!',
        'ServerSettings_img' => 'Image',
        'ServerSettings_icon' => 'Thumbnail image',
        'ServerSettings_icon_url' => 'Absolute URL to the picture',
        'ServerSettings_link' => 'Reference URL',
        'ServerSettings_chronicle' => 'Chronicles (editions)',
        'ServerSettings_description' => 'Description',
        'ServerSettings_info' => 'Settings are applicable only for the website',
        'ServerSettings_date' => 'Date',
        'ServerSettings_maxonline' => 'Max online (scale)',
        'ServerSettings_online_s' => 'Server status',
        'ServerSettings_online_sdesc' => 'Availability',
        'ServerSettings_online_ls' => 'By the login',
        'ServerSettings_online_gs' => 'By the game server',
        'ServerSettings_ajax_edit_success' => 'Settings are successfully changed',

        'ServerSettings_hide_s' => 'Server status site',
        'ServerSettings_hide_sdesc' => 'Displaying the server on the site',
        'ServerSettings_hide_yes' => 'Show',
        'ServerSettings_hide_no' => 'Hide',

        //IBlock
        'IBlock_title' => 'Info blocks',
        'IBlock_btn_add' => 'Add info block',
        'IBlock_btn_add_element' => 'Add element',
        'IBlock_in_public' => 'Publish block on the website',
        'IBlock_in_name' => 'Title',
        'IBlock_btn_open_content' => 'Open the block',
        'IBlock_content_title' => 'Block elements',
        'IBlock_ajax_content_add_success' => 'Content is successfully added',
        'IBlock_ajax_content_edit_success' => 'Content is successfully changed',
        'IBlock_ajax_create_success' => 'The block is successfully created!',
        'IBlock_ajax_edit_success' => 'The block is successfully changed',
        'IBlock_ajax_not_id' => 'Block ID hasn\'t been transferred',
        'IBlock_ajax_not_id_content' => 'Content ID hasn\'t been transferred',


        //Broadcast
        'Broadcast_title' => 'Stream List',
        'Broadcast_btn_add' => 'Add stream',
        'Broadcast_btn_delete_cache' => 'Clear cache',
        'Broadcast_th_user' => 'User account',
        'Broadcast_th_publish' => 'Activity',
        'Broadcast_th_game' => 'Game',
        'Broadcast_refresh_page' => 'Update page',
        'Broadcast_delete_stream' => 'Delete stream',
        'Broadcast_in_platform' => 'Platform',
        'Broadcast_profile' => 'Profile',
        'Broadcast_profile_desc' => 'Enter an account name',
        'Broadcast_in_enable' => 'Active',
        'Broadcast_in_enable_desc' => 'To display on the website',
        'Broadcast_ajax_not_profile' => 'Failed to determine broadcast type',
        'Broadcast_ajax_add_stream' => 'Broadcasting is successfully added',
        'Broadcast_ajax_error_add_stream' => 'Was not succeeded to receive broadcasting!',
        'Broadcast_ajax_update_stream' => 'Broadcasting is updated',
        'Broadcast_ajax_update_status' => 'Status updated',


        //Advertising
        'Advertising_title_gid' => 'Google Analytics ID',
        'Advertising_title_gid_desc' => 'You can enter the identifier of a web resource for <a href= "https://www.google.com/analytics/" target=" _ blank"> Google Analytics </a> into this field. The HTML for Google Analytics will automatically be inserted into all available pages.',
        'Advertising_title_ganon' => 'Anonymize IP Addresses for Google Analytics',
        'Advertising_title_ganon_desc' => 'If Google Analytics is enabled above and you want to anonymize the IP addresses for it, then enable this option.',
        'Advertising_title_gt_manager' => 'Google Tag Manager',
        'Advertising_title_yam' => 'Yandex. Metrics: counter ID',
        'Advertising_title_yam_desc' => 'You can enter number of the counter <a href= "https://metrika.yandex.ru" target=" _ blank"> Yandex. The metrics </a> is in the field above. The code for Yandex.Metrica will automatically be inserted into all available pages.',
        'Advertising_title_yamwiz' => 'Yandex.Metrica: Webvisor, scrolling map, form analytics',
        'Advertising_title_yamwiz_desc' => 'Record and analysis of behavior of visitors of the website.',


        //ParsFileGame
        'ParsFileGame_title' => 'Item Database Management',
        'ParsFileGame_nav_title' => 'Navigation',
        'ParsFileGame_select_game_srv' => 'Choose a game server',
        'ParsFileGame_delete_db' => 'The base has been cleared successfully!',
        'ParsFileGame_empty_server' => 'No servers',
        'ParsFileGame_btn_item' => 'Items',
        'ParsFileGame_btn_item_no_icon' => 'Without icons',
        'ParsFileGame_btn_del_bd_title' => 'Delete',
        'ParsFileGame_btn_del_bd_desc' => 'Base',
        'ParsFileGame_item_no_find' => 'Not found',
        'ParsFileGame_item_find' => 'Found',
        'ParsFileGame_img_dir' => 'Picture Directory',
        'ParsFileGame_files_format' => 'File format',
        'ParsFileGame_btn_pars' => 'Parse files',

    ),
);