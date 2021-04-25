<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\Referral;
use Modules\MainModulesClass;

class Referral extends MainModulesClass
{

    public function __construct()
    {
        $this->mDir = dirname(__FILE__);
        include_once $this->mDir."/func.php";
        $this->func = new \Referral\func( $this );
    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Globals",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Реферальная система',
                'en' => 'Referral system',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "24.04.2021",
            "lastUpdated" => "24.04.2021",
            "class" => __CLASS__,
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
                        'level' => 4,
                        'widget_referral' => function() { return $this->func->widget_referral();},

                    ),
                ),
            ),

        );
        return $content;
    }
}