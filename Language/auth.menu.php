<?php
return array(

    'title_name' => array(
        'enable' => true,
        'level' => 1,
        'title_name' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
        ),
        'title_name_min' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
        ),

    ),

    'panel' => array(
        'enable' => true,
        'level' => 2,
        'empty_hide' => false,
        'href' => '/panel',
        'icon' => 'fa fa-home',
        'target' => '_self',
        'name' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
        ),
        'title' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
        ),
        'function' => function(&$buttons){return false;}
    ),


    'rating' => array(
        'enable' => true,
        'level' => 100,
        'empty_hide' => false,
        'href' => '/rating',
        'icon' => 'fa fa-line-chart',
        'target' => '_self',
        'name' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rankings',
            'gr' => 'Κατατάξεις',
			'es' => 'Rankings',
        ),
        'title' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rankings',
            'gr' => 'Κατατάξεις',
			'es' => 'Rankings',
        ),
        'function' => function(&$buttons){return false;}
    ),

    'shop' => array(
        'enable' => true,
        'level' => 200,
        'empty_hide' => false,
        'href' => '/shop',
        'icon' => 'fa fa-shopping-cart',
        'target' => '_self',
        'name' => array(
            'ru' => 'Магазин',
            'en' => 'Store',
            'gr' => 'Μαγαζί',
			'es' => 'Tienda',
        ),
        'title' => array(
            'ru' => 'Магазин',
            'en' => 'Store',
            'gr' => 'Μαγαζί',
			'es' => 'Tienda',
        ),
        'function' => function(&$buttons){
            $t = filemtime(ROOT_DIR.'/Library/shop.php');
            if (isset($_COOKIE['shop_new'])){
                if ($_COOKIE['shop_new'] != $t)
                    return ' <span class="badge badge-success animated swing infinite">New</span>';
                else
                    return '';
            }
            else
                return ' <span class="badge badge-success animated swing infinite">New</span>';
        }
    ),
    'support' => array(
        'enable' => function(){ return get_instance()->check_plugin('support');},
        'level' => 400,
        'empty_hide' => false,
        'href' => '/panel/support',
        'icon' => 'fa fa-support',
        'target' => '_self',
        'name' => array(
            'ru' => 'Поддержка',
            'en' => 'Support',
            'gr' => 'Υποστήριξη',
			'es' => 'Soporte',
        ),
        'title' => array(
            'ru' => 'Поддержка',
            'en' => 'Support',
            'gr' => 'Υποστήριξη',
			'es' => 'Soporte',
        ),
        'function' => function(&$buttons){
            $count = 0;
            if (isset(get_instance()->session->getSession()["user_data"]["support"]["count_answer"]))
                $count = intval(get_instance()->session->getSession()["user_data"]["support"]["count_answer"]);

            if ($count > 0)
                return ' <span class="badge badge-primary badge-pill animated swing infinite">'.$count.'</span>';
            else
                return '';
        }
    ),
    'in_game' => array(
        //'custom_btn' => true, //Раскоментируй чтоб кнопка появилась активирует вариант кастомного меню и уберет правила проверки активных кнопок
        'enable' => true,
        'level' => 450,
        'empty_hide' => false,
        'href' => 'javascript:void(0);',
        'icon' => 'fa fa-fw fa-gamepad',
        'target' => '_self',
        'class' => 'submit-btn',
        'btn_ajax' => btn_ajax("Modules\Globals\InGameCurrency\InGameCurrency", "open_form", [1]),
        'name' => array(
            'ru' => 'Перевести в игру',
            'en' => 'Transfer to the game',
            'gr' => 'Μεταφορά στο παιχνίδι',
			'es' => 'Transferir al juego',
        ),
        'title' => array(
            'ru' => 'Перевести в игру',
            'en' => 'Transfer to the game',
            'gr' => 'Μεταφορά στο παιχνίδι',
			'es' => 'Transferir al juego',
        ),
        'function' => function(&$buttons){
            if(get_instance()->config['visualization']['cabinet_layout_login'] != 'top') {
                $balance = get_instance()->session->session['user_data']['balance'];

                if (floatval($balance) <= 0)
                    return '';
                else {
                    $name_valute = get_instance()->config['payment_system']['short_name_valute'];
                    return ' : <span class="text-success balance_html">' . $balance . ' ' . $name_valute . '</span>';
                }
            }else
                return '';
        }
    ),
    'donations' => array(
        'enable' => true,
        'level' => 500,
        'empty_hide' => false,
        'href' => '/panel/donations',
        'icon' => 'si si-diamond',
        'target' => '_self',
        'name' => array(
            'ru' => 'Баланс',
            'en' => 'Balance',
            'gr' => 'Υπόλοιπο',
			'es' => 'Saldo',
        ),
        'title' => array(
            'ru' => 'Баланс',
            'en' => 'Balance',
            'gr' => 'Υπόλοιπο',
			'es' => 'Saldo',
        ),
        'init' => function(&$buttons){
            //если меню горизонтальное подставляем выбор

            if(get_instance()->config['visualization']['cabinet_layout_login'] == 'top'){
                $buttons['ul'] = array(
                    'pagelist'=> array(
                        'level' => 100,
                        'href'=>'javascript:void(0);',
                        'target' => '_self',
                        'class' => 'submit-btn',
                        'btn_ajax' => btn_ajax("Modules\Globals\InGameCurrency\InGameCurrency", "open_form", [1]),
                        'name'=>array(
                            'en'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Transfer to game',
                            'ru'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Перевести в игру',
                            'gr'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Μεταφορά στο παιχνίδι',
							'es'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Transferir al juego',
                        ),
                        'function' => function(&$buttons){return false;}

                    ),
                    'item'=> array(
                        'level' => 200,
                        'href'=>'/panel/donations',
                        'target' => '_self',
                        'name'=>array(
                            'en'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Top-up balance',
                            'ru'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Пополнить баланс',
                            'gr'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Ανανέωση υπολοίπου',
							'es'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Recargar saldo',
                        ),
                        'function' => function(&$buttons){return false;}

                    ),
                );

            }
        },
        'function' => function(&$buttons){
            if(get_instance()->config['visualization']['cabinet_layout_login'] != 'top') {
                $balance = get_instance()->session->session['user_data']['balance'];

                if (floatval($balance) <= 0)
                    return '';
                else {
                    $name_valute = get_instance()->config['payment_system']['short_name_valute'];
                    return ' : <span class="text-success balance_html">' . $balance . ' ' . $name_valute . '</span>';
                }
            }else
                return '';
        }
    ),
    'settings' => array(
        'enable' => true,
        'level' => 600,
        'empty_hide' => false,
        'href' => '/panel/settings',
        'icon' => 'si si-settings',
        'target' => '_self',
        'name' => array(
            'ru' => 'Настройки',
            'en' => 'Settings',
            'gr' => 'Ρυθμίσεις',
			'es' => 'Ajustes',
        ),
        'title' => array(
            'ru' => 'Настройки',
            'en' => 'Settings',
            'gr' => 'Ρυθμίσεις',
			'es' => 'Ajustes',
        ),
        'function' => function(&$buttons){return false;}
    ),
    'market' => array(
        'enable' => function(){ return get_instance()->check_plugin('market');},
        'level' => 650,
        'empty_hide' => false,
        'href' => '/panel/market',
        'icon' => 'fa fa-bank',
        'target' => '_self',
        'name' => array(
            'ru' => 'Рынок',
            'en' => 'Market',
            'gr' => 'Αγορά',
			'es' => 'Mercado',
        ),
        'title' => array(
            'ru' => 'Рынок',
            'en' => 'Market',
            'gr' => 'Αγορά',
			'es' => 'Mercado',
        ),
        'function' => function(&$buttons){return false;}
    ),
    'forum' => array(
        'enable' => true,
        'level' => 700,
        'empty_hide' => false,
        'href' => isset(get_instance()->config['site']['url_forum']) ? get_instance()->config['site']['url_forum'] : '/',
        'icon' => 'si si-bubbles',
        'target' => '_blank',
        'name' => array(
            'ru' => 'Форум',
            'en' => 'Forum',
            'gr' => 'Forum',
			'es' => 'Foro',
        ),
        'title' => array(
            'ru' => 'Форум',
            'en' => 'Forum',
            'gr' => 'Forum',
			'es' => 'Foro',
        ),
        'function' => function(&$buttons){return false;}
    ),

    'site' => array(
        'enable' => true,
        'level' => 800,
        'empty_hide' => false,
        'href' => isset(get_instance()->config['site']['url_website']) ? get_instance()->config['site']['url_website'] : '/',
        'icon' => 'si si-action-undo',
        'target' => '_blank',
        'name' => array(
            'ru' => 'На сайт',
            'en' => 'Back to the main site',
            'gr' => 'Επιστροφή στο κεντρικό site',
			'es' => 'Volver al sitio principal',
        ),
        'title' => array(
            'ru' => 'На сайт',
            'en' => 'Back to the main site',
            'gr' => 'Επιστροφή στο κεντρικό site',
			'es' => 'Volver al sitio principal',
        ),
        'function' => function(&$buttons){return false;}
    ),

);