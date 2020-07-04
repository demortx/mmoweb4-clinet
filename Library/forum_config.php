<?php
/********************************
* Forum settings
* The config can be changed manually or in the admin panel
* Конфиг можно изменить вручную или в админ-панели
* /admin/forum
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
return array (
	'enable' => true,
	'version' => 'xenforo2',
	'url' => 'https://forum.mmoweb.ru/api-xenforo2.php',
	'api_key' => 'SCEGvre5yhb',
	'count' => 5,
	'allow'=>array(
		'ru' => 18,
		'en' => 22,
	),
	'deny'=>array(
		'ru' => null,
		'en' => null,
	),
);
