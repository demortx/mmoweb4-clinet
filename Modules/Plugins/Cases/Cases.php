<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Plugins\Cases;
use Modules\MainModulesClass;

class Cases extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Cases\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Plugins",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Кейсы',
                'en' => 'Cases',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "22.03.2021",
            "lastUpdated" => "22.03.2021",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'ajax_get_prize' => function () { return $this->func->ajax_get_prize(); },
        );

    }

    public function renderWindow()
    {
        $content = array(

            '/panel/cases' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 1,
                            'widget_cases' => function() { return $this->func->widget_cases();},
                        ),


                ),
            ),
            '/panel/cases/(.*)' => array(
                'row' => array(
                    1 =>
                        array(
                            'class' => 'col-12',
                            'level' => 2,
                            'widget_cases_open' => function() { return $this->func->widget_cases_open();},
                        ),


                ),
            ),
        );

        return $content;

    }

}