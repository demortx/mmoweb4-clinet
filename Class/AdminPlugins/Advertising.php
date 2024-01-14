<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class Advertising
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
                'ru' => 'Рекламная аналитика',
                'en' => 'Advertising analytics',
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
                'url' => set_url(ADMIN_URL.'/advertising'),
                'icon' => 'fa fa-3x fa-pie-chart',
                'title' => get_lang('admin.lang')['btn_title_Advertising'],
                'desc' => get_lang('admin.lang')['btn_desc_Advertising'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'advertising'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'advertising'){

            if ($s2 == 'save')
                return $this->save_config();


            return $this->index();
        }

    }

    public function index(){

        $cfg = include ROOT_DIR . '/Library/advertising.php';

        return $this->fenom->fetch("panel:admin/Advertising/index.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],

                    'advertising_config' => $cfg,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function save_config(){

        $data = array(
            'gawpid' => trim($_POST['gawpid']),
            'ga_anonymize' => _boolean($_POST['ga_anonymize']),
            'gt_manager' => $_POST['gt_manager'],
            'ymid' => intval($_POST['ymid']),
            'ym_webvisor' => _boolean($_POST['ym_webvisor']),
        );

        $fd = ROOT_DIR . '/Library/advertising.php';
        $fopen = fopen($fd, "w");
        if (file_exists($fd)) {
            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Advertising analytics\n");
                fwrite($fopen, "* The config can be changed manually or in the admin panel\n");
                fwrite($fopen, "* Конфиг можно изменить вручную или в админ-панели\n");
                fwrite($fopen, "* /admin/advertising\n");
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