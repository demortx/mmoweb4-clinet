<?php

use ApiLib\GlobalApi;

/**
 * Компоненты сайта
 */

class SiteComponents
{

    static function db(){

        try {
            return get_instance()->db();
        }catch (\Exception $e){
            echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
            exit;
        }
    }

    static function News($count = 10, $page = 1, $pagination = true){

        if (isset($_GET['news']) AND is_numeric($_GET['news']) AND $_GET['news'] > 0)
            $page = $_GET['news'];



        $page = intval($page - 1);
        if ($page<0)
            $page = 0;

        $news_count = get_cache('news_count', true);
        if ($news_count == false) {
            $news_count = self::db()->query('SELECT COUNT(*) AS count_all FROM `mw_news` WHERE publish=1;')->fetch(\PDO::FETCH_ASSOC)['count_all'];
            set_cache('news_count', $news_count, CACHE_NEWS);
        }

        if (ceil($news_count / $count) >= $page) {

            $data = get_cache('news_' . $page, false, true);
            if ($data === false OR isset($data['cache_end'])) {
                $news_list = self::db()->query('SELECT * FROM `mw_news` WHERE publish=1 ORDER BY fixed DESC, `date` DESC LIMIT ' . intval($count) . ' OFFSET ' . ($page * $count) . ';')
                    ->fetchAll(\PDO::FETCH_ASSOC);
                if (is_array($news_list)) {
                    set_cache('news_' . $page, $news_list, CACHE_NEWS);
                } else
                    $news_list = array();
            } else
                $news_list = $data["data"];

        }else
            $news_list = array();

        if (is_array($news_list) AND count($news_list)){
            foreach ($news_list as &$news){
                $news['json'] = json_decode($news['json'], true);
                $news['json'] = get_lang($news['json']);
                if (count($news['json'])) {
                    $news['title'] = isset($news['json']['title']) ? $news['json']['title'] : 'Новость повреждена';
                    $news['body'] = isset($news['json']['body']) ? $news['json']['body'] : 'Новость повреждена';
                    $news['url'] = isset($news['json']['url']) ? set_url($news['json']['url']) : '';
                    $news['img'] = isset($news['json']['img']) ? $news['json']['img'] : '';
                    unset($news['json']);
                }else
                    unset($news);
            }
            $render['news_list'] = $news_list;
        }
        else
            $render['news_list'] = array();

        if ($pagination){
            $paginator = new \Paginator($news_count, $count, ($page+1), '(:num)');
            $paginator->setMaxPagesToShow(5);

            $render['PAGINATION'] = get_instance()->fenom->fetch('site:news_pagination.tpl',
                array_merge(
                    $paginator->toArray(),
                    loud_lang_site()
                )
            );
        }else
            $render['PAGINATION'] = '';

        return get_instance()->fenom->fetch('site:news.tpl',
            array_merge(
                $render,
                loud_lang_site()
            )
        );
    }

    static $forum_avatar = array(
        'ipb3' => 'uploads/profile/photo-:id.',
        'ipb4' => 'uploads/profile/photo-:id.',
        'xenforo2' => 'data/avatars/s/:section_id/:id.jpg?:date',
    );

    static $forum_profile = array(
        'ipb3' => 'index.php?/user/:id-:account/',
        'ipb4' => 'index.php?/user/:id-:account/',
        'xenforo1' => 'members/:account.:id/',
        'xenforo2' => 'members/:id/',
    );

    static $forum_url = array(
        'ipb3' => 'index.php?showtopic=:id',
        'ipb4' => 'index.php?showtopic=:id',
        'xenforo2' => 'index.php?threads/:id/',
    );

