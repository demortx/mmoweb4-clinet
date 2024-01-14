<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\MoneyWithdrawal;
use Modules\MainModulesClass;

class MoneyWithdrawal extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \MoneyWithdrawal\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль вывод денег',
                'en' => 'money withdrawal',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "09.09.2021",
            "lastUpdated" => "09.09.2021",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'ajax_withdrawal' => function () { return $this->func->ajax_withdrawal(); },
        );

    }

    public function renderWindow()
    {
        $content = array(

            '/panel/withdrawal' => array(
                'header' => get_lang('withdrawal.lang')['withdrawal_title'],

                'row' => array(
                    array(
                        'class' => 'col-lg-6 offset-lg-3',
                        'level' => 1,
                        'widget_withdrawal' => function() { return $this->func->widget_withdrawal();},
                    ),
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 2,
                        'widget_log_transfer' => function() { return $this->func->widget_log_transfer();},
                    ),

                ),



            ),

            '/panel/withdrawal/\d+' => array(
                'header' => get_lang('withdrawal.lang')['withdrawal_title'],

                'row' => array(
                    array(
                        'class' => 'col-lg-6 offset-lg-3',
                        'level' => 1,
                        'widget_withdrawal_item' => function() { return $this->func->widget_withdrawal_item();},
                    ),


                ),



            ),

        );

        return $content;

    }

}