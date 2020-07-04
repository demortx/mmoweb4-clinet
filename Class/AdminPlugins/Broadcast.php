<?php
/**
 * Created by PhpStorm.
 * User: Demort
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

        $table = $this->db->query("SHOW TABLES LIKE 'mw_broadcast'")->fetch(\PDO::FETCH_ASSOC);
        if ($table === false){
            $this->install();
        }

    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Трансляции на сайте',
                'en' => 'Broadcasts on the site',
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
                'url' => set_url('admin/broadcast'),
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

        $stream_list = $this->db->query('SELECT * FROM `mw_broadcast` ORDER BY publish,`date` DESC;')->fetchAll(\PDO::FETCH_ASSOC);
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

    public function getUserIdTW($name){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.twitch.tv/kraken/users?login='.$name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Accept: application/vnd.twitchtv.v5+json';
        $headers[] = 'Client-Id: '.TWITCH;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo $this->ajaxmsg->notify('getUserIdTW - Error:' . curl_error($ch))->danger();
            exit;
        }
        curl_close($ch);

        return $result;
    }

    public function getTwithc($name, $error = true)
    {

        $user_info = array();
        $id = $this->getUserIdTW($name);

        $id = json_decode($id, true);
        if (is_array($id) AND isset($id['users'])) {

            $users = array_shift($id['users']);
            $user_info['name'] = $users['display_name'];
            $user_info['user_id'] = (int)$users['_id'];
            $user_info['logo'] = $users['logo'];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.twitch.tv/kraken/streams/' . $user_info['user_id']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'Accept: application/vnd.twitchtv.v5+json';
            $headers[] = 'Client-Id: ' . TWITCH;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch) AND $error) {
                echo $this->ajaxmsg->notify('getTwithc - Error:' . curl_error($ch))->danger();
                exit;
            }
            curl_close($ch);

            $result = json_decode($result,true);

            if($result != NULL AND isset($result['stream'])){
                $user_info['preview'] = $result['stream']['preview']['small'];
                $user_info['game'] = $result['stream']['game'];
                $user_info['json'] = json_encode($result);
                $user_info['online'] = 1;
            }else{
                $user_info['preview'] = '';
                $user_info['game'] = '';
                $user_info['json'] = '';
                $user_info['online'] = 0;
            }
        }

        return $user_info;
    }

    public function getYoutube($name, $error = true){
        $user_info = array();

        $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?channelId=' . $name . '&key=' . YOUTUBE . '&part=id,snippet&eventType=live&type=video';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        if (is_array($data) AND isset($data['items'])){
            if (count($data['items'])) {
                $users = array_shift($data['items']);
                $user_info['name'] = $users["snippet"]["channelTitle"];
                $user_info['user_id'] = (int)$users["snippet"]['channelId'];
                $user_info['logo'] = $users["snippet"]["thumbnails"]["default"]["url"];
                $user_info['preview'] = $users["snippet"]["thumbnails"]["medium"]["url"];
                $user_info['online'] = 1;
            }else{
                $user_info['name'] = $name;
                $user_info['user_id'] = $name;
                $user_info['logo'] = '';
                $user_info['preview'] = '';
                $user_info['online'] = 0;
            }
            $user_info['game'] = '--//--';
            $user_info['json'] = $response;

        }else{
            if ($error) {
                echo $this->ajaxmsg->notify('getYoutube - Error:' . $response)->danger();
                exit;
            }
        }

        return $user_info;
    }

    public function addSave(){
        $user = trim($_POST['profile']);

        if ($_POST['platform'] == 'twitch') {
            $user_info = $this->getTwithc(strtolower($user));
        }elseif ($_POST['platform'] == 'youtube'){
            $user_info = $this->getYoutube($user);
        }else{
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_not_profile'])->danger();
            exit();
        }

        if (is_array($user_info) AND isset($user_info['json'])){

            $STH = $this->db->prepare('INSERT INTO `mw_broadcast` (`chanel`,`name`,`user_id`,`logo`,`type`,`game`,`online`,`preview`, `json`, `publish`)
                                            VALUES (:chanel, :name, :user_id, :logo, :type, :game, :online, :preview, :json,  :publish);');

            $STH->bindValue(':chanel', $user);
            $STH->bindValue(':name', $user_info['name']);
            $STH->bindValue(':user_id', $user_info['user_id']);
            $STH->bindValue(':logo', $user_info['logo']);
            $STH->bindValue(':type', $_POST['platform']);
            $STH->bindValue(':game', $user_info['game']);
            $STH->bindValue(':online', $user_info['online']);
            $STH->bindValue(':preview', $user_info['preview']);
            $STH->bindValue(':json', $user_info['json']);
            $STH->bindValue(':publish', (int) $_POST['publish']);
            $STH->execute();

            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_add_stream'])->location('admin/broadcast')->success();
            exit;

        }else {
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_error_add_stream'])->danger();
            exit;
        }

    }

    public function deleteStream(){
        if (isset($_GET['stream'])){
            $id = intval($_GET['stream']);
            $this->db->query('DELETE FROM `mw_broadcast` WHERE id='.$id.';')->fetch();
        }
    }

    public function refreshSteam(){
        if (isset($_GET['stream'])){
            $id = intval($_GET['stream']);

            $cfg = $this->db->query('SELECT * FROM `mw_broadcast` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            if ( $cfg['type'] == 'twitch') {
                $user_info = $this->getTwithc($cfg['chanel']);
            }elseif ( $cfg['type'] == 'youtube'){
                $user_info = $this->getYoutube($cfg['chanel']);
            }else{
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_not_profile'])->danger();
                exit();
            }
           

            if (is_array($user_info) AND isset($user_info['json'])){
                $STH = $this->db->prepare('UPDATE `mw_broadcast` SET `name` = :name, `user_id` = :user_id, `logo` = :logo, `game` = :game, `online` = :online, `preview` = :preview, `json` = :json WHERE id=:id;');
                $STH->bindValue(':name', $user_info['name']);
                $STH->bindValue(':user_id', $user_info['user_id']);
                $STH->bindValue(':logo', $user_info['logo']);
                $STH->bindValue(':game', $user_info['game']);
                $STH->bindValue(':online', $user_info['online']);
                $STH->bindValue(':preview', $user_info['preview']);
                $STH->bindValue(':json', $user_info['json']);
                $STH->bindValue(':id', $id);
                $STH->execute();

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_update_stream'])->location('admin/broadcast')->success();
                exit;

            }else {
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['Broadcast_ajax_error_add_stream'])->danger();
                exit;
            }

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

    public function updateStreams(){

        $list = $this->db->query('SELECT * FROM `mw_broadcast` WHERE publish=1;')->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($list as $cfg) {
            $user_info = array();
            if ($cfg['type'] == 'twitch') {
                $user_info = $this->getTwithc($cfg['chanel']);
            } elseif ($cfg['type'] == 'youtube') {
                $user_info = $this->getYoutube($cfg['chanel']);
            }else
                continue;

            if (is_array($user_info) AND isset($user_info['json'])) {
                $STH = $this->db->prepare('UPDATE `mw_broadcast` SET `name` = :name, `user_id` = :user_id, `logo` = :logo, `game` = :game, `online` = :online, `preview` = :preview, `json` = :json WHERE id=:id;');
                $STH->bindValue(':name', $user_info['name']);
                $STH->bindValue(':user_id', $user_info['user_id']);
                $STH->bindValue(':logo', $user_info['logo']);
                $STH->bindValue(':game', $user_info['game']);
                $STH->bindValue(':online', $user_info['online']);
                $STH->bindValue(':preview', $user_info['preview']);
                $STH->bindValue(':json', $user_info['json']);
                $STH->bindValue(':id', $cfg['id']);
                $STH->execute();
            }
        }
    }

    public function install(){
        $this->db->query("
            DROP TABLE IF EXISTS `mw_broadcast`;
            CREATE TABLE `mw_broadcast` (
              `id` int(11) NOT NULL,
              `chanel` varchar(150) NOT NULL,
              `name` varchar(150) NOT NULL,
              `user_id` varchar(50) NOT NULL,
              `logo` varchar(250) NOT NULL,
              `type` varchar(15) NOT NULL,
              `game` varchar(40) NOT NULL,
              `online` int(1) NOT NULL DEFAULT '0',
              `preview` varchar(150) NOT NULL,
              `json` mediumtext NOT NULL,
              `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `publish` int(1) NOT NULL DEFAULT '1'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            
            ALTER TABLE `mw_broadcast`
              ADD PRIMARY KEY (`id`),
              ADD KEY `publish` (`publish`);
            
            ALTER TABLE `mw_broadcast`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }


}