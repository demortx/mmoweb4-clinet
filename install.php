<?php
define( "ROOT_DIR", dirname( __FILE__ ) );
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);//

$folder_list = array(
    'cache',
    'cache/crest',
    'cache/Pages',
    'Debug',
    'Files',
    'Library/advertising.php',
    'Library/config.php',
    'Library/forum_config.php',
    'Library/server_config.php',
    'Library/shop.php',
    'template/compiled',
);

foreach ($folder_list as $file){
    if(decoct(fileperms($file) & 0777) != 777)
        echo 'Изменить права с ' .decoct(fileperms($file) & 0777) . ' на 777 -> '. $file . '<br>';

}

$missing_modules = array();
$php_modules = get_loaded_extensions();

if (! in_array('curl', $php_modules) ) {
    $missing_modules[] = 'curl';
}
if (! in_array('json', $php_modules) ) {
    $missing_modules[] = 'Json';
}
if (! in_array('pdo_mysql', $php_modules) ) {
    $missing_modules[] = 'PDO MySql';
}


foreach ($missing_modules as $miss_lib) {
    echo 'Необходима библиотека - ' . $miss_lib . '<br>';
}


$system = require_once ROOT_DIR.'/Config.php';
try {
    $DB = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $con_true = true;
} catch (PDOException $e) {
    echo 'Нет конекта к базе сайта <br>';
    echo $e->getMessage();
    $con_true = false;
}
if($con_true){
	echo 'Create table: mw_broadcast<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_broadcast`;
                        CREATE TABLE IF NOT EXISTS `mw_broadcast` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `chanel` varchar(150) NOT NULL,
                          `name` varchar(150) NOT NULL,
                          `user_id` varchar(50) NOT NULL,
                          `logo` varchar(250) NOT NULL,
                          `type` varchar(15) NOT NULL,
                          `game` varchar(40) NOT NULL,
                          `online` int(1) NOT NULL DEFAULT '0',
                          `preview` varchar(150) NOT NULL,
                          `json` mediumtext NOT NULL,
                          `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

	echo 'Create table: mw_iblock<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_iblock`;
                        CREATE TABLE IF NOT EXISTS `mw_iblock` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(100) NOT NULL,
                          `tpl` varchar(100) NOT NULL,
                          `ikey` varchar(100) NOT NULL,
                          `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `ikey_2` (`ikey`),
                          KEY `publish` (`publish`),
                          KEY `ikey` (`ikey`),
                          KEY `name` (`name`) USING BTREE
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	echo 'Create table: mw_iblock_content<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_iblock_content`;
                        CREATE TABLE IF NOT EXISTS `mw_iblock_content` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `ikey` varchar(100) NOT NULL,
                          `json` mediumtext NOT NULL,
                          `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`),
                          KEY `ikey` (`ikey`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	echo 'Create table: mw_item_db<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_item_db`;
                        CREATE TABLE IF NOT EXISTS `mw_item_db` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `item_id` bigint(20) NOT NULL,
                          `name` varchar(250) DEFAULT NULL,
                          `add_name` varchar(250) DEFAULT NULL,
                          `description` varchar(1200) DEFAULT NULL,
                          `icon` varchar(100) DEFAULT NULL,
                          `sid` int(11) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`id`),
                          KEY `sid` (`sid`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	echo 'Create table: mw_news<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_news`;
                        CREATE TABLE IF NOT EXISTS `mw_news` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `json` mediumtext NOT NULL,
                          `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `author` varchar(100) NOT NULL,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          `fixed` int(1) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`),
                          KEY `fixed` (`fixed`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	echo 'Create table: mw_session<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_session`;
                        CREATE TABLE IF NOT EXISTS `mw_session` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `session_id` varchar(150) NOT NULL DEFAULT '',
                          `data` mediumtext,
                          `ip` varchar(16) DEFAULT NULL,
                          `session_end` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`id`,`session_end`,`session_id`),
                          KEY `session_end` (`session_end`),
                          KEY `session_id` (`session_id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	echo 'Create table: mw_stop_spam<br>';
    $DB->query("DROP TABLE IF EXISTS `mw_stop_spam`;
                        CREATE TABLE IF NOT EXISTS `mw_stop_spam` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `ip` varchar(250) DEFAULT NULL,
                          `date` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                        ALTER TABLE `mw_stop_spam` ADD INDEX(`ip`);");
	echo 'MmoWeb installation completed!';
}
