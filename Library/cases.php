<?php
/********************************
* Dev and Code by Demort
* Skype x88xax88x / email : demortx@gmail.com
* https://mmoweb.ru
* Config - Global
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
$cases = array();
$cases = array (
	'category'=>array(
		88 => 
		array (
			1 => 
			array (
				'id' => 1,
				'name' => 'Новый кейсы',
				'lang'=>array(
					0 => 'ru',
					1 => 'en',
					2 => 'gr',
					3 => 'es',
					4 => 'pt',
				),
			),
			2 => 
			array (
				'id' => 2,
				'name' => 'Крутые куйсы',
				'lang'=>array(
					0 => 'ru',
					1 => 'en',
					2 => 'gr',
					3 => 'es',
					4 => 'pt',
				),
			),
		),
	),
	'sale'=>array(
		1 => 
		array (
			'id' => 1,
			'name' => 'Скидка на крутые куйсы',
			'start' => '2020-09-01 12:00:00',
			'end' => '2021-03-31 14:32:29',
			'sale' => 20,
			'timer' => 1,
			'step' => 12,
			'sale_ma' => true,
		),
	),
	'shop'=>array(
		88 => 
		array (
			1 => 
			array (
				'id' => 1,
				'type' => 'shop',
				'name' => 'тестовое название',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'category' => 1,
				'price' => 12,
				'items'=>array(
					0 => 
					array (
						'id' => 4037,
						'count' => 12,
						'enc' => 1,
						'img' => '/template/panel/assets/game/images/tmp/img-3.png',
						'name' => 'Coin Of Luck',
						'desc' => 'Описание колов',
						'chance' => 20,
						'key' => 91397,
					),
					1 => 
					array (
						'id' => 17,
						'count' => 12,
						'enc' => 0,
						'img' => '/template/panel/assets/game/images/tmp/img-2.png',
						'name' => 'Стрелы',
						'desc' => 'Описание стрел',
						'chance' => 40,
						'key' => 59895,
					),
					2 => 
					array (
						'id' => 57,
						'count' => 1000,
						'enc' => 0,
						'img' => '/template/panel/assets/game/images/tmp/img-1.png',
						'name' => 'Adena',
						'desc' => 'Описание адены',
						'chance' => 40,
						'key' => 47353,
					),
				),
				'broadcast' => 1,
				'sale_id' => 1,
				'start_enable' => 0,
				'start_sell' => null,
				'end_enable' => 0,
				'end_sell' => null,
				'sr_status' => 0,
				'sr_time' => 0,
				'sr_count' => 0,
				'ils_status' => 0,
				'ils_time' => 0,
				'ils_count' => 0,
			),
			2 => 
			array (
				'id' => 2,
				'type' => 'shop',
				'name' => 'тестовое два 2',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'category' => 2,
				'price' => 12,
				'items'=>array(
					0 => 
					array (
						'id' => 4037,
						'count' => 12,
						'enc' => 1,
						'img' => '/template/panel/assets/game/images/tmp/img-3.png',
						'name' => 'Coin Of Luck',
						'desc' => 'Описание колов',
						'chance' => 20,
						'key' => 91397,
					),
					1 => 
					array (
						'id' => 17,
						'count' => 12,
						'enc' => 0,
						'img' => '/template/panel/assets/game/images/tmp/img-2.png',
						'name' => 'Стрелы',
						'desc' => 'Описание стрел',
						'chance' => 40,
						'key' => 59895,
					),
					2 => 
					array (
						'id' => 57,
						'count' => 1000,
						'enc' => 0,
						'img' => '/template/panel/assets/game/images/tmp/img-1.png',
						'name' => 'Adena',
						'desc' => 'Описание адены',
						'chance' => 40,
						'key' => 47353,
					),
				),
				'broadcast' => 1,
				'sale_id' => 0,
				'start_enable' => 0,
				'start_sell' => null,
				'end_enable' => 0,
				'end_sell' => null,
				'sr_status' => 0,
				'sr_time' => 0,
				'sr_count' => 0,
				'ils_status' => 0,
				'ils_time' => 0,
				'ils_count' => 0,
			),
		),
	),
);
return $cases;