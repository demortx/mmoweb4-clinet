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
            'en' => 'Rankings',
            'gr' => 'Κατατάξεις',
        ),
        'title' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rankings',
            'gr' => 'Κατατάξεις',
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
            'en' => 'Store',
            'gr' => 'Μαγαζί',
        ),
        'title' => array(
            'ru' => 'Магазин',
            'en' => 'Store',
            'gr' => 'Μαγαζί',
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
            'gr' => 'Δωρεές',
        ),
        'title' => array(
            'ru' => 'Пожертвования',
            'en' => 'Donations',
            'gr' => 'Δωρεές',
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
            'gr' => 'Forum',
        ),
        'title' => array(
            'ru' => 'Форум',
            'en' => 'Forum',
            'gr' => 'Forum',
        ),
        'function' => function(&$buttons){return false;}
    ),


);