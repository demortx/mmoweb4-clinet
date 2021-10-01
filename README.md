[MMOWEB](https://mmoweb.ru/) - CMS для mmorpg серверов (BOI, GTA SA)
==================================================
Как начать
---------------------------
Полная документация [RU](https://docs.mmoweb.biz/v/ru/) [EN](https://docs.mmoweb.biz/v/en/)

Установка
---------------------------
Подробная установка [RU](https://docs.mmoweb.biz/v/ru/nachalo-rabot/ustanovka-cms) * [EN](https://docs.mmoweb.biz/v/en/quick-start-guide/cms-setup)

1. Скачать [CMS](https://github.com/demort/mmoweb4-clinet/archive/master.zip)
2. Разархивировать в корень сайта
3. Ввести ключ в файле **Сonfig.php** на **7** строке параметр **API_KEY** (будет Ваш уникальный ключ найти его можно в панели mmoweb.biz на главной)
4. Настроить файл подключения к БД **Сonfig.php**
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