    static function Forum($count = false){
        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/forum.tpl')) {
            $cfg = include_once ROOT_DIR . '/Library/forum_config.php';

            if ($count === false AND $cfg["count"] > 0){
                $count = (int) $cfg["count"];
            }

            if ($cfg['enable'] AND $count > 0) {

                if (!empty($cfg['enable'])) {

                    $lang = select_lang();

                    $data = get_cache('forum_' . $lang . '_' . $count, false, true);
                    if ($data === false OR isset($data['cache_end'])) {

                        $curl = new \Curl\Curl($cfg['url']);
                        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
                        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

                        $curl->setTimeout(10);
                        $result = $curl->post(array('api_key' => $cfg['api_key'], 'method' => 'last_post', 'count' => $count, 'allow' => get_lang($cfg['allow']), 'deny' => get_lang($cfg['deny'])));

                        if ($curl->error) {
                            log_write('forum', 'GET last_post:' . $curl->errorCode . ' ' . $curl->errorMessage);
                            $result = array('error' => $curl->errorCode . ' ' . $curl->errorMessage);
                        }
                        if (is_object($result))
                            $result = json_decode(json_encode($result), true);

                        if (is_array($result) AND $result['error'] == 0) {
                            set_cache('forum_' . $lang . '_' . $count, $result, CACHE_FORUM);
                        } else {
                            log_write('forum', 'Save:' . (is_array($result) ? json_decode($result) : $result));
                            set_cache('forum_' . $lang . '_' . $count, $data["data"], CACHE_FORUM);
                            $result = $data["data"];
                        }
                    } else {
                        $result = $data["data"];
                    }

                    $security = new Security();
                    $forum = array();
                    if (isset($result["post"]) AND is_array($result["post"]) AND count($result["post"]) > 0)
                    foreach ($result["post"] as $post) {

                        if (!isset($post['url']) AND isset(self::$forum_url[$cfg['version']]))
                            $post['url'] = str_replace(':id', $post["tid"], self::$forum_url[$cfg['version']]);

                        if (!isset($post['profile']) AND isset(self::$forum_profile[$cfg['version']]))
                            $post['profile'] = str_replace(array(':id', ':account'), array($post["last_poster_id"], $post["last_poster_name"]), self::$forum_profile[$cfg['version']]);

                        if (!isset($post['avatar']) AND isset(self::$forum_avatar[$cfg['version']]))
                            $post['avatar'] = str_replace(array(':id'), array($post["last_poster_id"]), self::$forum_avatar[$cfg['version']]);
                        elseif (is_numeric($post['avatar']) AND $post['avatar'] > 0 AND $cfg['version'] == 'xenforo2')
                            $post['avatar'] = str_replace(array(':id', ':section_id', ':date'), array($post["last_poster_id"], floor($post["last_poster_id"] / 1000), $post['avatar']), self::$forum_avatar[$cfg['version']]);

                        $post['title'] = $security->xss_clean($post['title']);
                        $post['last_poster_name'] = $security->xss_clean($post['last_poster_name']);

                        unset($post["tid"], $post["last_poster_id"], $post["node_id"]);
                        $forum[] = $post;
                    }

                    return get_instance()->fenom->fetch('site:forum.tpl',
                        array_merge(
                            array(
                                'posts' => $forum
                            ),
                            loud_lang_site()

                        )
                    );
                }
            }
            return '';
        }else
            return 'Tpl forum.tpl not found';
    }

    static function Rating($count = 10){
        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/rating.tpl')) {

            $platform = get_platform();

            $servers = array();
            $rating = array();
            if (isset(get_instance()->config['project']['server_info'][$platform])) {
                $servers = get_instance()->config['project']['server_info'][$platform];
                if (is_array($servers)) {
                    foreach ($servers as $sid => $info) {
                        $temp__ = get_cache('rating_' . $sid, false, true, false);
                        $rating[$sid] = $temp__['data'];
                    }

                }

            }

            return get_instance()->fenom->fetch('site:rating.tpl',
                array_merge(
                    array(
                        'platform' => $platform,
                        'servers' => $servers,
                        'section' => array_keys($rating),
                        'rating' => $rating,
                        'count' => $count,

                    ),
                    loud_lang_site()

                )
            );
        }else
            return 'Tpl rating.tpl not found';
    }

    static function api_get_online($sid)
    {
        $api = new GlobalApi();
        $vars = array('sid' => $sid);
        $response = $api->get_online($vars);
        if ($response['ok']) {
            if (isset($response['error'])) {
                $send['error'] = $response['error'];
            } else {
                if (isset($response["response"]->data)) {
                    $send = json_encode($response["response"]->data);
                    $send = json_decode($send, true);
                } else
                    $send['error'] = 'pars_data';
            }

        } else {
            log_write('online_site', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code']);
            $send['error'] = 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'];
        }
        return $send;
    }
    static function get_cache_online($sid){

        $data = get_cache('online_'.$sid, false, true, false);

        if ($data === false OR isset($data['cache_end'])){
            $online = self::api_get_online($sid);
            if (!isset($online['error'])){
                set_cache('online_'.$sid, $online, CACHE_ONLINE);
                $data['data'] = $online;
            }else {
                set_cache('online_' . $sid, $data['data'], CACHE_ONLINE);
            }

        }
        return $data['data'];
    }
    static function get_cache_online_history($sid, $count){
        $data = get_cache('rating_'.$sid, false, true, false);
        $online = array();
        if ($data !== false){
            if (isset($data['data']['online_history']["data"]["online_multiple"]) AND count($data['data']['online_history']["data"]["online_multiple"]) > 0) {
                $line = array_slice($data['data']['online_history']["data"]["online_multiple"], -$count);
                if (is_array($line) AND count($line) > 0) {
                    foreach ($line as $ln){

                        $online[] = $ln[1];
                    }
                }
            }
        }
        return $online;
    }

    static function Server($count = 10, $chart_interval = 10, $chart_percent = false){
        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/server_status.tpl')) {
            $platform = get_platform();
            $server_site_cfg = include_once ROOT_DIR . '/Library/server_config.php';
            $servers = array();
            if (isset(get_instance()->config['project']['server_info'][$platform])) {
                $servers_temp = get_instance()->config['project']['server_info'][$platform];
                if (is_array($servers_temp)) {
                    $i = 0;
                    foreach ($servers_temp as $sid => $info) {


                        $servers[$sid]['name'] = $info['name'];
                        $servers[$sid]['rate'] = $info['rate'];

                        if (isset($server_site_cfg[$sid])) {


                            if(isset($server_site_cfg[$sid]['hide']) AND $server_site_cfg[$sid]['hide'] == 0) {
                                unset($servers[$sid]);
                                continue;
                            }

                            if ($server_site_cfg[$sid]['re_name'] AND !empty($server_site_cfg[$sid]['name']))
                                $servers[$sid]['name'] = $server_site_cfg[$sid]['name'];

                            if ($server_site_cfg[$sid]['re_rate'])
                                $servers[$sid]['rate'] = $server_site_cfg[$sid]['rate'];

                            $servers[$sid]['icon'] = $server_site_cfg[$sid]['icon'];
                            $servers[$sid]['img'] = $server_site_cfg[$sid]['img'];
                            $servers[$sid]['link'] = $server_site_cfg[$sid]['link'];
                            $servers[$sid]['chronicle'] = $server_site_cfg[$sid]['chronicle'];
                            $servers[$sid]['description'] = $server_site_cfg[$sid]['description'];
                            $servers[$sid]['date'] = $server_site_cfg[$sid]['date'];
                            $servers[$sid]['time'] = $server_site_cfg[$sid]['time'];
                            $servers[$sid]['time_zone'] = $server_site_cfg[$sid]['time_zone'];
                            $servers[$sid]['max_online'] = $server_site_cfg[$sid]['max_online'];
                        } else {
                            $servers[$sid]['img'] = '';
                            $servers[$sid]['icon'] = '';
                            $servers[$sid]['link'] = '';
                            $servers[$sid]['chronicle'] = '';
                            $servers[$sid]['description'] = '';
                            $servers[$sid]['date'] = '';
                            $servers[$sid]['time'] = '';
                            $servers[$sid]['time_zone'] = '';
                            $servers[$sid]['max_online'] = '5000';
                        }
                        if ($info["status"] == true) {

                            $servers[$sid]['online'] = self::get_cache_online($sid);
                            $servers[$sid]['online_history'] = self::get_cache_online_history($sid, $chart_interval);
                        }else{

                            $servers[$sid]['online'] = array(
                                "login" => 0,
                                "server" => 0,
                                "online" => 0,
                                "online_multiple" => 0,
                                "characters" => 0,
                                "clan" => 0,
                                "data" => 0,
                                "max_online" => 0,
                                "max_online_multiple" => 0,
                                "date" => array()
                            );
                        }


                        if (isset($servers[$sid]['online_history'])
                            AND is_array($servers[$sid]['online_history'])
                            AND count($servers[$sid]['online_history']) > 0) {
                            if ($chart_percent)
                            {
                                foreach ($servers[$sid]['online_history'] AS &$online) {
                                    $online = ceil($online * 100 / (int)$servers[$sid]['max_online']);
                                    if ($online > 100)
                                        $online = 100;
                                }
                            }
                        }else
                            $servers[$sid]['online_history'] = array_fill(0, $chart_interval, 0);





                        if (is_array($servers[$sid]['online'])) {

                            if (isset($server_site_cfg[$sid]['on_login']) AND isset($server_site_cfg[$sid]['on_server']))
                                $servers[$sid]['online']['server'] = ((int)$servers[$sid]['online']['server'] == 1 AND (int)$servers[$sid]['online']['login'] == 1);
                            elseif (isset($server_site_cfg[$sid]['on_login']))
                                $servers[$sid]['online']['server'] = ((int)$servers[$sid]['online']['login'] == 1);
                            elseif (isset($server_site_cfg[$sid]['on_server']))
                                $servers[$sid]['online']['server'] = ((int)$servers[$sid]['online']['server'] == 1);
                            else
                                $servers[$sid]['online']['server'] = true;

                            unset($servers[$sid]['online']['login']);
                        }

                        $i++;
                        if ($count == $i) break;
                    }
                }
            }

            $from = new \DateTime(date("Y-m-d H:00:00", strtotime("-".($chart_interval-1)." hour")));
            $to   = new \DateTime();
            $period = new \DatePeriod($from, new \DateInterval('PT1H'), $to);
            $labels = array_map(
                function($item){return $item->format('H:i');},
                iterator_to_array($period)
            );

            return get_instance()->fenom->fetch('site:server_status.tpl',
                array_merge(
                    array(
                        'platform' => $platform,
                        'servers' => $servers,
                        'count' => $count,
                        'labels' => $labels,

                    ),
                    loud_lang_site()
                )
            );
        }else
            return 'Tpl server_status.tpl not found';
    }

    static function streamUpdate(){
        $fenom = false;
        $ajaxsmg = false;
        $config = false;
        $adm = new \AdminPlugins\Broadcast($fenom, $ajaxsmg, $config);
        $adm->updateStreams();
    }

    static function Streams($count = 10){

        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/streams.tpl')) {


            $data = get_cache('broadcast_c', false, true, false);

            if ($data === false OR isset($data['cache_end'])) {
                set_cache('broadcast_c', $data['data'], CACHE_STREAM);
                self::streamUpdate();

                $stream = self::db()->query('SELECT * FROM `mw_broadcast` WHERE publish=1 AND online=1 LIMIT ' . intval($count) . ';')->fetchAll(\PDO::FETCH_ASSOC);

                if (is_array($stream) AND count($stream)) {
                    set_cache('broadcast_c', $stream, CACHE_STREAM);
                } else {
                    set_cache('broadcast_c', array(), CACHE_STREAM);
                }
            } else
                $stream = $data['data'];

            foreach ($stream as &$item) {
                if ($item['type'] == 'twitch') {
                    $item['link'] = 'https://player.twitch.tv/?channel=' . $item['chanel'].'&parent='.urlencode($_SERVER['HTTP_HOST']);
                    $item['key'] = $item['chanel'];
                } else if ($item['type'] == 'youtube') {
                    $item['json'] = json_decode($item['json'], true);
                    $item['link'] = 'https://www.youtube.com/watch?v=' . $item['json']['items'][0]['id']['videoId'];
                    $item['key'] = $item['json']['items'][0]['id']['videoId'];
                }

                unset($item['json'], $item['online'], $item['preview'], $item['date'], $item['id']);
            }

            return get_instance()->fenom->fetch('site:streams.tpl',
                array_merge(
                    array(
                        'stream_exist' => count($stream) > 0,
                        'stream_list' => $stream
                    ),
                    loud_lang_site()
                )
            );


        }else
            return 'Tpl streams.tpl not found';
    }

    static function Language(){
        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/language.tpl')) {
            return get_instance()->fenom->fetch('site:language.tpl',
                array_merge(
                    array(
                        '_LANG' => select_lang(),
                        'language_list' => get_instance()->config['site']['language_list'],
                    ),
                    loud_lang_site()
                )
            );
        }else
            return 'Tpl language.tpl not found';
    }

    static function IBlock($ikey, $count=1){
        $lang = select_lang();
        $data = get_cache('iblock_'.$ikey.'_'.$lang.'_'.$count, false, true);
        if ($data === false OR isset($data['cache_end'])) {
            $iblock = array();
            $iblock_main = self::db()->query('SELECT tpl FROM `mw_iblock` WHERE publish=1 AND ikey='.self::db()->quote($ikey).';');

            if (!$iblock_main)
                return 'IBlock '.$ikey.' not found from DB';

            $iblock_main = $iblock_main->fetch(\PDO::FETCH_ASSOC);
            if(isset($iblock_main['tpl'])){
                $iblock['tpl'] = $iblock_main['tpl'];
                unset($iblock_main);
                $content_list = self::db()->query('SELECT json,`date` FROM `mw_iblock_content` WHERE publish=1 AND ikey='.self::db()->quote($ikey).' ORDER BY `date` DESC LIMIT ' . intval($count) . ';')->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($content_list as &$con){
                    $temp_date = $con['date'];
                    $con['json'] = json_decode($con['json'], true);
                    $con = get_lang($con['json']);
                    $con['date'] = $temp_date;
                    unset($temp_date);
                }
                $iblock['content'] = $content_list;
                unset($content_list);
            }
            if (is_array($iblock) AND count($iblock)) {
                set_cache('iblock_'.$ikey.'_'.$lang.'_'.$count, $iblock, CACHE_IBLOCK);
            } else
                $iblock = array();
        } else
            $iblock = $data["data"];

        if (is_array($iblock) AND isset($iblock['tpl']) AND !empty($iblock['tpl'])){
            if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/'.$iblock['tpl'])) {
                return get_instance()->fenom->fetch('site:'.$iblock['tpl'],
                    array_merge(
                        array(
                            'iblock' => $iblock,
                        ),
                        loud_lang_site()
                    )
                );
            }else
                return 'Tpl '.$iblock['tpl'].' not found';
        }
    }

}