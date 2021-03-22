<?php
/********************************
* Dev and Code by Demort
* Skype x88xax88x / email : demortx@gmail.com
* https://mmoweb.ru
* Config - Global
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
$lucky_wheel = array();
$lucky_wheel = array (
	88 => 
	array (
		'sid' => 88,
		'treatment' => 1,
		'price' => 10.0,
		'items'=>array(
			1 => 
			array (
				'id' => 57,
				'count' => 12,
				'enc' => 2,
				'name' => 'adena',
				'img' => 'img.jpg',
				'chance' => 45,
			),
			2 => 
			array (
				'id' => 17,
				'count' => 23,
				'enc' => 3,
				'name' => 'arrow',
				'img' => 'img.jpg',
				'chance' => 55,
			),
		),
	),
);
return $lucky_wheel;