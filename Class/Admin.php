<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 03.12.2019
 * Time: 14:56
 */

class Admin
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;

    public $plugins = array();
    public $loaded_plugins = array();
    public $menu = array();
    public $url = array();




    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;

        $this->searchPlugins();
        $this->loadPlugins();
    }

    public function searchPlugins(){
        try{

            $plugins = scandir(ROOT_DIR.'/Class/AdminPlugins');
            foreach ($plugins as $file) {
                if($file != "." && $file != ".."){
                    if (strripos($file, '.php') !== false){
                        $file = str_replace(".php","",$file);
                        if(!isset($this->plugins[$file]))
                            $this->plugins['AdminPlugins\\'.$file] = ROOT_DIR.'/Class/AdminPlugins/'.$file.'.php';
                    }
                }
            }
        } catch(Exception $ex)
        {
            dir($ex->getMessage());
        }
    }

    public function loadPlugins(){

        foreach ($this->plugins as $class => $path)
        {
            if(file_exists($path)) {
                include_once($path);
                $this->loaded_plugins[$class] = new $class($this->fenom, $this->ajaxmsg, $this->config);
                $this->loaded_plugins[$class]->onLoad();
                $this->menu[$class] = $this->loaded_plugins[$class]->onMenu();
                $this->url[$class] = $this->loaded_plugins[$class]->onUrl();
            }
        }
    }

    public function init($s1, $s2){

        if ($s1 !== false) {
            foreach ($this->url as $pgs => $url) {
                if (in_array($s1, $url)) {
                    return $this->loaded_plugins[$pgs]->onRender($s1, $s2);
                }
            }
        }

        return $this->admin_index();
    }

    public function admin_index(){

        return $this->fenom->fetch("panel:admin/index.tpl",
            array_merge(
                array(
                    'menu_list' => $this->menu,
                ),
                get_lang('admin.lang')
            )
        );
    }




}