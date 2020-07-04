[MMOWEB](https://mmoweb.ru/) - CMS для mmorpg серверов (L2, BOI)
==================================================
Как начать
---------------------------
Полная документация [RU](https://docs.mmoweb.ru/v/ru/) [EN](https://docs.mmoweb.ru/v/en/)

Установка
---------------------------

Подробная установка [RU](https://docs.mmoweb.ru/v/ru/nachalo-rabot/ustanovka-cms) [EN](https://docs.mmoweb.ru/v/en/quick-start-guide/cms-setup)

1. Скачать [CMS](https://github.com/demortx/mmoweb4-clinet/archive/master.zip)
2. Разархивировать в корень сайта
3. Ввести ключ в файле **Сonfig.php** на **7** строке параметр **API_KEY** (будет Ваш уникальный ключ найти его можно в панели mmoweb.ru на главной)
        /**
		* Это главный ключ группы он хранится в админ панеле
		* This is the main key of the group it is stored in the admin panel.
		*/
		define('API_KEY',       "q08YmsGbX0lC)54U7ZJ1");
4. Настроить файл подключения к БД **Сonfig.php**
		/**
		* Тут настраивается подключение к базе хостинга
		* This is where the connection to the hosting database is configured.
		*/
		define('DB_HOST',       'localhost');
		define('DB_NAME',       'mw4BSp');
		define('DB_USER',       'u_mw4BSp');
		define('DB_PASSWORD',   'fSf8D2UT');
5. Запустить **install.php** (находится в корне сайта) после чего удалить или переименовать


### Доступ в Админку:
- Нужно авторизироваться **/admin**:
- Логин: **admin**
- Пароль: **admin**

Настройки доступа в админ панель необходимо изменить в файле **Config.php**

	/**
	* Доступ в панель управления базой данных предметов
	* Access to the item database control panel
	*/
	define('ADMIN_PANEL',       true);
	define('ADMIN_LOGIN',       'admin');
	define('ADMIN_PASSWORD',    'admin');
	define('ADMIN_IP',          '*'); //All ip: *

