<?php
/********************************
* Dev and Code by Demort
* Skype x88xax88x / email : demortx@gmail.com
* https://mmoweb.ru
* Config - Global
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
$system = array();
$system = array (
	'cabinet'=>array(
		'status_cabinet_jobs' => false,
		'status_cabinet_jobs_msg' => 'Sorry, we&#039;re currently unavailable. Please check back later. ',
		'ip_cabinet_exceptions' => '109.194.185.135,109.194.185.133,185.225.17.125,109.194.185.136',
		'page_active_no_auth'=>array(
			'rating' => true,
			'shop' => true,
			'donations' => true,
			'forum' => true,
		),
		'manager_ma' => true,
		'pin_shield' => true,
		'tab_active_log' => true,
		'max_game_accounts' => 9,
		'signin_type'=>array(
			'email' => true,
			'phone' => true,
		),
		'signin_social' => true,
		'signin_social_type'=>array(
			0 => 'google',
			1 => 'facebook',
			2 => 'vkontakte',
			3 => 'steam',
			4 => 'yandex',
			5 => 'mailru',
		),
		'registration_type'=>array(
			'email' => true,
			'phone' => true,
		),
		'registration_confirmation' => true,
		'registration_stop_temp_email' => false,
		'registration_login_prefix' => true,
		'registration_login_prefix_type' => 'PP_',
		'registration_login_prefix_count' => 6,
		'registration_login' => true,
		'registration_subscribe' => true,
		'reminder_type'=>array(
			'email' => true,
			'phone' => true,
		),
		'captcha' => false,
		'recaptcha_public_key' => '6Lc7_IMUAAAAANvbf2i4OsgKG_nndeh80eq5m071',
		'recaptcha_secret_key' => '6Lc7_IMUAAAAAPVIdOkoEYGMUAT3fJnAdsswFcQs',
	),
	'game'=>array(
		0 => 'lineage2',
		1 => 'boi',
	),
	'pid' => 1,
	'project'=>array(
		'name' => 'MmoWeb',
		'url_site' => 'https://mw4.mmoweb.ru/',
		'protocol_site' => 'https',
		'secret_key' => 'vSItF01ZW^s0z7HU(m5A',
		'server'=>array(
			'lineage2'=>array(
				0 => 9,
				1 => 8,
			),
			'boi'=>array(
				0 => 7,
			),
		),
		'server_sort'=>array(
			'lineage2'=>array(
				0 => 8,
				1 => 9,
			),
			'boi'=>array(
				0 => 7,
			),
		),
		'server_info'=>array(
			'lineage2'=>array(
				9 => 
				array (
					'name' => 'L2R Old',
					'status' => true,
					'game' => 'lineage2',
					'rate' => 1,
				),
				8 => 
				array (
					'name' => 'Gracia Final',
					'status' => true,
					'game' => 'lineage2',
					'rate' => 7,
				),
			),
			'boi'=>array(
				7 => 
				array (
					'name' => 'Gaia PvP',
					'status' => true,
					'game' => 'boi',
					'rate' => 15,
				),
			),
		),
		'server_options'=>array(
			9 => 
			array (
				'global_balance' => true,
			),
			8 => 
			array (
				'global_balance' => true,
			),
			7 => 
			array (
				'global_balance' => true,
			),
		),
		'server_plugins'=>array(
			9 => 
			array (
				'bonus_cod' => true,
				'warehouse' => true,
				'discount' => true,
			),
			8 => 
			array (
				'bonus_cod' => true,
				'warehouse' => true,
				'discount' => true,
			),
			7 => 
			array (
				'bonus_cod' => true,
				'warehouse' => true,
				'discount' => true,
			),
		),
		'server_menu'=>array(
			9 => 
			array (
				'rating' => true,
				'shop' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
			8 => 
			array (
				'rating' => true,
				'shop' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
			7 => 
			array (
				'rating' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
		),
	),
	'site'=>array(
		'status' => true,
		'status_site_jobs' => false,
		'status_site_jobs_msg' => 'Sorry, we&#039;re currently unavailable. Please check back later.',
		'ip_site_exceptions' => '109.194.185.134',
		'time_zone' => 'Europe/Moscow',
		'language_active' => 'ru',
		'language_list'=>array(
			'ru' => 'Russian',
			'en' => 'English',
		),
	),
	'settings' => 1,
	'visualization'=>array(
		'cabinet_layout_login' => 'left',
		'cabinet_layout_login_menu_fixed' => 'fixed',
		'cabinet_layout_login_color_menu' => 'white',
		'cabinet_layout_login_color' => 'default',
		'cabinet_layout_no_login' => 'top',
		'cabinet_layout_no_login_menu_fixed' => 'fixed',
		'cabinet_layout_no_login_color_menu' => 'white',
		'cabinet_layout_no_login_color' => 'default',
	),
	'payment_system'=>array(
		'long_name_valute' => 'Coin of Luck',
		'short_name_valute' => 'CoL',
		'price_valute_cp' => '0.1',
		'min_payment' => 5,
		'max_payment' => 10000,
		'rec_payment' => 50,
		'auto_course' => true,
		'course'=>array(
			'USD' => 1,
			'RUB' => '69.7795',
			'EUR' => '0.891421',
			'UAH' => '26.682161',
			'BTC' => '0.00011039648',
		),
		'unitpay' => true,
		'unitpay_project_id' => 182331,
		'unitpay_pay_type' => false,
		'unitpay_currency' => 'RUB',
		'nextpay' => true,
		'nextpay_product_id' => 10611,
		'freekassa' => true,
		'freekassa_merchant_id' => 60178,
		'paypal' => true,
		'paypal_currency' => 'EUR',
		'paygol' => true,
		'paygol_id' => 478236,
		'paygol_currency' => 'EUR',
		'g2a' => true,
		'g2a_currency' => 'EUR',
		'payop' => true,
		'payop_currency' => 'EUR',
		'payu' => true,
		'payu_site' => 'ro',
		'payu_currency' => 'EUR',
		'alikassa' => true,
		'alikassa_currency' => 'RUB',
	),
	'discount'=>array(
		'project'=>array(
			'data'=>array(
				1 => 
				array (
					'start' => 0,
					'end' => 600000,
					'percent' => 10,
				),
			),
			'game_valute' => 1,
			'shop' => 1,
		),
	),
	'event'=>array(
		8 => 
		array (
			0 => 
			array (
				'id' => 1,
				'title' => 'Первый евент тестовый',
				'data'=>array(
					1 => 
					array (
						'start' => 0,
						'end' => 99,
						'percent' => 0,
					),
					2 => 
					array (
						'start' => 100,
						'end' => 499,
						'percent' => 1,
					),
					3 => 
					array (
						'start' => 500,
						'end' => 999,
						'percent' => 3,
					),
					4 => 
					array (
						'start' => 1000,
						'end' => 2999,
						'percent' => 5,
					),
					5 => 
					array (
						'start' => 3000,
						'end' => 7499,
						'percent' => 7,
					),
					6 => 
					array (
						'start' => 7500,
						'end' => 10000000,
						'percent' => 10,
					),
				),
				'item_enable' => 1,
				'item'=>array(
					1 => 
					array (
						'lv' => 2,
						'id' => 5592,
						'count' => 50,
						'enc' => 0,
					),
					2 => 
					array (
						'lv' => 1,
						'id' => 5591,
						'count' => 50,
						'enc' => 0,
					),
					3 => 
					array (
						'lv' => 3,
						'id' => 1538,
						'count' => 3,
						'enc' => 0,
					),
					4 => 
					array (
						'lv' => 3,
						'id' => 3936,
						'count' => 1,
						'enc' => 0,
					),
				),
				'agrigator'=>array(
					0 => 'all',
				),
			),
		),
	),
	'in_game_currency'=>array(
		8 => 
		array (
			'config'=>array(
				'char' => true,
				'account' => true,
			),
			'settings'=>array(
				0 => 
				array (
					'id' => 1,
					'type' => 'char',
					'long_name' => 'Coin of Luck',
					'short_name' => 'Col',
					'icon' => 'https://mw4.mmoweb.ru/template/panel/assets/media/icon/8/etc_cp_potion_i00.png',
					'message' => 'Вы можете передать на персонажа Family Coin
Обратите внимание!
Вы можете приобрести все желаемые итемы напрямую в ЛК в разделах &quot;Магазин&quot; и &quot;Услуги&quot;, не переводя Family Coins в игру на персонажа!',
					'message_no_auth' => 'Вы можете передать на персонажа Family Coin
не авторизованный',
					'item_id' => 4037,
					'give_count' => 1,
					'price' => '1.000',
				),
				1 => 
				array (
					'id' => 2,
					'type' => 'account',
					'long_name' => 'Point',
					'short_name' => 'PB',
					'icon' => 'https://mw4.mmoweb.ru/template/panel/assets/media/avatars/avatar.png',
					'message' => 'Покупка поинтов в комюнити борд',
					'message_no_auth' => null,
					'item_id' => 0,
					'give_count' => 1,
					'price' => '12.001',
				),
			),
		),
	),
	'plugins'=>array(
		2 => 'stop_spam_email',
		3 => 'support',
		5 => 'manager_account',
		6 => 'bonus_cod',
	),
);
return $system;