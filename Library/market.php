<?php
/********************************
* Dev and Code by Demort
* Skype x88xax88x / email : demortx@gmail.com
* https://mmoweb.ru
* Market - Lineage
 ********************************/
defined('ROOT_DIR') OR exit('No direct script access allowed');
$market = array();
$market = array (
	88 => 
	array (
		'status' => true,
		'section'=>array(
			0 => 'armor',
			1 => 'weapon',
			2 => 'jewelry',
			3 => 'consumables',
			4 => 'coin',
			5 => 'character',
			6 => 'etc',
		),
		'bl_status' => false,
		'bl_config'=>array(
			1 => 
			array (
				'lv' => null,
				'max_item' => 2,
				'max_shop' => 2,
				'range_sales' => 0,
				'commision' => 35,
			),
			2 => 
			array (
				'lv' => 2,
				'max_item' => 3,
				'max_shop' => 3,
				'range_sales' => 122,
				'commision' => 30,
			),
			3 => 
			array (
				'lv' => 3,
				'max_item' => 5,
				'max_shop' => 5,
				'range_sales' => 222,
				'commision' => 25,
			),
		),
		'moderation' => false,
		'options'=>array(
			0 => 'augmentation',
			1 => 'attributes',
			2 => 'stackable',
		),
		'grade'=>array(
			0 => 'none',
			1 => 'd',
			2 => 'c',
			3 => 'b',
			4 => 'a',
			5 => 's',
			6 => 's80',
			7 => 's84',
			8 => 's85',
			9 => 's90',
			10 => 's95',
			11 => 's99',
			12 => 'R',
			13 => 'r95',
			14 => 'r99',
		),
		'type'=>array(
			0 => 'armor',
			1 => 'weapon',
			2 => 'shield',
			3 => 'accessary',
			4 => 'questitem',
			5 => 'none',
			6 => 'etcitem',
		),
		'items_prohibited' => '4037,43',
		'items_allowed' => '57,54',
		'price'=>array(
			1 => 
			array (
				'id' => 57,
				'min' => '0.1',
				'max' => '22.3',
				'step' => 1000,
				'note' => 'Adena',
			),
			2 => 
			array (
				'id' => 5789,
				'min' => '0.1',
				'max' => '2.2',
				'step' => 10,
				'note' => 'Соски',
			),
		),
	),
	9 => 
	array (
		'status' => false,
		'bl_status' => false,
		'bl_config'=>array(
			1 => 
			array (
				'lv' => null,
				'max_item' => null,
				'max_shop' => null,
				'range_sales' => null,
				'commision' => null,
			),
		),
		'moderation' => false,
		'options'=>array(
			0 => 'augmentation',
			1 => 'attributes',
			2 => 'stackable',
		),
		'grade'=>array(
			0 => 'none',
			1 => 'd',
			2 => 'c',
			3 => 'b',
			4 => 's',
			5 => 's80',
			6 => 's84',
			7 => 's85',
			8 => 's90',
			9 => 's95',
			10 => 's99',
			11 => 'R',
			12 => 'r95',
			13 => 'r99',
		),
		'type'=>array(
			0 => 'armor',
			1 => 'weapon',
			2 => 'shield',
			3 => 'accessary',
			4 => 'questitem',
			5 => 'none',
			6 => 'etcitem',
		),
		'items_prohibited' => null,
		'items_allowed' => null,
		'price'=>array(
			1 => 
			array (
				'id' => null,
				'min' => null,
				'max' => null,
				'step' => null,
				'note' => null,
			),
		),
	),
);
return $market;