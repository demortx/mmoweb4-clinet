<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class ClearCache
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;


    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        global $TEMP;
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;

    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Очиистка временных файлов',
                'en' => 'Cleanup temporary files',
            ),
            'author' => 'mmoweb',
            'version' => '0.1'
        );
    }

    public function onLoad(){
        return false;
    }
    public function onMenu(){
        return array(
            array(
                'url' => set_url(ADMIN_URL.'/cache'),
                'icon' => 'fa fa-3x fa-archive',
                'title' => get_lang('admin.lang')['btn_title_ClearCache'],
                'desc' => get_lang('admin.lang')['btn_desc_ClearCache'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'cache'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'cache'){

            if($s2 == 'news')
                $this->deleteCacheNews();

            if($s2 == 'rating')
                $this->deleteCacheRating();

            if($s2 == 'throttler')
                $this->deleteCacheThrottler();

            if($s2 == 'online')
                $this->deleteCacheOnline();

            if($s2 == 'forum')
                $this->deleteCacheForum();

            if($s2 == 'iblock')
                $this->deleteCacheIBlock();

            if($s2 == 'broadcast')
                $this->deleteCacheBroadcast();

            if($s2 == 'template')
                $this->deleteCacheTemplate();

            return $this->index();
        }

    }

    public function index(){


        $cache = scandir(ROOT_DIR.CACHEPATH);
        $cache_list = array();
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){

                if (strripos($file, 'news_') !== false){
                    $cache_list['news'][] = $file;
                }elseif (strripos($file, 'rating_') !== false){
                    $cache_list['rating'][] = $file;
                }elseif (strripos($file, 'throttler_') !== false){
                    $cache_list['throttler'][] = $file;
                }elseif (strripos($file, 'online_') !== false){
                    $cache_list['online'][] = $file;
                }elseif (strripos($file, 'forum_') !== false){
                    $cache_list['forum'][] = $file;
                }elseif (strripos($file, 'iblock_') !== false){
                    $cache_list['iblock'][] = $file;
                }elseif (strripos($file, 'broadcast_') !== false){
                    $cache_list['broadcast'][] = $file;
                }
            }
        }

        $cache = scandir(ROOT_DIR . VIEWPATH . '/compiled');
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                $cache_list['template'][] = $file;
            }
        }


        return $this->fenom->fetch("panel:admin/ClearCache/cache_list.tpl",
            array_merge(
                array(
                    'cache_list' => $cache_list,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function deleteCacheNews(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'news_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }


    public function deleteCacheRating(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'rating_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }


    public function deleteCacheThrottler(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'throttler_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }


    public function deleteCacheOnline(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'online_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }

    public function deleteCacheForum(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'forum_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }

    public function deleteCacheIBlock(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'iblock_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }

    public function deleteCacheBroadcast(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'broadcast_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }

    public function deleteCacheTemplate(){
        $cache = scandir(ROOT_DIR . VIEWPATH . '/compiled');
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                unlink(ROOT_DIR . VIEWPATH . '/compiled/'.$file);
            }
        }
    }



}