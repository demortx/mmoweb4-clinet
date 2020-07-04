<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\VoteSystem;
use Modules\MainModulesClass;

class VoteSystem extends MainModulesClass
{

    public function __construct()
    {
        $this->mDir = dirname(__FILE__);
        include_once $this->mDir."/func.php";
        $this->func = new \VoteSystem\func( $this );
    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Globals",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Голосование',
                'en' => 'Vote',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "15.06.2020",
            "lastUpdated" => "15.06.2020",
            "class" => __CLASS__,
        );
    }

    public function onAjax()
    {
        return array(
            'ajax_cast' => function () { return $this->func->ajax_cast(); },
        );
    }

    public function renderWindow()
    {
        $content = array(
            '/panel' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row' => array(
                    3 =>
                        array(
                            'class' => 'col-6 col-xl-4',
                            'level' => 4,
                            'widget_vote' => function() { return $this->func->widget_vote();},

                        ),
                ),
            ),

        );
        return $content;
    }
}