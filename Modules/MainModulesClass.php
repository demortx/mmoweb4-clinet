<?php
namespace Modules;
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 26.10.2017
 */
class MainModulesClass
{
    public $mDir = false;
    public $lang = false;
    public $func = false;


    public function __construct()
    {
        $this->mDir = dirname(__FILE__);
    }

    public function info(){

        return array(
            "author" => "mmoweb",
            "game" => "Lineage",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Главный класс модулей',
                'en' => 'Main class of modules',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "05.03.2019",
            "lastUpdated" => "05.03.2019",
            "class" => __CLASS__,

        );

    }

    public function returnConfig(){
        return array();
    }

    public function onRequest(){
        return false;
    }

    public function onLoad(){
        return false;
    }

    public function onAjax(){
        return false;
    }

    public function onApi(){
        return false;
    }

    public function renderWindow(){
        return array();
    }

    public function renderWindowHero(){
        return array();
    }

    public function renderSide(){
        return false;
    }

    public function cron(){
        return array();
    }

}