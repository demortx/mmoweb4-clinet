<?php
return array(

    'rating' => array(
        'enable' => true,
        'level' => 1,
        'empty_hide' => false,
        'href' => '/rating',
        'icon' => 'fa fa-line-chart',
        'target' => '',
        'name' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rating',
        ),
        'title' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rating',
        ),
        'function' => function(&$buttons){return false;}
    ),
    'shop' => array(
        'enable' => true,
        'level' => 200,
        'empty_hide' => false,
        'href' => '/shop',
        'icon' => 'fa fa-shopping-cart',
        'target' => '',
        'name' => array(
            'ru' => 'Магазин',
            'en' => 'Shop',
        ),
        'title' => array(
            'ru' => 'Магазин',
            'en' => 'Shop',
        ),
        'function' => function(&$buttons){return false;}
    ),
    'donations' => array(
        'enable' => true,
        'level' => 300,
        'empty_hide' => false,
        'href' => '/donations',
        'icon' => 'si si-diamond',
        'target' => '',
        'name' => array(
            'ru' => 'Пожертвования',
            'en' => 'Donations',
        ),
        'title' => array(
            'ru' => 'Пожертвования',
            'en' => 'Donations',
        ),
        'function' => function(&$buttons){return false;}
    ),
    'forum' => array(
        'enable' => true,
        'level' => 400,
        'empty_hide' => false,
        'href' => isset(get_instance()->config['site']['url_forum']) ? get_instance()->config['site']['url_forum'] : '/',
        'icon' => 'si si-bubbles',
        'target' => '_blank',
        'name' => array(
            'ru' => 'Форум',
            'en' => 'Forum',
        ),
        'title' => array(
            'ru' => 'Форум',
            'en' => 'Forum'
        ),
        'function' => function(&$buttons){return false;}
    ),


);