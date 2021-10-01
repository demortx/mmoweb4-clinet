<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\Support;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;


class Support extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Support\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Тех.Поддержка',
                'en' => 'Support module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "13.01.2020",
            "lastUpdated" => "14.01.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'get_all_ticket' => function () { return $this->func->ajax_get_all_ticket(); },
            'open_ticket' => function () { return $this->func->ajax_open_ticket(); },



            'change_ticket_type' => function () { return $this->func->ajax_change_ticket_type(); },
            'create_ticket' => function () { return $this->func->ajax_create_ticket(); },
            'send_msg' => function () { return $this->func->ajax_send_msg(); },


        );

    }

    public function renderWindow()
    {
        $content = array(

            '/panel/support' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 2,
                            'widget_ticket_index' => function() { return $this->func->widget_ticket_index();},
                        ),


                ),
            ),

        );

        return $content;
        //return isset($content[$uri]) ? $content[$uri] : false;
    }

    /*
     * CODE
     */

}