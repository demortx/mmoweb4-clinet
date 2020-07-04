<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 21.08.2018
 * Time: 1:29
 */

class Api
{

    public $version = 1.0;


    public $curl;
    public $key;
    public $base_url;
    public $time = 0;


    public $post_data = array();

    public $throttler = false;


    public function __construct($url, $key)
    {

        if ($url == false)
            $this->base_url = API_URL;
        else
            $this->base_url = $url;

        if ($key == false)
            $this->key = API_KEY;
        else
            $this->key = $key;





        $this->curl = new \Curl\Curl($this->base_url);
        $this->curl->setTimeout(100);
        $this->curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');

    }

    public function init(){
        $this->post_data = array(
            'connection' => array(
                'ip' => get_ip(),
                'pid' => get_instance()->get_pid(),
                'secret_key' => get_instance()->get_secret_key(),
                'session' => get_instance()->get_session(),
                'sid' => get_instance()->get_sid(),
                'lang' => get_instance()->get_lang(),
                'platform' => get_instance()->get_platform(),
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            ),
            'variables' => array()

        );

        return $this;
    }

    public function addParam($key, $value = null){

        if(is_array($key))
            $this->post_data['variables'] = array_merge($key, $this->post_data['variables']);
        else
            $this->post_data['variables'][$key]=$value;

        return $this;

    }

    public function generate_hash(){
        unset($this->post_data["hash"]);
        ksort($this->post_data);

        $this->post_data["hash"] = hash_hmac('sha256', $this->curl->buildPostData($this->post_data), $this->key);

    }


    public function get($url, $throttler = true){

        if (!check(get_ip(), CONNECTION_MAX_COUNT, CONNECTION_TIME) AND $throttler){
            $this->throttler = true;
        }else{
            $this->generate_hash();
            $this->time = startTime();
            $this->curl->get($this->base_url .$url , array('request' => $this->post_data));
        }

        return $this;
    }
    public function delete($url, $throttler = true){

        if (!check(get_ip(), CONNECTION_MAX_COUNT, CONNECTION_TIME) AND $throttler){
            $this->throttler = true;
        }else {
            $this->generate_hash();
            $this->time = startTime();
            $this->curl->delete($this->base_url . $url, array('request' => $this->post_data));
        }

        return $this;
    }
    public function put($url, $throttler = true){

        if (!check(get_ip(), CONNECTION_MAX_COUNT, CONNECTION_TIME) AND $throttler){
            $this->throttler = true;
        }else {
            $this->generate_hash();
            $this->time = startTime();
            $this->curl->put($this->base_url . $url, array('request' => $this->post_data));
        }

        return $this;
    }
    public function post($url, $throttler = true){

        if (!check(get_ip(), CONNECTION_MAX_COUNT, CONNECTION_TIME) AND $throttler){
            $this->throttler = true;
        }else {
            $this->generate_hash();
            $this->time = startTime();
            $this->curl->post($this->base_url . $url, array('request' => $this->post_data));
        }

        return $this;
    }


    public function response()
    {


        if ($this->throttler)
            return array('ok' => true, 'error' => get_lang('api.lang')['throttle_error']);


        if($this->curl->error) {
            //$return['http_error'] = $this->curl->error;
            $return['http_code'] = $this->curl->errorCode;
            $return['http_error'] = $this->curl->errorMessage;
            $return['ok'] = false;
        }else {
            $return['http_code'] = $this->curl->getHttpStatusCode();
            $return['ok'] = true;
        }

        if(is_object($this->curl->response)) {
            $return['response'] = $this->curl->response;
            $return['type'] = 'object';
        }elseif(is_array($this->curl->response)) {
            $return['response'] = $this->curl->response;
            $return['type'] = 'array';
        }else{
            $return['response'] = $this->curl->response;
            $return['type'] = 'string';
        }


        if(isset($return['response']->code)){
            $return['response'] = $this->curl->response;
            $return['error'] = (string) $return['response']->error;
            $return['code'] = (int) $return['response']->code;
            $return['ok'] = true;
        }


        if (DEBUG){
            $this->debug($this->post_data, $return);
        }

        return $return;

    }

    public function debug($send, $return){

        $new_file = false;
        $msg = '';

        if ( ! file_exists(ROOT_DIR."/Debug/log_" . date("m.d.y") . ".php"))
            $new_file = true;

        $fw = fopen(ROOT_DIR."/Debug/log_" . date("m.d.y") . ".php", "a+");

        if($new_file)
            $msg .= "<?php defined('ROOT_DIR') OR exit('No direct script access allowed'); ?>".PHP_EOL;

        $msg .= "SEND --" . json_encode($send) .PHP_EOL;

        $msg .= "REPLY --" . json_encode($return) .PHP_EOL;
        $msg .= stopTime($this->time) ." | Date - ".date("H:i:s")." | Size - ".strlen($this->curl->response).PHP_EOL;
        fwrite($fw, $msg);
        fclose($fw);
    }

}