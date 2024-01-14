<?php
define( "ROOT_DIR", dirname( __FILE__ ) );
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);//

if (file_exists(ROOT_DIR.'/Files/blocked_install.txt'))
{
    exit('<h1>MmoWeb v4 Installation</h1><br>Installation is complete, remove "/Files/blocked_install.txt" file to re-install!');
}
require_once ROOT_DIR.'/Config.php';

$folder_list = array(
    'Config.php',
    'cache',
    'cache/crest',
    'cache/Pages',
    'Debug',
    'Files',
    'Files/backup',
    'Library/advertising.php',
    'Library/config.php',
    'Library/forum_config.php',
    'Library/server_config.php',
    'Library/shop.php',
    'Library/cases.php',
    'Library/lucky_wheel.php',
    'Library/daily_rewards.php',
    'template/compiled',
);
$php_module_list = array(
    'curl' => 'cURL',
    'json' => 'json',
    'pdo_mysql' => 'PDO MySql',
    'SimpleXML' => 'SimpleXML',
    'zip' => 'Zip',
);
$db_table_install = array(

    'mw_broadcast' => "CREATE TABLE `mw_broadcast` (
                      `id` INT(10) NOT NULL AUTO_INCREMENT,
                      `stream` VARCHAR(2500) NOT NULL,
                      `platform` VARCHAR(32) NOT NULL,
                      `name` VARCHAR(150) NOT NULL,
                      `title` VARCHAR(255) NOT NULL,
                      `avatar` VARCHAR(250) NOT NULL,
                      `preview` VARCHAR(150) NOT NULL,
                      `autoplay` TINYINT(1) NOT NULL DEFAULT '0',
                      `mute` TINYINT(1) NOT NULL DEFAULT '1',
                      `date` DATETIME NOT NULL,
                      `position` INT(10) NOT NULL DEFAULT '0',
                      `publish` INT(10) NOT NULL DEFAULT '1',
                      PRIMARY KEY (`id`) USING BTREE,
                      INDEX `publish` (`publish`) USING BTREE
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    'mw_iblock' => "CREATE TABLE `mw_iblock` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(100) NOT NULL,
                          `tpl` varchar(100) NOT NULL,
                          `ikey` varchar(100) NOT NULL,
                          `date` datetime NOT NULL,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          `json` mediumtext NOT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE KEY `ikey_2` (`ikey`),
                          KEY `publish` (`publish`),
                          KEY `ikey` (`ikey`),
                          KEY `name` (`name`) USING BTREE
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    'mw_iblock_content' => "CREATE TABLE `mw_iblock_content` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `ikey` varchar(100) NOT NULL,
                          `json` mediumtext NOT NULL,
                          `date` datetime NOT NULL,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`),
                          KEY `ikey` (`ikey`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    'mw_item_db' => "CREATE TABLE `mw_item_db` (
                                  `id` int(11) NOT NULL,
                                  `item_id` bigint(20) NOT NULL,
                                  `name` varchar(250) DEFAULT NULL,
                                  `name_obj` varchar(60) DEFAULT NULL,
                                  `add_name` varchar(250) DEFAULT NULL,
                                  `description` varchar(1200) DEFAULT NULL,
                                  `icon` varchar(100) DEFAULT NULL,
                                  `icon_panel` varchar(100) DEFAULT NULL,
                                  `grade` varchar(15) DEFAULT NULL,
                                  `type` varchar(10) DEFAULT NULL,
                                  `stackable` int(1) NOT NULL DEFAULT '0',
                                  `sid` int(11) NOT NULL DEFAULT '0'
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_item_db`
                                  ADD PRIMARY KEY (`id`),
                                  ADD KEY `item_id` (`item_id`),
                                  ADD KEY `sid` (`sid`);
                                
                                ALTER TABLE `mw_item_db`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",
    'mw_news' => "CREATE TABLE `mw_news` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `json` mediumtext NOT NULL,
                          `date` datetime NOT NULL,
                          `author` varchar(100) NOT NULL,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          `fixed` int(1) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`),
                          KEY `fixed` (`fixed`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    'mw_session' => "CREATE TABLE `mw_session` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `session_id` varchar(150) NOT NULL DEFAULT '',
                          `data` mediumtext,
                          `ip` varchar(45) DEFAULT NULL,
                          `session_end` datetime NOT NULL,
                          PRIMARY KEY (`id`,`session_end`,`session_id`),
                          KEY `session_end` (`session_end`),
                          KEY `session_id` (`session_id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    'mw_stop_spam' => "CREATE TABLE `mw_stop_spam` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `ip` varchar(45) DEFAULT NULL,
                          `date` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                        ALTER TABLE `mw_stop_spam` ADD INDEX(`ip`);",
    'mw_market_shop' => "CREATE TABLE `mw_market_shop` (
                      `id` int(11) NOT NULL COMMENT 'ID Магазина',
                      `mid` int(11) NOT NULL COMMENT 'ID мастер аккаунта',
                      `section` varchar(15) NOT NULL COMMENT 'Раздел лавки',
                      `type` tinyint(1) NOT NULL COMMENT 'Тип магазина 1 - оптом, 2 - розница, 3 - продажа персонажа',
                      `count` int(2) NOT NULL COMMENT 'Кол-во предметов в магазине',
                      `data_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
                      `sid` int(11) NOT NULL COMMENT 'ID сервера'
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    
                    ALTER TABLE `mw_market_shop`
                      ADD KEY (`id`),
                      ADD KEY `sid` (`sid`),
                      ADD KEY `mid` (`mid`);
                      
                    ALTER TABLE `mw_market_shop`
                      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Магазина';
                    COMMIT;",
    'mw_market_shop_items' => "CREATE TABLE `mw_market_shop_items` (
                      `id` int(11) NOT NULL,
                      `shop_id` int(11) NOT NULL COMMENT 'Ид магазина',
                      `char_info` text NOT NULL COMMENT 'Информация о персонаже',
                      `char_inventory` mediumtext NOT NULL COMMENT 'Информация об инвентаре персонажа',
                      `price` decimal(12,6) NOT NULL COMMENT 'Цена за товар или еденицу товара',
                      `item_id` int(11) NOT NULL COMMENT 'ид предмета',
                      `count` BIGINT(20) NOT NULL COMMENT 'количество предметов',
                      `enc` int(11) NOT NULL DEFAULT '0' COMMENT 'Улучшение предмета',
                      `aug_1` int(11) NOT NULL DEFAULT '0' COMMENT 'Аугоментация предмета',
                      `aug_2` int(11) NOT NULL DEFAULT '0' COMMENT 'Аугоментация предмета',
                      `a_att_type` int(11) NOT NULL DEFAULT '-2' COMMENT 'Тип атрибута',
                      `a_att_value` int(11) NOT NULL DEFAULT '0' COMMENT 'Значение атрибута',
                      `d_att_0` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
                      `d_att_1` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
                      `d_att_2` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
                      `d_att_3` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
                      `d_att_4` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
                      `d_att_5` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия'
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                    
                    ALTER TABLE `mw_market_shop_items`
                      ADD KEY (`id`),
                      ADD KEY `shop_id` (`shop_id`);
                    
                    ALTER TABLE `mw_market_shop_items`
                      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                    COMMIT;",

);
include ROOT_DIR.'/template/panel/install/index.php';

