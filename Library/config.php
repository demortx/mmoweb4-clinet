<?php
/********************************
* Dev and Code by MmoWeb
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
		'pin_shield' => false,
		'pins_change_password_account' => true,
		'pins_forgot_password_account' => true,
		'pins_change_pwd_ma' => true,
		'pins_bind_telegram' => true,
		'pins_bind_email_send_code' => true,
		'pins_bind_phone_send_code' => true,
		'pins_delete_bind_phone' => true,
		'pins_manager_add' => false,
		'pins_market_sell_item' => true,
		'pins_market_buy_shop' => true,
		'pins_market_sell_char' => true,
		'pins_market_withdrawal' => true,
		'tab_active_log' => true,
		'tab_active_invoice' => true,
		'tab_active_invoice_detail' => true,
		'max_game_accounts' => 10,
		'delete_bind_phone' => true,
		'signin_type'=>array(
			'email' => true,
			'login' => true,
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
		'registration_login' => true,
		'registration_login_optional' => false,
		'registration_login_hide' => false,
		'registration_login_prefix' => true,
		'registration_login_prefix_type' => 'PP_',
		'registration_login_prefix_count' => 6,
		'registration_subscribe' => true,
		'reminder_type'=>array(
			'email' => true,
			'phone' => true,
		),
		'reminder_type_phone' => false,
		'reminder_type_ga' => false,
		'captcha' => 'recaptchav2',
		'recaptcha_public_key' => '6LeCmeoZAAAAANZaPVS-pdnIGTiWo9f7bWKa4QVg',
		'recaptcha_secret_key' => '6LeCmeoZAAAAAJPRRDUp4c2J1-DrIrA4gtl2pt-V',
	),
	'game'=>array(
		0 => 'lineage2',
		1 => 'aion',
		2 => 'boi',
	),
	'pid' => 1,
	'project'=>array(
		'name' => 'MmoWeb',
		'url_site' => 'https://mw4.mmoweb.ru/',
		'protocol_site' => 'https',
		'secret_key' => 'AAoQm7c2FtIeI8t3t52-',
		'server'=>array(
			'lineage2'=>array(
				0 => 88,
				1 => 9,
			),
			'aion'=>array(
				0 => 182,
			),
			'boi'=>array(
				0 => 7,
			),
		),
		'server_sort'=>array(
			'lineage2'=>array(
				0 => 9,
				1 => 88,
			),
			'aion'=>array(
				0 => 182,
			),
			'boi'=>array(
				0 => 7,
			),
		),
		'server_info'=>array(
			'lineage2'=>array(
				88 => 
				array (
					'name' => 'MasterWork',
					'status' => true,
					'game' => 'lineage2',
					'teleport_char' => false,
					'hwid_char' => false,
					'hwid_account' => false,
					'pin_char' => false,
					'pin_account' => false,
					'rate' => 1,
				),
				9 => 
				array (
					'name' => 'L2R Old',
					'status' => true,
					'game' => 'lineage2',
					'teleport_char' => true,
					'hwid_char' => true,
					'hwid_account' => true,
					'pin_char' => true,
					'pin_account' => true,
					'rate' => 1,
				),
			),
			'aion'=>array(
				182 => 
				array (
					'name' => 'Aion',
					'status' => true,
					'game' => 'aion',
					'teleport_char' => false,
					'hwid_char' => false,
					'hwid_account' => false,
					'pin_char' => false,
					'pin_account' => false,
					'rate' => 1,
				),
			),
			'boi'=>array(
				7 => 
				array (
					'name' => 'Gaia PvP',
					'status' => true,
					'game' => 'boi',
					'teleport_char' => false,
					'hwid_char' => false,
					'hwid_account' => false,
					'pin_char' => false,
					'pin_account' => false,
					'rate' => 15,
				),
			),
		),
		'server_options'=>array(
			88 => 
			array (
				'global_balance' => true,
			),
			9 => 
			array (
				'global_balance' => true,
			),
			182 => 
			array (
				'global_balance' => true,
			),
			7 => 
			array (
				'global_balance' => true,
			),
		),
		'server_plugins'=>array(
			88 => 
			array (
				'bonus_cod' => true,
				'warehouse' => true,
				'discount' => true,
				'balance' => true,
			),
			9 => 
			array (
				'bonus_cod' => true,
				'warehouse' => true,
				'discount' => true,
				'balance' => true,
			),
			182 => 
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
			88 => 
			array (
				'rating' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
			9 => 
			array (
				'rating' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
			182 => 
			array (
				'rating' => true,
				'support' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
			7 => 
			array (
				'rating' => true,
				'donations' => true,
				'settings' => true,
				'forum' => true,
				'site' => true,
			),
		),
		'launcher_app' => true,
		'launcher_key' => ')WV)kTDO*7',
	),
	'site'=>array(
		'url_website' => 'https://mw4.mmoweb.ru/',
		'url_forum' => 'https://forum.mmoweb.ru/',
		'status' => true,
		'status_site_jobs' => false,
		'status_site_jobs_msg' => 'Sorry, we&#039;re currently unavailable. Please check back later.',
		'ip_site_exceptions' => '109.194.185.134',
		'time_zone' => 'Europe/Moscow',
		'language_active' => 'ru',
		'language_list'=>array(
			'ru' => 'Russian',
			'en' => 'English',
			'gr' => 'Greek',
			'es' => 'Spanish',
			'pt' => 'Portuguese',
			'cn' => 'China',
			'ko' => 'Korean',
		),
	),
	'settings' => 1,
	'visualization'=>array(
		'cabinet_layout_login' => 'left',
		'cabinet_layout_login_menu_fixed' => 'default',
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
		'auto_course' => false,
		'course'=>array(
			'USD' => 1,
			'RUB' => '68.49',
			'EUR' => '0.885622',
			'UAH' => '26.591049',
			'BTC' => '0.000103393749',
		),
		'sorting_pay'=>array(
			0 => 'digiseller',
			1 => 'alikassa',
			2 => 'ips_payment',
			3 => 'payop',
			4 => 'payu',
			5 => 'freekassa',
			6 => 'g2a',
			7 => 'unitpay',
			8 => 'paypal',
			9 => 'nextpay',
			10 => 'paygol',
			11 => 'enot',
			12 => 'ipay',
			13 => 'paysafecard',
			14 => 'paymentwall',
			15 => 'qiwi',
		),
		'unitpay_project_id' => 182331,
		'unitpay_pay_type' => false,
		'unitpay_currency' => 'RUB',
		'nextpay' => true,
		'nextpay_product_id' => 10611,
		'freekassa' => true,
		'freekassa_merchant_id' => 60178,
		'freekassa_currency' => 'RUB',
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
		'enot' => true,
		'enot_id' => 5581,
		'enot_currency' => 'RUB',
		'ipay' => true,
		'ipay_currency' => 'GEL',
		'paysafecard' => true,
		'paysafecard_currency' => 'USD',
		'ips_payment' => true,
		'digiseller' => true,
		'paymentwall' => true,
		'qiwi' => false,
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
		9 => 
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
				'start' => '2019-11-11 13:46:00',
				'end' => '2024-06-14 12:00:00',
			),
		),
	),
	'in_game_currency'=>array(
		9 => 
		array (
			'config'=>array(
				'account' => true,
			),
			'settings'=>array(
				0 => 
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
		182 => 
		array (
			'config'=>array(
				'char' => true,
				'account' => true,
			),
			'settings'=>array(
				0 => 
				array (
					'id' => 184,
					'type' => 'char',
					'long_name' => 'Coin of Luck',
					'short_name' => 'CoL',
					'icon' => '/template/panel/assets/media/icon/6/etc_cp_potion_i00.png',
					'message' => null,
					'message_no_auth' => null,
					'item_id' => 188053399,
					'give_count' => 1,
					'price' => '1.000',
				),
				1 => 
				array (
					'id' => 185,
					'type' => 'account',
					'long_name' => 'Coin of Luck',
					'short_name' => 'CoL',
					'icon' => '/template/panel/assets/media/icon/6/etc_cp_potion_i00.png',
					'message' => null,
					'message_no_auth' => null,
					'item_id' => 0,
					'give_count' => 1,
					'price' => '1.000',
				),
			),
		),
	),
	'plugins'=>array(
		'__' => 'pl',
		2 => 'stop_spam_email',
		3 => 'support',
		5 => 'manager_account',
		6 => 'bonus_cod',
		7 => 'promo_game',
		8 => 'market',
		10 => 'lucky_wheel',
		12 => 'referral',
	),
	'promo_game'=>array(
		6 => 
		array (
			'id' => 6,
			'name' => 'Бонус при регистрации',
			'treatment' => 0,
			'sid' => 88,
			'pid' => 1,
			'items'=>array(
				1 => 
				array (
					'gr' => 1,
					'id' => 57,
					'count' => 100,
					'enc' => 0,
					'name' => 'Adena',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 15,
				),
				2 => 
				array (
					'gr' => 1,
					'id' => 57,
					'count' => 200,
					'enc' => 0,
					'name' => 'Adena',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 30,
				),
				3 => 
				array (
					'gr' => 1,
					'id' => 57,
					'count' => 300,
					'enc' => 0,
					'name' => 'Adena',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 55,
				),
				4 => 
				array (
					'gr' => 2,
					'id' => 4037,
					'count' => 1,
					'enc' => 0,
					'name' => 'CoL',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 25,
				),
				5 => 
				array (
					'gr' => 2,
					'id' => 4037,
					'count' => 100,
					'enc' => 0,
					'name' => 'CoL',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 45,
				),
				6 => 
				array (
					'gr' => 2,
					'id' => 4037,
					'count' => 1000,
					'enc' => 0,
					'name' => 'CoL',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 30,
				),
				7 => 
				array (
					'gr' => 3,
					'id' => 17,
					'count' => 135,
					'enc' => 0,
					'name' => 'Arrow',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 33,
				),
				8 => 
				array (
					'gr' => 3,
					'id' => 17,
					'count' => 543,
					'enc' => 0,
					'name' => 'Arrow',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 33,
				),
				9 => 
				array (
					'gr' => 3,
					'id' => 17,
					'count' => 678,
					'enc' => 0,
					'name' => 'Arrow',
					'img' => '/template/site/2/images/game/gift__item_full.png',
					'chance' => 34,
				),
			),
			'max' => 3,
		),
	),
	'referral'=>array(
		'status' => true,
		'sale' => true,
		'commission' => true,
	),
);
return $system;