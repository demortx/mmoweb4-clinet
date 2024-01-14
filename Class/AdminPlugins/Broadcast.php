<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class Broadcast
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;

    public $stream_type = array(
        'twitch' => 'Twitch.tv',
        'youtube' => 'YouTube',
        'trovo' => 'Trovo',
        'other' => 'Other service',
    );

    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        global $TEMP;
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;
        try {
            $this->db = get_instance()->db();
        }catch (\Exception $e){
            echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
            exit;
        }

    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Трансляции на сайте',
                'en' => 'Broadcasts on the site',
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
                'url' => set_url(ADMIN_URL.'/broadcast'),
                'icon' => 'fa fa-3x fa-twitch',
                'title' => get_lang('admin.lang')['btn_title_Broadcast'],
                'desc' => get_lang('admin.lang')['btn_desc_Broadcast'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'broadcast'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'broadcast') {

            if ($s2 == 'add') {
                return $this->addStream();
            } elseif ($s2 == 'add_save') {
                return $this->addSave();
            } elseif ($s2 == 'edit') {
                return $this->editStream();
            } elseif ($s2 == 'edit_save') {
                return $this->editSave();
            } elseif ($s2 == 'refresh'){
                $this->refreshSteam();
            } elseif ($s2 == 'status'){
                $this->statusStream();
            }else {

                if($s2 == 'delete')
                    $this->deleteStream();

                if($s2 == 'delete_cache')
                    $this->deleteCacheStream();

                return $this->broadcast_list();
            }
        }

    }


    public function broadcast_list(){

        $stream_list = $this->db->query('SELECT * FROM `mw_broadcast` ORDER BY `position` ASC, publish,`date` DESC;')->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($stream_list as &$stream) {
            $stream['json'] = json_decode($stream['json'], true);
        }

        return $this->fenom->fetch("panel:admin/Broadcast/stream_list.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'stream_list' => $stream_list,
                    'stream_type' => $this->stream_type,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function addStream(){
        return $this->fenom->fetch("panel:admin/Broadcast/add_stream.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'stream_type' => $this->stream_type,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function editStream() {

        if(isset($_GET['id'])) {
            $stream_id = (int) $_GET['id'];
            $stream_param = $this->db->query('SELECT * FROM `mw_broadcast` where `id`='.$stream_id.' limit 1;')->fetch(\PDO::FETCH_ASSOC);
            if (isset($stream_param['id'])) {
                return $this->fenom->fetch("panel:admin/Broadcast/edit_stream.tpl",
                    array_merge(
                        array(
                            'language_list' => $this->config["site"]["language_list"],
                            'stream_type' => $this->stream_type,
                            'stream_param' => $stream_param,
                            'stream_id' => $stream_id
                        ),
                        get_lang('admin.lang')
                    )
                );
            }
        }
        
        return error_404_html();
    }

    public function deleteCacheStream(){
        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'broadcast_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }
    }

    private function validate($data) {

        switch($data['platform']) {

            case 'youtube':
                if(!preg_match('/^https:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9-_]*)$/', $data['stream'])) {
                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_youtube_error'])->danger();
                    exit();
                }
            break;

            case 'twitch':
                if(!preg_match('/^https:\/\/player\.twitch\.tv\/\?channel\=([a-zA-Z0-9_]+)(\&parent\=[a-zA-Z0-9\.]+)?$/', $data['stream'])) {
                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_twitch_error'])->danger();
                    exit();
                }
                $position = strpos($_POST['stream'], '&');
                if($position) {
                    $_POST['stream'] = substr($_POST['stream'], 0, $position);
                }
            break;
            //https://player.trovo.live/embed/player?streamername=<streamer_username>
            case 'trovo':

            break;

            case 'other':
                // iframe код
            break;

            default:
                echo $this->ajaxmsg->notify('unknown platform')->danger();
                exit();
            break;

        }

        if(!filter_var($data['avatar'], FILTER_VALIDATE_URL)) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_avatar_error'])->danger();
            exit();
        }

        if(!filter_var($data['preview'], FILTER_VALIDATE_URL)) {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_preview_error'])->danger();
            exit();
        }

    }
    
    public function addSave() {
        
        $stream = trim($_POST['stream']);

        $this->validate([
            'platform' => $_POST['platform'], 
            'stream' => $_POST['stream'],
            'avatar' => $_POST['avatar'],
            'preview' => $_POST['preview'],
        ]);

        $STH = $this->db->prepare('insert into `mw_broadcast` (`stream`, `platform`, `name`, `title`, `avatar`,  `preview`, `autoplay`, `mute`, `date`, `position`, `publish`)  values (:stream, :platform, :name, :title, :avatar,  :preview, :autoplay, :mute, :date, :position, :publish)');
        $STH->bindValue(':stream', $stream);
        $STH->bindValue(':platform', $_POST['platform']);
        $STH->bindValue(':name', $_POST['name']);
        $STH->bindValue(':title', $_POST['title']);
        $STH->bindValue(':avatar', $_POST['avatar']);
        $STH->bindValue(':preview', $_POST['preview']);
        $STH->bindValue(':autoplay', (int) $_POST['autoplay']);
        $STH->bindValue(':mute', (int) $_POST['mute']);
        $STH->bindValue(':date', date("Y-m-d H:i:s"));
        $STH->bindValue(':position', (int) $_POST['position']);
        $STH->bindValue(':publish', (int) $_POST['publish']);

        $STH->execute();

        echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_save_stream'])->location(ADMIN_URL.'/broadcast')->success();
        exit;
    }

    public function editSave() {
        


        if(isset($_GET['id'])) {
            $_POST['stream'] = trim($_POST['stream']);
            $stream_id = (int) $_GET['id'];

            $this->validate([
                'platform' => $_POST['platform'], 
                'stream' => $_POST['stream'],
                'avatar' => $_POST['avatar'],
                'preview' => $_POST['preview'],
            ]);

    
            $STH = $this->db->prepare('update `mw_broadcast` set `stream`=:stream, `platform`=:platform, `name`=:name, `title`=:title, `avatar`=:avatar,  `preview`=:preview, `autoplay`=:autoplay, `mute`=:mute, `position`=:position, `publish`=:publish where `id`=:id;');
            $STH->bindValue(':id', $stream_id);
            $STH->bindValue(':stream', $_POST['stream']);
            $STH->bindValue(':platform', $_POST['platform']);
            $STH->bindValue(':name', $_POST['name']);
            $STH->bindValue(':title', $_POST['title']);
            $STH->bindValue(':avatar', $_POST['avatar']);
            $STH->bindValue(':preview', $_POST['preview']);
            $STH->bindValue(':autoplay', (int) $_POST['autoplay']);
            $STH->bindValue(':mute', (int) $_POST['mute']);
            $STH->bindValue(':position', (int) $_POST['position']);
            $STH->bindValue(':publish', (int) $_POST['publish']);
    
            $STH->execute();
    
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_save_stream'])->location(ADMIN_URL.'/broadcast')->success();
            exit;
        }

        
    }

    public function deleteStream(){
        if (isset($_GET['stream'])){
            $id = (int) $_GET['stream'];
            $this->db->query('DELETE FROM `mw_broadcast` WHERE id='.$id.';')->fetch();
        }
    }


    public function statusStream(){
        if (isset($_POST['stream'])) {
            $id = intval($_POST['stream']);
            $status = $_POST['status'] == 'false' ? 0 : 1;
            $STH = $this->db->prepare('UPDATE `mw_broadcast` SET `publish` = :publish WHERE id=:id;');
            $STH->bindValue(':publish', $status);

            $STH->bindValue(':id', $id);
            $STH->execute();

            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_update_status'])->success();
            exit;
        }
    }

    public function install(){
        $this->db->query("
            DROP TABLE IF EXISTS `mw_broadcast`;
            CREATE TABLE `mw_broadcast` (
              `id` INT(10) NOT NULL AUTO_INCREMENT,
              `stream` VARCHAR(2500) NOT NULL,
              `platform` VARCHAR(32) NOT NULL,
              `name` VARCHAR(150) NOT NULL,
              `title` VARCHAR(255) NOT NULL,
              `avatar` VARCHAR(250) NOT NULL,
              `preview` VARCHAR(150) NOT NULL,
              `autoplay` TINYINT(1) NOT NULL DEFAULT '0',
              `mute` TINYINT(1) NOT NULL DEFAULT '1',
              `date` DATETIME NOT NULL,
              `position` INT(10) NOT NULL DEFAULT '0',
              `publish` INT(10) NOT NULL DEFAULT '1',
              PRIMARY KEY (`id`) USING BTREE,
              INDEX `publish` (`publish`) USING BTREE
            )ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ;");
    }


}