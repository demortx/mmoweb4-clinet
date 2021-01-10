<?php
define( "ROOT_DIR", dirname( __FILE__ ) );
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);//

if (file_exists(ROOT_DIR.'/Files/blocked_install.txt'))
{
    exit('<h1>MmoWeb v4 Installation</h1><br>Installation is complete, remove "/Files/blocked_install.txt" file to re-install!');
}

$folder_list = array(
    'Config.php',
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
$php_module_list = array(
    'curl' => 'cURL',
    'json' => 'json',
    'pdo_mysql' => 'SimpleXML',
    'SimpleXML' => 'PDO MySql',
    'zip' => 'Zip',
);
$db_table_install = array(

    'mw_broadcast' => "CREATE TABLE `mw_broadcast` (
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
                          `date` datetime NOT NULL,
                          `publish` int(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `publish` (`publish`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
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
                                  `add_name` varchar(250) DEFAULT NULL,
                                  `description` varchar(1200) DEFAULT NULL,
                                  `icon` varchar(100) DEFAULT NULL,
                                  `icon_panel` varchar(100) DEFAULT NULL,
                                  `grade` varchar(3) DEFAULT NULL,
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

);
include ROOT_DIR.'/template/panel/install/index.php';