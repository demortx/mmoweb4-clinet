<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 23.09.2019
 * Time: 13:08
 */
namespace Modules\Globals\HeadInfo;
use Modules\MainModulesClass;


class HeadInfo extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \HeadInfo\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Виджет информации о балансе',
                'en' => 'Balance Information Widget',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "23.09.2019",
            "lastUpdated" => "23.09.2019",
            "class" => __CLASS__,

        );
    }

    public function renderWindow()
    {

        $content = array(

            '/panel' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row' => array(
                    0 =>
                        array(
                            'class' => 'col-md-12  col-sm-12',
                            'level' => 1,
                            'widget_head' => function() { return $this->func->widget_head();},
                        ),

                ),
            ),

        );

        return $content;
        //return isset($content[$uri]) ? $content[$uri] : false;
    }





}