<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;

class UpdateCentre
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;

    public $cdn = 'https://update.mmoweb.ru';
    public $version = 0;


    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;

        $this->version = include ROOT_DIR . '/Library/version.php';
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Центр обновлений',
                'en' => 'Update center',
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
                'url' => set_url(ADMIN_URL.'/updating'),
                'icon' => 'fa fa-3x fa-cloud-download',
                'title' => get_lang('admin.lang')['btn_title_UpdateCentre'],
                'desc' => get_lang('admin.lang')['btn_desc_UpdateCentre'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'updating'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'updating'){

            if ($s2 == 'install')
                return $this->update();


            return $this->index();
        }

    }

    public function update(){


        $update = new \AutoUpdate(ROOT_DIR . '/cache/temp', ROOT_DIR, 60);
        $version = $this->version;

        $check_update = true;
        $update_list = array();
        $logs = array();
        $new_version = false;
        $update_version = false;

        $update->setCurrentVersion($version);
        $update->setUpdateUrl($this->cdn);
        if ($update->checkUpdate() === false) {
            $check_update = false;
        }
        if ($check_update) {
            if ($update->newVersionAvailable()) {
                $new_version = $update->getLatestVersion();
                $update_list = $update->getVersionsToUpdateDesc();
                $update->onEachUpdateFinish('UpdateFinishCallback');
                $update_version = $update->update(false);
                $logs = $update->getLogsUpdate();
            }
        }

        return $this->fenom->fetch("panel:admin/UpdateCentre/install.tpl",
            array_merge(
                array(
                    'check_update' => $check_update,
                    'update_list' => $update_list,
                    'new_version' => $new_version,
                    'version' => $this->version,
                    'update_version' => $update_version,
                    'logs' => $logs,
                ),
                get_lang('admin.lang')
            )
        );

    }

    public function index(){

        $update = new \AutoUpdate(ROOT_DIR . '/cache/temp', ROOT_DIR, 60);
        $version = $this->version;

        $check_update = true;
        $update_list = array();
        $new_version = false;

        $update->setCurrentVersion($version);
        $update->setUpdateUrl($this->cdn);
        if ($update->checkUpdate() === false) {
            $check_update = false;
        }
        if ($check_update) {
            if ($update->newVersionAvailable()) {
                $new_version = $update->getLatestVersion();
                $update_list = $update->getVersionsToUpdateDesc();
            }
        }

        return $this->fenom->fetch("panel:admin/UpdateCentre/index.tpl",
            array_merge(
                array(
                    'check_update' => $check_update,
                    'update_list' => $update_list,
                    'new_version' => $new_version,
                    'version' => $this->version,
                ),
                get_lang('admin.lang')
            )
        );
    }

}