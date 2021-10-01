<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 24.09.2019
 * Time: 17:18
 */

namespace VoteSystem;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $shop = array();

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\VoteSystem\VoteSystem*/
        $this->this_main = $this_main;
        $this->shop = &get_instance()->shop;
    }

    public function widget_vote(){
        if (isset(get_instance()->session->session['vote']) AND is_array(get_instance()->session->session['vote']) AND count(get_instance()->session->session['vote'])){
            return get_instance()->fenom->fetch(
                get_tpl_file('widget_vote.tpl', get_class($this->this_main)),
                get_lang('vote.lang')
            );
        }else
            return '';
    }

    public function ajax_cast(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_REQUEST['vote']) OR empty($_REQUEST['vote']) OR count($_REQUEST['vote']) < 1)
                return get_instance()->ajaxmsg->notify(get_lang('vote.lang')['no_select_pool'])->danger();
            else
                $vars["vote"] = $_REQUEST['vote'];

            $vars["utm_fp"] = get_utm('utm_fp');

            $response = $api->send_vote($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {

                        if (isset($response["response"]->data)) {
                            $data = json_encode($response["response"]->data);
                            $data = json_decode($data, true);

                            get_instance()->session->updateSessionDB($data);
                        }
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, set_url('/panel'))->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }
            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        return $send;
    }


}