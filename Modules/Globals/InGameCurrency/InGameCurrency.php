<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 28.01.2020
 * Time: 14:15
 */

namespace Modules\Globals\InGameCurrency;
use Modules\MainModulesClass;

class InGameCurrency extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \InGameCurrency\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Покупка внутриигровой валюты',
                'en' => 'In-game currency purchase',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "28.01.2020",
            "lastUpdated" => "28.01.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'open_form' => function () { return $this->func->ajax_open_form(); },
            'buy_in_game' => function () { return $this->func->ajax_buy_in_game(); },



        );

    }



}