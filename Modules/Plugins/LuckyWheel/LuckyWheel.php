<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\LuckyWheel;
use Modules\MainModulesClass;

class LuckyWheel extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \LuckyWheel\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Колесо фортуны',
                'en' => 'Lucky Wheel',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "19.03.2021",
            "lastUpdated" => "19.03.2021",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'ajax_get_prize' => function () { return $this->func->ajax_get_prize(); },
            'ajax_get_history' => function () { return $this->func->ajax_get_history(); },
        );

    }

    public function renderWindow()
    {
        $content = array(

            '/panel/lucky-wheel' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 1,
                            'widget_lucky_wheel' => function() { return $this->func->widget_lucky_wheel();},
                        ),


                ),
            ),

        );

        return $content;

    }

}