<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class ForumConnect
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;
    public $version = array(
        'xenforo1' => 'XenForo 1.x',
        'xenforo2' => 'XenForo 2.x',
        'ipb3' => 'Invision Power Board 3.x',
        'ipb4' => 'IPS Community Suite 4.x',
    );


    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Подключения форума',
                'en' => 'Forum Connections',
            ),
            'author' => 'Demort',
            'version' => '0.1'
        );
    }

    public function onLoad(){
        return false;
    }
    public function onMenu(){
        return array(
            array(
                'url' => set_url(ADMIN_URL.'/forum'),
                'icon' => 'fa fa-3x fa-forumbee',
                'title' => get_lang('admin.lang')['btn_title_ForumConnect'],
                'desc' => get_lang('admin.lang')['btn_desc_ForumConnect'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'forum'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'forum'){

            if ($s2 == 'save')
                return $this->save_config();


            return $this->index();
        }

    }

    public function index(){

        $cfg = include_once ROOT_DIR . '/Library/forum_config.php';

        return $this->fenom->fetch("panel:admin/ForumConnect/index.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'forum_version' => $this->version,
                    'forum_config' => $cfg,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function save_config(){
        $data = array(
            'enable' => _boolean($_POST['enable']),
            'version' => $_POST['version'],
            'url' => $_POST['url'],
            'api_key' => $_POST['api_key'],
            'count' => (int) $_POST['count'],
            'allow' => $_POST['allow'],
            'deny' => $_POST['deny'],
        );

        $fd = ROOT_DIR . '/Library/forum_config.php';
        $fopen = fopen($fd, "w");
        if (file_exists($fd)) {
            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Forum settings\n");
                fwrite($fopen, "* The config can be changed manually or in the admin panel\n");
                fwrite($fopen, "* Конфиг можно изменить вручную или в админ-панели\n");
                fwrite($fopen, "* /admin/forum\n");
                fwrite($fopen, " ********************************/\n");
                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                cfgWrite($fopen, $data, "return");
                fclose($fopen);
            }
        }
        echo $this->ajaxmsg->notify(get_lang('admin.lang')['ForumConnect_ajax_update'])->success();
        exit;
    }

}