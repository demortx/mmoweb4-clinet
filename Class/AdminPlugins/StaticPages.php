<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;

class StaticPages
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;

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
                'ru' => 'Статические страницы',
                'en' => 'Static Pages',
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
                'url' => set_url(ADMIN_URL.'/pages'),
                'icon' => 'fa fa-3x fa-object-group',
                'title' => get_lang('admin.lang')['btn_title_StaticPages'],
                'desc' => get_lang('admin.lang')['btn_desc_StaticPages'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'pages'
        );
    }
    public function onRender($s1, $s2){
        if ($s1 == 'pages'){

            if($s2 != false AND is_dir(ROOT_DIR.VIEWPATH .'/site/'.$s2)){
                return $this->openPage($s2);
            }elseif($s2 == 'add'){
                return $this->addPage();
            }elseif($s2 == 'add_save'){
                return $this->addPageSave();
            }elseif($s2 == 'edit'){
                return $this->openPageEdit();
            }elseif($s2 == 'edit_save'){
                return $this->openPageEditSave();
            }else
                return $this->pages_list();
        }


    }

    public function addPage(){

        return $this->fenom->fetch("panel:admin/StaticPages/pages_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"]
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function openPageEdit(){


        if (isset($_GET['page'])){
            $page = $_GET['page'];

            if (file_exists(ROOT_DIR.CACHEPATH.'/Pages/'.$page.'.json')) {

                $json = file_get_contents(ROOT_DIR.CACHEPATH.'/Pages/'.$page.'.json');
                $json = json_decode($json, true);

                return $this->fenom->fetch("panel:admin/StaticPages/pages_edit.tpl",
                    array_merge(
                        array(
                            'language_list' => $this->config["site"]["language_list"],
                            'page_param' => $json,
                            'page_select' => $page
                        ),
                        get_lang('admin.lang')
                    )
                );




            }
        }

        return error_404_html();

    }

    public function openPageEditSave(){

        if (!isset($_GET['page']) OR empty($_GET['page'])){
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_page'])->danger();
            exit;
        }

        if (!isset($_POST['url']) OR empty($_POST['url'])) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_url'])->danger();
            exit;
        }
        if (!isset($_POST['desc']) OR empty($_POST['desc'])) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_desc'])->danger();
            exit;
        }

        if (is_dir(ROOT_DIR.CACHEPATH.'/Pages')){
            $page = $_GET['page'];

            if (file_exists(ROOT_DIR.CACHEPATH.'/Pages/'.$page.'.json')){
                unlink(ROOT_DIR.CACHEPATH.'/Pages/'.$page.'.json');
            }
            $url = $_POST['url'];
            $url = str_replace("/","_",$url);
            if (!file_exists(ROOT_DIR.CACHEPATH.'/Pages/'.$url.'.json')){
                $_POST['date'] = time();

                $json = json_encode($_POST);

                $fw = fopen(ROOT_DIR.CACHEPATH.'/Pages/'.$url.'.json', "a+");
                fwrite($fw, $json);
                fclose($fw);

                if ($page != $url)
                    $page = $url;

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_page_edit'])->location(ADMIN_URL.'/pages/edit?page='.$page)->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_page_already'])->danger();
        }else
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_dir'] . ROOT_DIR.CACHEPATH.'/Pages')->danger();

        exit;

    }

    public function addPageSave(){

        if (!isset($_POST['url']) OR empty($_POST['url'])) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_url'])->danger();
            exit;
        }
        if (!isset($_POST['desc']) OR empty($_POST['desc'])) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_desc'])->danger();
            exit;
        }

        if (is_dir(ROOT_DIR.CACHEPATH.'/Pages')){
            $url = $_POST['url'];
            $url = str_replace("/","_",$url);
            if (!file_exists(ROOT_DIR.CACHEPATH.'/Pages/'.$url.'.json')){
                $_POST['date'] = time();
                $json = json_encode($_POST);

                $fw = fopen(ROOT_DIR.CACHEPATH.'/Pages/'.$url.'.json', "a+");
                fwrite($fw, $json);
                fclose($fw);
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_page_add'])->location(ADMIN_URL.'/pages/edit?page='.$url)->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_page_already'])->danger();
        }else
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['StaticPages_ajax_not_dir'] . ROOT_DIR.CACHEPATH.'/Pages')->danger();

        exit;
    }

    public function pages_list(){

        $pages_list = array();
        if (is_dir(ROOT_DIR.CACHEPATH.'/Pages')){

            $page_files = scandir(ROOT_DIR.CACHEPATH.'/Pages');
            foreach ($page_files as $file) {
                if($file != "." && $file != ".."){
                    if (strripos($file, '.json') !== false){
                        $page = str_replace(".json","",$file);
                        $json = file_get_contents(ROOT_DIR.CACHEPATH.'/Pages/'.$file);
                        $json = json_decode($json, true);
                        if (is_array($json))
                            $pages_list[$page] = $json;
                    }
                }
            }
        }


        return $this->fenom->fetch("panel:admin/StaticPages/pages_list.tpl",
            array_merge(
                array(
                    'pages_list' => $pages_list
                ),
                get_lang('admin.lang')
            )
        );

    }

    public function openPage($s2){


        return '';

    }


}