<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\Statistic;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;


class Statistic extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Statistic\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль статистики',
                'en' => 'Statistic module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "28.02.2020",
            "lastUpdated" => "28.02.2020",
            "class" => __CLASS__,

        );
    }

    public function onRequest(){
        return $this->func->widget_rating();
    }

}