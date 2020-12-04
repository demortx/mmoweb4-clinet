<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Lineage2\Market;
use Modules\MainModulesClass;

class Market extends MainModulesClass
{
    public $market = array();
    public $sid;

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        $this->market = &get_instance()->market;
        $this->sid = get_instance()->sid;

        if (isset($this->market[$this->sid]))
            $this->market = $this->market[$this->sid];
        else
            $this->market = false;


        include_once $this->mDir."/func.php";
        $this->func = new \Market\func( $this );

    }

    public function status(){

        if ($this->market === false)
            return false;
        else
        {
            if (isset($this->market['status']) AND $this->market['status'])
                return true;
            else
                return false;
        }
    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Lineage2",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Биржа',
                'en' => 'Market',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "14.09.2020",
            "lastUpdated" => "14.09.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        if ($this->status() == false)
            return array();

        return array(
            //'ajax_open_form' => function () { return $this->func->ajax_open_form(); },
            'ajax_loud_inventory' => function () { return $this->func->ajax_loud_inventory(); },
            'ajax_sell_item' => function () { return $this->func->ajax_sell_item(); },

        );

    }

    public function renderWindow()
    {

        if ($this->status() == false) {
            return array(
                '/panel/market' => array(
                    'header' => 'Торговая <small>площадка</small>',
                    'row' => array(
                        array(
                            'class' => 'col-12 col-md-12',
                            'level' => 1,
                            'widget_market_disable' => function () {
                                return $this->func->widget_market_disable();
                            },
                        ),


                    ),
                ),
            );

        }


        $content = array(
            '/panel/market' => array(
                'header' => 'Торговая <small>площадка</small>',
                'row' => array(
                    array(
                        'class' => 'col-12 col-md-3',
                        'level' => 1,
                        'widget_categories_vertical' => function() { return $this->func->widget_categories_vertical();},
                    ),
                    array(
                        'class' => 'col-12 col-md-9',

                        'level' => 2,
                        'row gutters-tiny' => array(
                            array(
                                'class' => 'col-12 col-md-8',
                                'level' => 1,
                                'widget_total_stats' => function() { return $this->func->widget_total_stats();},
                            ),
                            array(
                                'class' => 'col-12 col-md-4',
                                'level' => 2,
                                'widget_user_bar' => function() { return $this->func->widget_user_bar();},
                            ),

                            array(
                                'class' => 'col-12 col-md-12',
                                'level' => 3,
                                'widget_new_item' => function() { return $this->func->widget_new_item();},
                            ),

                        ),
                    ),


                ),
            ),

            '/panel/market/withdrawal' => array(
                'header' => 'Вывод <small>средств</small>',

                'row' => array(
                    array(
                        'class' => 'col-lg-6 offset-lg-3',
                        'level' => 1,
                        'widget_withdrawal' => function() { return $this->func->widget_withdrawal();},
                    ),

                ),


            ),

            '/panel/market/sell' => array(
                'header' => 'Продажа <small>предметов</small>',

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_sell();},
                    ),

                ),


            ),

            '/panel/market/sell-character' => array(
                'header' => 'Продажа <small>персонажа</small>',

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_sell_character();},
                    ),

                ),


            ),



        );

        return $content;

    }
}