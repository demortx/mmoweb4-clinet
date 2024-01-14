<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 24.09.2019
 * Time: 17:18
 */
namespace Statistic;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\Statistic\Statistic*/
        $this->this_main = $this_main;
    }

    public function widget_rating(){
        //Получаем платформу
        $platform = get_instance()->get_platform();
        //Получаем выбранный сервер
        $rating_sid = get_instance()->get_sid();

        $data = $this->get_cache_rating($rating_sid, $platform);
        //$data['online_history'] = $this->get_cache_online_history($rating_sid);;


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_rating.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'rating' => $data,
                    'section' => array_keys($data),
                    'platform' => $platform,
                    'r_sid' => $rating_sid,

                ),
                get_lang('statistic.lang')
            )

        );

    }

    public function get_cache_rating($sid, $platform){

        $data = get_cache('rating_'.$sid, false, true);
        if ($data === false){
            $data = $this->api_get_rating($sid);

            if (!isset($data['error'])) {
                $data = $this->pars_rating($data, $platform);
                set_cache('rating_' . $sid, $data, CACHE_RATING);
            }
        }elseif(isset($data['cache_end'])){
            $data_new = $this->api_get_rating($sid);
            $data = $data["data"];

            if (!isset($data_new['error'])) {
                $data_new = $this->pars_rating($data_new, $platform);
                set_cache('rating_'.$sid, $data_new, CACHE_RATING);
                $data = $data_new;
                unset($data_new);
            }else {
                set_cache('rating_' . $sid, $data, CACHE_RATING);
            }

        }else{
            $data = $data["data"];
        }


        return $data;
    }

    public function pars_rating($data, $platform){

        //lineage2 - 'top_pvp','top_pk','top_exp','top_clan','top_clan_pvp','top_ally','top_castle','top_clanhols','top_statistic'

        switch ($platform){

            case 'lineage2':
                //Загружаем бибилотеку
                $lib = include_once ROOT_DIR.'/Library/lineage2db.php';
                //перебираем массивы с рейтингами
                foreach ($data as $type_rating => &$top_data) {
                    //если есть ошибка пропускаем
                    if ($top_data['error'] == '1')
                        continue;

                    //перебираем рейтинг
                    if (isset($top_data['data']) AND is_array($top_data['data'])) {
                        $top_data['data'] = array_values($top_data['data']);
                        foreach ($top_data['data'] as $i => &$row) {
                            //перебираем данные из позиции
                            foreach ($row as $key => &$val) {

                                if (is_array($val) AND count($val) == 0) $val = '';

                                if ($key == 'class')
                                    $val = $lib['prof'][$val];

                                if ($key == 'castle' AND is_numeric($val))
                                    $val = $lib['castle'][$val];

                                if ($key == 'castle_id')
                                    $row['castle'] = $lib['castle'][$val];

                                if ($key == 'holl' OR $key == 'holl_id') {
                                    if (isset($lib['agit'][$val])) {
                                        $row['town'] = $lib['agit'][$val]['town'];
                                        $val = $lib['agit'][$val]['name'];
                                    }else{
                                        $row['town'] = '-';
                                    }
                                }

                                if ($key == 'npc_id'){

                                    if (is_numeric($row['rb_online'])){
                                        if ($row['rb_online'] == 1)
                                            $row['rb_online'] = true;
                                        elseif ($row['rb_online'] == 0)
                                            $row['rb_online'] = false;
                                        else{
                                            if (strlen($row['rb_online']) > 11)
                                                $row['rb_online'] = $row['rb_online'] / 1000;

                                            $row['rb_online'] = date('d-m H:i', $row['rb_online']);
                                        }
                                    }else{
                                        $row['rb_online'] = date('d-m H:i', strtotime($row['rb_online']));
                                    }

                                    $row['level'] = $row['rb_level'];
                                    $row['respawn'] = 0;
                                    $row['random'] = 0;

                                    $find = false;
                                    if ($val > 0) {
                                        foreach ($lib['raidboss'] as $rb_key => $rb_info) {
                                            if ($rb_info['npc_id'] == $val) {
                                                $row['rb_name'] = $rb_info['npc_name'];
                                                $row['level'] = $rb_info['level'];
                                                $row['respawn'] = $rb_info['respawn'];
                                                $row['random'] = $rb_info['random'];
                                                $find = true;
                                                break;
                                            }
                                        }
                                    }

                                    if (!$find AND isset($lib['raidboss'][$row['rb_name']])){
                                        $row['rb_name'] = $lib['raidboss'][$row['rb_name']]['npc_name'];
                                        $row['level'] = $lib['raidboss'][$row['rb_name']]['level'];
                                        $row['respawn'] = $lib['raidboss'][$row['rb_name']]['respawn'];
                                        $row['random'] = $lib['raidboss'][$row['rb_name']]['random'];
                                        $find = true;
                                    }

                                    if (!$find){
                                        unset($top_data['data'][$i]);
                                    }

                                }

                                if ($key == 'siege' AND !is_numeric($val)){
                                    if (!empty($val))
                                        $val = strtotime($val);
                                }


                                if ($key == 'use_time')
                                    $val = OnlineTime($val);


                            }

                        }
                    }

                }
                break;

            case 'boi':
                //Загружаем бибилотеку
                $lib = include_once ROOT_DIR.'/Library/boidb.php';
                //перебираем массивы с рейтингами
                foreach ($data as $type_rating => &$top_data) {
                    //если есть ошибка пропускаем
                    if ($top_data['error'] == '1')
                        continue;

                    //перебираем рейтинг
                    if (isset($top_data['data']) AND is_array($top_data['data'])) {
                        $top_data['data'] = array_values($top_data['data']);
                        foreach ($top_data['data'] as &$row) {
                            //перебираем данные из позиции
                            foreach ($row as $key => &$val) {

                                if (is_array($val) AND count($val) == 0) $val = '';

                                if ($key == 'class')
                                    $val = $lib['prof'][$val];

                            }

                        }
                    }

                }
                break;

            case 'muonline':
                //Загружаем бибилотеку
                $lib = include_once ROOT_DIR.'/Library/muonlinedb.php';

                //перебираем массивы с рейтингами
                foreach ($data as $type_rating => &$top_data) {
                    //если есть ошибка пропускаем
                    if ($top_data['error'] == '1')
                        continue;


                    //перебираем рейтинг
                    if (isset($top_data['data']) AND is_array($top_data['data'])) {
                        $top_data['data'] = array_values($top_data['data']);
                        foreach ($top_data['data'] as &$row) {

                            //перебираем данные из позиции
                            foreach ($row as $key => &$val) {

                                if (is_array($val) AND count($val) == 0) $val = '';

                                if ($key == 'Class') {
                                    if (isset($lib['class'][$val][0])) {
                                        $row['class_img'] = $lib['class'][$val][2];
                                        $val = $lib['class'][$val][0];
                                    }else{
                                        $val = '-//-';
                                        $row['class_img'] = 'avatar.jpg';
                                    }
                                }



                                if ($key == 'MapNumber') {
                                    $val = $lib['map_list'][$val];
                                }
                                if ($key == 'G_Mark' AND !empty($val)) {
                                    $val = md5($val);
                                }

                            }

                        }
                    }
                }
                break;
        }


        if (isset($data['online_history'])) {
            $ar_temp = array();
            foreach($data['online_history']['data'] as $row){
                if (is_numeric($row['date']))
                    continue;

                $row['date'] = strtotime($row['date'].':00:00') * 1000;

                if (isset($row['online'])){
                    $ar_temp['online'][] = array( $row['date'], (int) $row['online']);
                }
                if (isset($row['online_multiple'])){
                    $ar_temp['online_multiple'][] = array( $row['date'], (int) $row['online_multiple']);
                }
                if (isset($row['characters'])){
                    $ar_temp['characters'][] = array( $row['date'], (int) $row['characters']);
                }
                if (isset($row['clan'])){
                    $ar_temp['clan'][] = array( $row['date'], (int) $row['clan']);
                }
            }
            $data['online_history']['data'] = $ar_temp;
            unset($ar_temp);
        }


        //если переданы картинки
        if (isset($data['crest'])) {
            //считываем фаил
            $file = base64_decode($data['crest']['file']);
            //создаем деректори.
            if (!is_dir(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'])) {
                mkdir(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'], 0777);
            }
            //записываем архив
            file_put_contents(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'].'/crest.zip', $file);
            if (file_exists(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'].'/crest.zip')){
                $zip = new \ZipArchive;
                $extract = $zip->open(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'].'/crest.zip');
                if($extract === TRUE) {
                    //Извлекаем содержимое архива
                    $zip->extractTo(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid']);
                    //Закрываем Zip-архив
                    $zip->close();
                }
                //удаляем зип архив
                unlink(ROOT_DIR.CACHEPATH.'/crest/'.$data['crest']['sid'].'/crest.zip');
            }
            unset($data['crest']);
        }
        return $data;
    }

    public function api_get_rating($sid)
    {
        $api = new GlobalApi();
        $vars = array('sid' => $sid);
        $response = $api->get_rating($vars);

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
            $send['error'] = 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'];
        }
        return $send;
    }



    public function get_cache_online_history($sid){

        $data = get_cache('online_history_'.$sid, false, true);
        if ($data === false){
            $data = $this->get_online_history($sid);
            if (!isset($data['error']))
                set_cache('online_history_'.$sid, $data, CACHE_HISTORY_ONLINE);
        }elseif(isset($data['cache_end'])){
            $data_new = $this->get_online_history($sid);
            $data = $data["data"];

            if (!isset($data_new['error'])) {
                set_cache('online_history_'.$sid, $data_new, CACHE_HISTORY_ONLINE);
                $data = $data_new;
                unset($data_new);
            }else {
                set_cache('online_history_' . $sid, $data, CACHE_HISTORY_ONLINE);
            }

        }else{
            $data = $data["data"];
        }

        $error = $data['error'];
        unset($data['error']);
        return array('data' => $data, 'error'=> $error);
    }

    public function get_online_history($sid)
    {
        $api = new GlobalApi();
        $vars = array('sid' => $sid, 'limit' => 1000);
        $response = $api->get_online_history($vars);

        if ($response['ok']) {
            if (isset($response['error'])) {
                $send['error'] = $response['error'];
            } else {
                if (isset($response["response"]->data)) {
                    $send = json_encode($response["response"]->data);
                    $send = json_decode($send, true);
                    $send['error'] = 0;
                } else
                    $send['error'] = 'pars_data';
            }
        } else {
            $send['error'] = 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'];
        }
        return $send;
    }

}