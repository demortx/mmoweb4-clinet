<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\GiftCode;
use Modules\MainModulesClass;

class GiftCode extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \GiftCode\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль подарочных кодов',
                'en' => 'Gift code',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "05.09.2021",
            "lastUpdated" => "05.09.2021",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'ajax_buy_gift' => function () { return $this->func->ajax_buy_gift(); },
        );

    }

    public function renderWindow()
    {
        $content = array(

            '/panel/gift-code' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 1,
                            'widget_gift_code' => function() { return $this->func->widget_gift_code();},
                        ),
                    2 =>
                        array(
                            'class' => 'col-12',
                            'level' => 2,
                            'widget_gift_code_history' => function() { return $this->func->widget_gift_code_history();},
                        ),


                ),
            ),

        );

        return $content;

    }

}