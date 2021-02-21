<?php
/********************************
* Dev and Code by Demort
* Skype x88xax88x / email : demortx@gmail.com
* https://mmoweb.ru
* Shop - Global
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
$shop = array();
$shop = array (
	'category'=>array(
		8 => 
		array (
			11 => 
			array (
				'id' => 11,
				'name' => 'Услуги',
				'lang'=>array(
					0 => 'ru',
					1 => 'en',
				),
			),
			9 => 
			array (
				'id' => 9,
				'name' => 'Main',
				'lang'=>array(
					0 => 'ru',
					1 => 'en',
				),
			),
			10 => 
			array (
				'id' => 10,
				'name' => 'Other',
				'lang'=>array(
					0 => 'hide',
				),
			),
		),
		9 => 
		array (
			39 => 
			array (
				'id' => 39,
				'name' => 'New category',
				'lang'=>array(
					0 => 'en',
				),
			),
			40 => 
			array (
				'id' => 40,
				'name' => 'New section',
				'lang'=>array(
					0 => 'en',
				),
			),
			5 => 
			array (
				'id' => 5,
				'name' => 'Премиум',
				'lang'=>array(
					0 => 'ru',
				),
			),
			1 => 
			array (
				'id' => 1,
				'name' => 'Главная',
				'lang'=>array(
					0 => 'ru',
					1 => 'en',
				),
			),
			7 => 
			array (
				'id' => 7,
				'name' => 'Телепортация',
				'lang'=>array(
					0 => 'hide',
				),
			),
			8 => 
			array (
				'id' => 8,
				'name' => 'Наборы',
				'lang'=>array(
					0 => 'hide',
				),
			),
			4 => 
			array (
				'id' => 4,
				'name' => 'Прокачка',
				'lang'=>array(
					0 => 'hide',
				),
			),
			6 => 
			array (
				'id' => 6,
				'name' => 'Услуги',
				'lang'=>array(
					0 => 'hide',
				),
			),
			2 => 
			array (
				'id' => 2,
				'name' => 'Припасы',
				'lang'=>array(
					0 => 'hide',
				),
			),
		),
	),
	'sale'=>array(
		5 => 
		array (
			'id' => 5,
			'name' => 'Happy new year Sale',
			'start' => '2020-04-01 14:30:39',
			'end' => '2020-04-30 14:30:41',
			'sale' => 12,
			'timer' => 0,
			'step' => 1212,
			'sale_ma' => true,
		),
		7 => 
		array (
			'id' => 7,
			'name' => 'Еще не началась',
			'start' => '2020-04-18 14:47:42',
			'end' => '2021-04-30 14:47:45',
			'sale' => 10,
			'timer' => 0,
			'step' => 1,
			'sale_ma' => false,
		),
		8 => 
		array (
			'id' => 8,
			'name' => 'offer_form',
			'start' => '2020-04-01 19:13:48',
			'end' => '2020-05-31 19:13:50',
			'sale' => 100,
			'timer' => 1,
			'step' => 0,
			'sale_ma' => true,
		),
		9 => 
		array (
			'id' => 9,
			'name' => 'Купи купон',
			'start' => '2020-04-01 22:50:58',
			'end' => '2020-12-31 22:51:00',
			'sale' => 12,
			'timer' => 1,
			'step' => 5,
			'sale_ma' => true,
		),
		11 => 
		array (
			'id' => 11,
			'name' => 'Таймер скидка',
			'start' => '2020-04-01 01:24:09',
			'end' => '2020-04-30 01:24:10',
			'sale' => 18,
			'timer' => 1,
			'step' => 2,
			'sale_ma' => true,
		),
	),
	'shop'=>array(
		9 => 
		array (
			5 => 
			array (
				'id' => 5,
				'type' => 'shop',
				'name' => 'Созданный товар',
				'img' => 'https://s8.hostingkartinok.com/uploads/images/2018/10/0280b93e6a262b8eac16babace42fff2.png',
				'html' => 'Club Card will allow you to:
<ul>
<li>Access to the Adventurers\' Guide Magic Assistance after 39th Level.</li>
<li>Extended Buffs Assortment after 47 Level and access to the Buff-Profiles.</li>
<li>Use Global Chat (symbol >).</li>
<li>Exclusive Teleports from Adventurers\' Guide.</li>
</ul>
<a href="https://l2e-global.com/forum/threads/club-card-adventurers-guide.197801" target="_blank">More details about Club and Adventurers Guide (clickable)</a>',
				'category' => 1,
				'price' => 1,
				'complect' => 0,
				'items'=>array(
					0 => 
					array (
						'id' => 57,
						'count' => 1,
						'enc' => 0,
						'price' => 123,
						'key' => 46289,
					),
					1 => 
					array (
						'id' => 4720,
						'count' => 10,
						'enc' => 0,
						'price' => 1,
						'key' => 26289,
					),
				),
				'broadcast' => 0,
				'sale_id' => 5,
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
			11 => 
			array (
				'id' => 11,
				'type' => 'l2_color_title',
				'name' => 'Цвет титула',
				'img' => 'https://true.gallery/image.php?di=V7L5.png',
				'html' => 'Valid characters when changing nickname: A-Z a-z 0-9
The allowable number of characters from 3 to 16.',
				'category' => 39,
				'price' => 123,
				'complect' => 1,
				'items'=>array(
					0 => 
					array (
						'color' => '#C12E63',
						'key' => 123123,
					),
					1 => 
					array (
						'color' => '#837C25',
						'key' => 234324,
					),
					2 => 
					array (
						'color' => '#F54260',
						'key' => 345346,
					),
					3 => 
					array (
						'color' => '#F58242',
						'key' => 36000,
					),
					4 => 
					array (
						'color' => '#9CF542',
						'key' => 245624,
					),
					5 => 
					array (
						'color' => '#033AB5',
						'key' => 635573,
					),
					6 => 
					array (
						'color' => '#42A5F5',
						'key' => 543745,
					),
				),
				'broadcast' => 0,
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
			32 => 
			array (
				'id' => 32,
				'type' => 'l2_character_unban',
				'name' => 'Разбан перса',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Разбан перса',
				'category' => 5,
				'price' => 1,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			4 => 
			array (
				'id' => 4,
				'type' => 'shop',
				'name' => 'Starter Set',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => '<br>
<br>
<ul>
<li>Возможность использовать: <b>Premium Buffer</b>.
<li>Доступ в глобальный межфракционный чат. <i>(Доступно 1 сообщение раз в 2 минуты)</i>
<li>Возможность использовать трансформации Пирата и Ассасина. <i>(Без использования Elemental Stone)</i>
<li>Бесплатный вход в инстанс зону Labyrinth of Abyss . <i>(Без использования Elemental Stone)</i>
<li>Свиток для снятия временного штрафа на вход в инстанс зону Labyrinth of Abyss (1 шт.) <i>(идет в подарок к Averia Club Card)</i>
<li>Коробка с руной опыта <b>(5 часов)</b> <i>(идет в подарок к Averia Club Card)</i>
</ul>
<br>
<hr>
<br>
<ul>
<li> Access to use: <b> Premium Buffer </b>.
<li> Access to the global chat. <i> (Available 1 reply every 2 minutes) </i>
<li> The opportunity to use the transformations of Pirate and Assassin. <i> (Without Elemental Stone) </i>
<li> Free entrance to the Labyrinth of Abyss instance. <i> (Without Elemental Stone) </i>
<li> A scroll to withdraw the temporary penalty for entering the instance of the Labyrinth of Abyss (1 pc.) <i> (comes as a gift to the Averia Club Card) </i>
<li> A box with a rune of experience <b> (5 hours) </b> <i> (comes as a gift to the Averia Club Card) </i>
</ ul>
<br>
<br>
<a href="https://board.averia.ws/threads/igrovoj-magazin-servera-gve-2-5.175966/post-2368150" target="_blank"><u>Полный список товаров с описанием на форуме</u></a>',
				'category' => 1,
				'price' => 100,
				'complect' => 1,
				'items'=>array(
					0 => 
					array (
						'id' => 75200,
						'count' => 1,
						'enc' => 0,
						'key' => 11986,
					),
					1 => 
					array (
						'id' => 76008,
						'count' => 1,
						'enc' => 0,
						'key' => 21986,
					),
					2 => 
					array (
						'id' => 76015,
						'count' => 1,
						'enc' => 0,
						'key' => 31986,
					),
				),
				'broadcast' => 0,
				'sale_id' => 7,
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
			31 => 
			array (
				'id' => 31,
				'type' => 'l2_account_unban',
				'name' => 'Разбан аккаунта',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Разбан аккаунта',
				'category' => 5,
				'price' => 1,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			1 => 
			array (
				'id' => 1,
				'type' => 'shop',
				'name' => 'Talisman of Insolence Lv.4',
				'img' => 'https://true.gallery/image.php?di=68IO.png',
				'html' => '<br>
<br>
<ul>
<li>Возможность использовать: <b>Premium Buffer</b>.
<li>Доступ в глобальный межфракционный чат. <i>(Доступно 1 сообщение раз в 2 минуты)</i>
<li>Возможность использовать трансформации Пирата и Ассасина. <i>(Без использования Elemental Stone)</i>
<li>Бесплатный вход в инстанс зону Labyrinth of Abyss . <i>(Без использования Elemental Stone)</i>
<li>Свиток для снятия временного штрафа на вход в инстанс зону Labyrinth of Abyss (1 шт.) <i>(идет в подарок к Averia Club Card)</i>
<li>Коробка с руной опыта <b>(5 часов)</b> <i>(идет в подарок к Averia Club Card)</i>
</ul>
<br>
<hr>
<br>
<ul>
<li> Access to use: <b> Premium Buffer </b>.
<li> Access to the global chat. <i> (Available 1 reply every 2 minutes) </i>
<li> The opportunity to use the transformations of Pirate and Assassin. <i> (Without Elemental Stone) </i>
<li> Free entrance to the Labyrinth of Abyss instance. <i> (Without Elemental Stone) </i>
<li> A scroll to withdraw the temporary penalty for entering the instance of the Labyrinth of Abyss (1 pc.) <i> (comes as a gift to the Averia Club Card) </i>
<li> A box with a rune of experience <b> (5 hours) </b> <i> (comes as a gift to the Averia Club Card) </i>
</ ul>
<br>
<br>
<a href="https://board.averia.ws/threads/igrovoj-magazin-servera-gve-2-5.175966/post-2368150" target="_blank"><u>Полный список товаров с описанием на форуме</u></a>',
				'category' => 1,
				'price' => 195,
				'complect' => 1,
				'items'=>array(
					0 => 
					array (
						'id' => 75200,
						'count' => 1,
						'enc' => 0,
						'key' => 35623,
					),
					1 => 
					array (
						'id' => 76008,
						'count' => 1,
						'enc' => 0,
						'key' => 60673,
					),
					2 => 
					array (
						'id' => 76015,
						'count' => 1,
						'enc' => 0,
						'key' => 60623,
					),
				),
				'broadcast' => 0,
				'sale_id' => 8,
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
			17 => 
			array (
				'id' => 17,
				'type' => 'l2_clan_name_change',
				'name' => 'Смена имени клана',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Смена имени клана',
				'category' => 5,
				'price' => 22,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			6 => 
			array (
				'id' => 6,
				'type' => 'shop',
				'name' => 'Тест фулл',
				'img' => 'https://forum.mmoweb.ru/data/avatars/m/0/1.jpg?1584612926',
				'html' => 'Описание, вожможна встака html js
',
				'category' => 1,
				'price' => 15,
				'complect' => 0,
				'items'=>array(
					0 => 
					array (
						'id' => 57,
						'count' => 1000,
						'enc' => 0,
						'price' => 15,
						'apiece' => 1,
						'key' => 51182,
					),
					1 => 
					array (
						'id' => 4037,
						'count' => 1,
						'enc' => 0,
						'price' => 22,
						'apiece' => 1,
						'key' => 61182,
					),
				),
				'broadcast' => 0,
				'sale_id' => 9,
				'start_enable' => 1,
				'start_sell' => '2020-04-15 02:08:59',
				'end_enable' => 1,
				'end_sell' => '2021-07-16 02:09:02',
				'sr_status' => 1,
				'sr_time' => 12,
				'sr_count' => 21,
				'ils_status' => 1,
				'ils_time' => 21,
				'ils_count' => 12,
			),
			14 => 
			array (
				'id' => 14,
				'type' => 'l2_pk_clear',
				'name' => 'Очистка ПК счета персонажа',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'category' => 5,
				'price' => 32,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			19 => 
			array (
				'id' => 19,
				'type' => 'l2_char_transfer',
				'name' => 'Перенос персонажа',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Перенос персонажа',
				'category' => 5,
				'price' => 77,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			12 => 
			array (
				'id' => 12,
				'type' => 'l2_premium',
				'name' => 'Премиум',
				'img' => 'https://true.gallery/image.php?di=J79P.png',
				'html' => '+ 25% к EXP (Vitality не опускается ниже 125%)
+ 50% к SP и Fame
+ 25% к кол-ву Adena и Seal Stones
+ 35% к шансу Drop и Spoil
+ 1 к Лимиту Окон за каждое запущенное окно с ПА
+ Возможность ежедневно посещать Rim Pailaka
Доступ к VIP системе - "прокачке" Вашего ПА:
- до +40% к кол-ву Adena и Seal Stone
- до +50% к шансу Drop и Spoil
- уменьшение потери опыта до 30%
- уникальная кастомизация персонажа
Бонусы действуют для всех Персонажей на Игровом Аккаунте (но не на Мастер Аккаунте)
Подробное описание сервера Interlude Rework',
				'category' => 5,
				'price' => 30,
				'complect' => 0,
				'items'=>array(
					0 => 
					array (
						'name' => 'Премиум Аккаунта',
						'visual_day' => 30,
						'sec' => 1111111,
						'price' => 30,
						'key' => 42345,
					),
					1 => 
					array (
						'name' => 'Премиум Аккаунта ',
						'visual_day' => 1000,
						'sec' => 2222222,
						'price' => 130,
						'key' => 16477,
					),
				),
				'broadcast' => 1,
				'sale_id' => 11,
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
			15 => 
			array (
				'id' => 15,
				'type' => 'l2_name_change_spec',
				'name' => 'Смена ника персонажа с спец символами',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Смена ника персонажа с спец символами',
				'category' => 5,
				'price' => 43,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			18 => 
			array (
				'id' => 18,
				'type' => 'l2_change_gender',
				'name' => 'Смена пола персонажа',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'Смена пола персонажа',
				'category' => 5,
				'price' => 55,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
			13 => 
			array (
				'id' => 13,
				'type' => 'l2_karma_clear',
				'name' => 'Очистка кармы персонажа',
				'img' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'html' => 'https://true.gallery/image.php?dm=ZXI9.png',
				'category' => 5,
				'price' => 12,
				'complect' => 1,
				'items'=>array(
					0 => 'empty',
				),
				'broadcast' => 0,
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
return $shop;