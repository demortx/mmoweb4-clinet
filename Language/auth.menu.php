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
            'pt' => 'Painel',
			'cn' => '佩内尔',
			'ko' => '패널',
        ),
        'title_name_min' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
            'pt' => 'Painel',
			'cn' => '佩内尔',
			'ko' => '패널',
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
            'pt' => 'Painel',
			'cn' => '佩内尔',
			'ko' => '패널',
        ),
        'title' => array(
            'ru' => 'Главная',
            'en' => 'Dashboard',
            'gr' => 'Πίνακας Ελέγχου',
			'es' => 'Panel',
            'pt' => 'Painel',
			'cn' => '佩内尔',
			'ko' => '패널',
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
            'pt' => 'Rankings',
			'cn' => '排名',
			'ko' => '랭킹',
        ),
        'title' => array(
            'ru' => 'Рейтинг',
            'en' => 'Rankings',
            'gr' => 'Κατατάξεις',
			'es' => 'Rankings',
            'pt' => 'Rankings',
			'cn' => '排名',
			'ko' => '랭킹',
        ),
        'function' => function(&$buttons){return false;}
    ),

    'shop' => array(
        'enable' => true,
        'level' => 200,
        'empty_hide' => false,
        'href' => '/panel/shop',
        'icon' => 'fa fa-shopping-cart',
        'target' => '_self',
        'name' => array(
            'ru' => 'Магазин',
            'en' => 'Store',
            'gr' => 'Μαγαζί',
			'es' => 'Tienda',
            'pt' => 'Loja',
			'cn' => '商店',
			'ko' => '상점',
        ),
        'title' => array(
            'ru' => 'Магазин',
            'en' => 'Store',
            'gr' => 'Μαγαζί',
			'es' => 'Tienda',
            'pt' => 'Loja',
			'cn' => '商店',
			'ko' => '상점',
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
            'pt' => 'Suporte',
			'cn' => '支持',
			'ko' => '지원',
			
        ),
        'title' => array(
            'ru' => 'Поддержка',
            'en' => 'Support',
            'gr' => 'Υποστήριξη',
			'es' => 'Soporte',
            'pt' => 'Suporte',
			'cn' => '支持',
			'ko' => '지원',
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
            'pt' => 'Transferir para o jogo',
			'cn' => '转会至游戏',
			'ko' => '게임으로 이동',
        ),
        'title' => array(
            'ru' => 'Перевести в игру',
            'en' => 'Transfer to the game',
            'gr' => 'Μεταφορά στο παιχνίδι',
			'es' => 'Transferir al juego',
            'pt' => 'Transferir para o jogo',
			'cn' => '转会至游戏',
			'ko' => '게임으로 이동',
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
            'ru' => 'Пожертвования',
            'en' => 'Balance',
            'gr' => 'Υπόλοιπο',
			'es' => 'Saldo',
            'pt' => 'Saldo',
			'cn' => '平衡',
			'ko' => '균형',
        ),
        'title' => array(
            'ru' => 'Пожертвования',
            'en' => 'Balance',
            'gr' => 'Υπόλοιπο',
			'es' => 'Saldo',
            'pt' => 'Saldo',
			'cn' => '平衡',
			'ko' => '균형',
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
                            'pt' => '<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Transferir para o jogo',
							'cn'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> 转会至游戏',
							'ko'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> 게임으로 이동',
                        ),
                        'function' => function(&$buttons){return false;}

                    ),
                    'item'=> array(
                        'level' => 200,
                        'href'=>'/panel/donations',
                        'target' => '_self',
                        'name'=>array(
                            'en'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Top-up balance',
                            'ru'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Пожертвовать',
                            'gr'=>'<i class="fa fa-fw fa-gamepad mr-5 d-none d-lg-inline"></i> Ανανέωση υπολοίπου',
							'es'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Recargar saldo',
                            'pt'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> Recarregar saldo',
							'cn'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> 补足平衡',
							'ko'=>'<i class="si fa-fw si-plus mr-5 d-none d-lg-inline" style="color: #fab81b;"></i> 최고 균형',
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
                    return ': <span class="text-success balance_html">' . $balance . ' ' . $name_valute . '</span>';
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
            'pt' => 'Ajustes',
			'cn' => '设置',
			'ko' => '설정',
        ),
        'title' => array(
            'ru' => 'Настройки',
            'en' => 'Settings',
            'gr' => 'Ρυθμίσεις',
			'es' => 'Ajustes',
            'pt' => 'Ajustes',
			'cn' => '设置',
			'ko' => '설정',
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
            'pt' => 'Mercado',
			'cn' => '市场',
			'ko' => '시장',
        ),
        'title' => array(
            'ru' => 'Рынок',
            'en' => 'Market',
            'gr' => 'Αγορά',
			'es' => 'Mercado',
            'pt' => 'Mercado',
			'cn' => '市场',
			'ko' => '시장',
        ),
        'function' => function(&$buttons){
            if(get_instance()->config['visualization']['cabinet_layout_login'] != 'top') {
                
                if (!isset(get_instance()->session->session['user_data']['market']['balance']))
                    return '';

                $sid = get_sid();

                if (!isset(get_instance()->market[$sid]['balance']))
                    return '';

                if (get_instance()->market[$sid]['balance'])
                    return '';

                $balance = get_instance()->session->session['user_data']['market']['balance'];

                if (floatval($balance) <= 0)
                    return '';
                else {
                    $name_valute = get_instance()->config['payment_system']['short_name_valute'];
                    return ': <span class="text-success balance_html_market">' . $balance . ' ' . $name_valute . '</span>';
                }
            }else
                return '';
        }
    ),
    'lucky_wheel' => array(
        'enable' => function(){ return get_instance()->check_plugin('lucky_wheel');},
        'level' => 650,
        'empty_hide' => false,
        'href' => '/panel/lucky-wheel',
        'icon' => 'fa fa-superpowers',
        'target' => '_self',
        'name' => array(
            'ru' => 'Колесо фортуны',
            'en' => 'Lucky wheel',
            'gr' => 'Lucky wheel',
			'es' => 'Lucky wheel',
            'pt' => 'Lucky wheel',
			'cn' => '幸运轮',
			'ko' => '운이 좋은 바퀴',
        ),
        'title' => array(
            'ru' => 'Колесо фортуны',
            'en' => 'Lucky wheel',
            'gr' => 'Lucky wheel',
			'es' => 'Lucky wheel',
            'pt' => 'Lucky wheel',
			'cn' => '幸运轮',
			'ko' => '운이 좋은 바퀴',
        ),
        'function' => function(&$buttons){
            $t = filemtime(ROOT_DIR.'/Library/lucky_wheel.php');
            if (isset($_COOKIE['lucky_wheel_new'])){
                if ($_COOKIE['lucky_wheel_new'] != $t)
                    return ' <span class="badge badge-success animated swing infinite">New</span>';
                else
                    return '';
            }
            else
                return ' <span class="badge badge-success animated swing infinite">New</span>';
        }
    ),
    'cases' => array(
        'enable' => function(){ return get_instance()->check_plugin('cases');},
        'level' => 650,
        'empty_hide' => false,
        'href' => '/panel/cases',
        'icon' => 'fa fa-briefcase',
        'target' => '_self',
        'name' => array(
            'ru' => 'Кейсы',
            'en' => 'Cases',
            'gr' => 'Cases',
			'es' => 'Cases',
            'pt' => 'Cases',
			'cn' => '案子',
			'ko' => '사례',
        ),
        'title' => array(
            'ru' => 'Кейсы',
            'en' => 'Cases',
            'gr' => 'Cases',
			'es' => 'Cases',
            'pt' => 'Cases',
			'cn' => '案子',
			'ko' => '사례',
        ),
        'function' => function(&$buttons){
            $t = filemtime(ROOT_DIR.'/Library/cases.php');
            if (isset($_COOKIE['cases_new'])){
                if ($_COOKIE['cases_new'] != $t)
                    return ' <span class="badge badge-success animated swing infinite">New</span>';
                else
                    return '';
            }
            else
                return ' <span class="badge badge-success animated swing infinite">New</span>';
        }
    ),
    'gift_code' => array(
        'enable' => function(){ return get_instance()->check_plugin('gift_code');},
        'level' => 650,
        'empty_hide' => false,
        'href' => '/panel/gift-code',
        'icon' => 'fa fa-gift',
        'target' => '_self',
        'name' => array(
            'ru' => 'Подарочные коды',
            'en' => 'Gift code',
            'gr' => 'Gift code',
            'es' => 'Gift code',
            'pt' => 'Gift code',
            'cn' => '礼品码',
            'ko' => '선물 코드',
        ),
        'title' => array(
            'ru' => 'Подарочные коды',
            'en' => 'Gift code',
            'gr' => 'Gift code',
            'es' => 'Gift code',
            'pt' => 'Gift code',
            'cn' => '礼品码',
            'ko' => '선물 코드',
        ),
        'function' => function(&$buttons){
            $t = filemtime(ROOT_DIR.'/Library/gift_code.php');
            if (isset($_COOKIE['gift_code_new'])){
                if ($_COOKIE['gift_code_new'] != $t)
                    return ' <span class="badge badge-success animated swing infinite">New</span>';
                else
                    return '';
            }
            else
                return ' <span class="badge badge-success animated swing infinite">New</span>';
        }
    ),
    'money_withdrawal' => array(
        'enable' => function(){ return get_instance()->check_plugin('money_withdrawal');},
        'level' => 660,
        'empty_hide' => false,
        'href' => '/panel/withdrawal',
        'icon' => 'fa fa-money',
        'target' => '_self',
        'name' => array(
            'ru' => 'Вывод средств',
            'en' => 'Withdrawal',
            'gr' => 'Withdrawal',
            'es' => 'Withdrawal',
            'pt' => 'Withdrawal',
            'cn' => 'Withdrawal',
            'ko' => 'Withdrawal',
        ),
        'title' => array(
            'ru' => 'Вывод средств',
            'en' => 'Withdrawal',
            'gr' => 'Withdrawal',
            'es' => 'Withdrawal',
            'pt' => 'Withdrawal',
            'cn' => 'Withdrawal',
            'ko' => 'Withdrawal',
        )
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
            'pt' => 'Forum',
			'cn' => '论坛',
			'ko' => '포럼',
        ),
        'title' => array(
            'ru' => 'Форум',
            'en' => 'Forum',
            'gr' => 'Forum',
			'es' => 'Foro',
            'pt' => 'Forum',
			'cn' => '论坛',
			'ko' => '포럼',
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
            'pt' => 'Voltar à página inicial',
			'cn' => '回到主站点',
			'ko' => '기본 사이트로 돌아 가기',
        ),
        'title' => array(
            'ru' => 'На сайт',
            'en' => 'Back to the main site',
            'gr' => 'Επιστροφή στο κεντρικό site',
			'es' => 'Volver al sitio principal',
            'pt' => 'Voltar à página inicial',
			'cn' => '回到主站点',
			'ko' => '기본 사이트로 돌아 가기',
        ),
        'function' => function(&$buttons){return false;}
    ),

);