<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class ServerSettings
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;

    public $time_zone = array(
        '-12',
        '-11',
        '-10',
        '-9',
        '-8',
        '-7',
        '-6',
        '-5',
        '-4',
        '-3',
        '-2',
        '-1',
        '0',
        '+1',
        '+2',
        '+3',
        '+4',
        '+5',
        '+6',
        '+7',
        '+8',
        '+9',
        '+9',
        '+10',
        '+11',
        '+12',
    );

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
                'ru' => 'Настройки сервера для сайта',
                'en' => 'Server settings for the site',
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
                'url' => set_url('admin/servers'),
                'icon' => 'fa fa-3x fa-server',
                'title' => get_lang('admin.lang')['btn_title_ServerSettings'],
                'desc' => get_lang('admin.lang')['btn_desc_ServerSettings'],

            ),

        );
    }
    public function onUrl(){
        return array(
            'servers'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'servers'){

            if ($s2 == 'save')
                return $this->save_config();


            return $this->index();
        }

    }

    public function index(){

        $cfg = include_once ROOT_DIR . '/Library/server_config.php';


        return $this->fenom->fetch("panel:admin/ServerSettings/index.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'server_info' => get_instance()->config['project']['server_info'],
                    'server_cfg' => $cfg,
                    'time_zone' => $this->time_zone,

                ),
                get_lang('admin.lang')
            )
        );
    }

    public function save_config(){

        $data = $_POST["info"];
        $fd = ROOT_DIR . '/Library/server_config.php';
        $fopen = fopen($fd, "w");
        if (file_exists($fd)) {
            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Server settings\n");
                fwrite($fopen, "* Additional server settings for the site\n");
                fwrite($fopen, "* Дополнительные настройки сервера  для сайта\n");
                fwrite($fopen, "* /admin/servers\n");
                fwrite($fopen, " ********************************/\n");
                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                cfgWrite($fopen, $data, "return");
                fclose($fopen);
            }
        }
        echo $this->ajaxmsg->notify(get_lang('admin.lang')['ServerSettings_ajax_edit_success'])->success();
        exit;
    }

}