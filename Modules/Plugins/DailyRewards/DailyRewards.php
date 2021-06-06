<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\DailyRewards;
use Modules\MainModulesClass;

class DailyRewards extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \DailyRewards\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Ежедневные награды',
                'en' => 'Daily rewards',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "27.05.2021",
            "lastUpdated" => "27.03.2021",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'give_daily_rewards' => function () { return $this->func->give_daily_rewards(); },

        );

    }

    public function renderWindowHero()
    {
        $content = array(
            '/panel' => array(

                array(
                    'level' => 1,
                    'widget_daily_rewards' => function() { return $this->func->widget_daily_rewards();},
                ),
            ),
        );

        return $content;

    }

}