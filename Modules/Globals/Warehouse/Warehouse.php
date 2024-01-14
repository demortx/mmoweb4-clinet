<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 04.12.2019
 * Time: 18:38
 */

namespace Modules\Globals\Warehouse;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;

class Warehouse extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Warehouse\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль склад',
                'en' => 'Warehouse module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "04.12.2019",
            "lastUpdated" => "04.12.2019",
            "class" => __CLASS__,

        );
    }



    public function onAjax()
    {

        return array(
            'send_item' => function () { return $this->func->ajax_send_item(); },

        );

    }

    public function renderWindow()
    {

        $content = array(

            '/panel/warehouse' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row' => array(
                    0 =>
                        array(
                            'class' => 'col-12',
                            'level' => 1,
                            'widget_warehouse' => function() { return $this->func->widget_warehouse();},
                        ),


                ),
            ),

        );

        return $content;
    }

}