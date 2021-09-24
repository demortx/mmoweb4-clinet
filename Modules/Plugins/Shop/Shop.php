<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\Shop;
use Modules\MainModulesClass;

class Shop extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Shop\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Магазн',
                'en' => 'Shop module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "13.01.2020",
            "lastUpdated" => "22.04.2020",
            "class" => __CLASS__,

        );
    }

    public function onRequestShop($s1 , $s2){

        if ($s2 == false)
            return $this->func->widget_shop_no_auth();
        else
            return $this->func->widget_item_no_auth($s2);
    }


    public function onAjax()
    {

        return array(
            'ajax_buy_shop' => function () { return $this->func->ajax_buy_shop(); },
            'ajax_buy_service' => function () { return $this->func->ajax_buy_service(); },
            'ajax_checkout_shop_no_auth' => function () { return $this->func->ajax_checkout_shop_no_auth(); },
        );

    }

    public function renderWindow()
    {
        $content = array(
            '/panel' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'grid' => array(
                    array(
                        'class' => 'grid-item col-12 col-md-6 col-xl-4',
                        'level' => 6,
                        'widget_shop_advertising' => function() { return $this->func->widget_shop_advertising();},
                    ),
                ),
            ),

            '/panel/shop' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 2,
                            'widget_shop' => function() { return $this->func->widget_shop();},
                        ),


                ),
            ),

            '/panel/shop/(.*)' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 2,
                            'widget_item' => function() { return $this->func->widget_item();},
                        ),


                ),
            ),

        );

        return $content;

    }

}