<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;


use PDO;

class LangEditor
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;


    public $sid;
    public $platform;

    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;

    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Новости для сайта',
                'en' => 'News for the site',
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
                'url' => set_url(ADMIN_URL.'/lang'),
                'icon' => 'fa fa-3x fa-language',

                'title' => get_lang('admin.lang')['btn_title_LangEditor'],
                'desc' => get_lang('admin.lang')['btn_desc_LangEditor'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'lang'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'lang'){

            if($s2 != false){
                return $this->openLang($s2);
            }else
                return $this->index();
        }


    }

    public function index(){

        $tpl_dir = scandir(ROOT_DIR.VIEWPATH .'/site/');
        $template_list = array();
        foreach ($tpl_dir as $file) {
            if($file != "." && $file != ".."){
                if(file_exists(ROOT_DIR.VIEWPATH .'/site/'.$file.'/Info.php')){
                    $template_list[$file] = include_once ROOT_DIR.VIEWPATH .'/site/'.$file.'/Info.php';
                    if (is_dir(ROOT_DIR.VIEWPATH .'/site/'.$file.'/Lang')){
                        $lang_list = scandir(ROOT_DIR.VIEWPATH .'/site/'.$file.'/Lang');
                        foreach ($lang_list as $lg_file) {
                            if (($lg_file != "." && $lg_file != "..") AND strripos($lg_file, '.php') !== false) {
                                $template_list[$file]['lang'][] = str_replace(".php","",$lg_file);
                            }
                        }
                    }
                }
            }
        }

        return $this->fenom->fetch("panel:admin/LangEditor/template_list.tpl",
            array_merge(
                array(
                    'template_list' => $template_list
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function openLang($s2){

        if ($s2 == 'panel'){

            if (isset($_GET['file']) AND !empty($_GET['file'])){
                $file = $_GET['file'];

                if (isset($_GET['save'])) {


                    if (count($_POST['lang'])) {

                        if (file_exists(ROOT_DIR . '/Language/' . $file)) {
                            $fopen = fopen(ROOT_DIR . '/Language/' . $file, "w");
                            if ($fopen) {
                                fwrite($fopen, "<?php\n");
                                fwrite($fopen, "/********************************\n");
                                fwrite($fopen, "* https://mmoweb.ru\n");
                                fwrite($fopen, " ********************************/\n");
                                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                                cfgWrite($fopen, $_POST['lang'], "return");
                                fclose($fopen);
                                echo $this->ajaxmsg->notify('Save')->success();
                                exit;
                            }
                        } else
                            return 'File not found: ' . $file;
                    }
                }



                if (file_exists(ROOT_DIR.'/Language/'.$file)) {

                    $file_ = str_replace(".php","",$file);

                    if (!isset(get_instance()->language[$file_]))
                        get_lang($file_);

                    $lang_ = get_instance()->language[$file_];
                    $keys_all = array();
                    foreach ($lang_ as $lg => $val) {
                        $keys__ = array_keys($val);

                        foreach ($keys__ as $lk) {
                            if (!in_array($lk, $keys_all))
                                $keys_all[] = $lk;
                        }
                    }

                    return $this->fenom->fetch("panel:admin/LangEditor/lang_file_edit.tpl",
                        array_merge(
                            array(
                                'file' => $file,
                                'lang_' => $lang_,
                                'keys_all' => $keys_all,
                            ),
                            get_lang('admin.lang')
                        )
                    );

                }else
                    return 'File not found: '.$file;

            }else{

                $tpl_dir = scandir(ROOT_DIR.'/Language/');
                $lang_files = array();
                foreach ($tpl_dir as $file) {
                    if($file != "." && $file != ".."){
                        if (in_array($file, array('auth.menu.php', 'menu.php'))) continue;

                        $lang_files[] = array(
                            'file' => $file,
                            'time' => date("Y-m-d H:i:s", filectime(ROOT_DIR.'/Language/'.$file)),
                        );

                    }
                }


                return $this->fenom->fetch("panel:admin/LangEditor/lang_files.tpl",
                    array_merge(
                        array(
                            'lang_files' => $lang_files
                        ),
                        get_lang('admin.lang')
                    )
                );
            }

        }else if (is_dir(ROOT_DIR.VIEWPATH .'/site/'.$s2)){
            $s_lang = $_GET['lang'];
            if (file_exists(ROOT_DIR.VIEWPATH .'/site/'.$s2.'/Lang/'.$s_lang.'.php')) {

                if (isset($_GET['save']) AND count($_POST) > 0) {

                    if (isset($_POST['_arr']) AND is_array($_POST['_arr'])){
                        foreach ($_POST['_arr'] as $k) {
                            if (isset($_POST[$k]) AND !empty($_POST[$k])){
                                $_POST[$k] = json_decode($_POST[$k], true);
                            }
                        }
                    }
                    unset($_POST['_arr']);

                    $fd = ROOT_DIR . VIEWPATH . '/site/' . $s2 . '/Lang/' . $s_lang . '.php';
                    $tpl_info = include_once ROOT_DIR . VIEWPATH . '/site/' . $s2 . '/Info.php';

                    if (file_exists($fd)) {
                        $fopen = fopen($fd, "w");
                        if ($fopen) {
                            fwrite($fopen, "<?php\n");
                            fwrite($fopen, "/********************************\n");
                            fwrite($fopen, "* Lang for template {$tpl_info['name']} \n");
                            fwrite($fopen, "* Author {$tpl_info['author']}\n");
                            fwrite($fopen, "* HTML {$tpl_info['html']}\n");
                            fwrite($fopen, "* Platform {$tpl_info['platform']}\n");
                            fwrite($fopen, "* https://mmoweb.ru\n");
                            fwrite($fopen, " ********************************/\n");
                            fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                            cfgWrite($fopen, $_POST, "return");
                            fclose($fopen);
                            echo $this->ajaxmsg->notify('Save '.$s2)->success();
                            exit;
                        }
                    }

                }


                $lang_key = include_once ROOT_DIR . VIEWPATH . '/site/' . $s2 . '/Lang/' . $s_lang . '.php';
                if (!isset($tpl_info))
                    $tpl_info = include_once ROOT_DIR . VIEWPATH . '/site/' . $s2 . '/Info.php';

                return $this->fenom->fetch("panel:admin/LangEditor/lang_key_edit.tpl",
                    array_merge(
                        array(
                            'lang_key' => $lang_key,
                            'tpl_info' => $tpl_info,
                            's_lang' => $s_lang,
                            'tpl_name' => $s2,
                        ),
                        get_lang('admin.lang')
                    )
                );


            }else
                return 'Язык не найден';
        }else
            return 'Шаблон не найден';

    }

}