<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\BonusCod;
use Modules\MainModulesClass;

class BonusCod extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \BonusCod\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Бонус код',
                'en' => 'Bonus Cod module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "30.04.2020",
            "lastUpdated" => "30.04.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'ajax_open_form' => function () { return $this->func->ajax_open_form(); },
            'ajax_get_bonus' => function () { return $this->func->ajax_get_bonus(); },

        );

    }


}