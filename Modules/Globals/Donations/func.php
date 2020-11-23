<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 23.09.2019
 * Time: 13:49
 */

namespace Donations;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $advertising = false;

    public $payment_list = array(
        'freekassa',
        'g2a',
        'unitpay',
        'payu',
        'paypal',
        'payop',
        'paymentwall',
        'pagseguro',
        'nextpay',
        'paygol',
        'alikassa',
        'enot',

    );

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\Donations\Donations*/
        $this->this_main = $this_main;

        if ($this->advertising === false)
            $this->advertising = include ROOT_DIR . '/Library/advertising.php';

    }
    public function widget_donations_no_auth(){

        get_instance()->seo->addTeg('head', 'rangeslider_css', 'link', array('rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css'));
        get_instance()->seo->addTeg('footer', 'rangeslider', 'script', array('src' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js'));


        //Вычисление бонуса к выбронуму серверу
        $event_cfg = get_instance()->config['event'];
        $sid = get_instance()->get_sid();
        if (isset($event_cfg[$sid])){
            $event_cfg = $event_cfg[$sid];
            foreach ($event_cfg as &$event){
                if ($event['item_enable']){
                    $item_temp = array();
                    foreach ($event['item'] as $item){

                        $temp_item = set_item($item['id'], false, true);
                        $item['id'] = $temp_item['id'];
                        $item['name'] = $temp_item['name'];
                        $item['add_name'] = $temp_item['add_name'];
                        $item['icon'] = $temp_item['icon'];

                        $item_temp[$item['lv']][] = $item;
                    }
                    $event['item'] = $item_temp;
                }

            }
        }else
            $event_cfg = false;


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_donations_no_auth.tpl', get_class($this->this_main)),

            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'config_cabinet' => get_instance()->config['cabinet'],
                    'event_cfg' => $event_cfg,
                    'payment_list' => $this->payment_list,
                    get_lang('course.lang')

                ),
                get_lang('widget_donate.lang')
            )

        );


    }

    public function widget_donations(){

        get_instance()->seo->addTeg('head', 'rangeslider_css', 'link', array('rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css'));
        get_instance()->seo->addTeg('footer', 'rangeslider', 'script', array('src' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js'));


        //Вычисление бонуса к выбронуму серверу
        $event_cfg = get_instance()->config['event'];
        $sid = get_instance()->get_sid();
        if (isset($event_cfg[$sid])){
            $event_cfg = $event_cfg[$sid];
            foreach ($event_cfg as &$event){
                if ($event['item_enable']){
                    $item_temp = array();
                    foreach ($event['item'] as $item){

                        $temp_item = set_item($item['id'], false, true);
                        $item['id'] = $temp_item['id'];
                        $item['name'] = $temp_item['name'];
                        $item['add_name'] = $temp_item['add_name'];
                        $item['icon'] = $temp_item['icon'];

                        $item_temp[$item['lv']][] = $item;
                    }
                    $event['item'] = $item_temp;
                }

            }
        }else
            $event_cfg = false;


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_donations.tpl', get_class($this->this_main)),

            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'event_cfg' => $event_cfg,
                    'payment_list' => $this->payment_list,
                    get_lang('course.lang')

                ),
                get_lang('widget_donate.lang')
            )

        );


    }

    //AJAX
    public function ajax_checkout(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //Проверка сервера
            if (!isset($_REQUEST['sum']) OR empty($_REQUEST['sum']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_sum'])->danger();
            else
                $vars["sum"] = $_REQUEST['sum'];


            //Проверка сервера
            if (!isset($_REQUEST['payment_method']) OR empty($_REQUEST['payment_method']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger();
            else
                $vars["payment_method"] = $_REQUEST['payment_method'];

            if (isset($this->advertising['gawpid']) AND !empty($this->advertising['gawpid'])){
                if (isset($_COOKIE['_ga']) AND !empty($_COOKIE['_ga']))
                    $vars["_ga"] = $_COOKIE['_ga'];

                $vars["gaid"] = $this->advertising['gawpid'];
            }
            if (isset($this->advertising['ymid']) AND !empty($this->advertising['ymid'])) {
                if (isset($_COOKIE['_ym_uid']) AND !empty($_COOKIE['_ym_uid']))
                    $vars["_ym"] = $_COOKIE['_ym_uid'];

                $vars["ymid"] = $this->advertising['ymid'];
            }


            //Ставим флаг создания простого платежа
            $vars["type"] = 1;

            $response = $api->checkout($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {
                    if (isset($response["response"]->redirect)) {

                        if (isset($response["response"]->post) AND !empty($response["response"]->post) > 0)
                            $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                        else
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();

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

    public function ajax_checkout_no_auth()
    {

        $api = new GlobalApi();
        $vars = array();


        //Проверка сервера
        if (!isset($_REQUEST['sum']) OR empty($_REQUEST['sum']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_sum'])->danger();
        else
            $vars["sum"] = $_REQUEST['sum'];


        //Проверка сервера
        if (!isset($_REQUEST['payment_method']) OR empty($_REQUEST['payment_method']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger();
        else
            $vars["payment_method"] = $_REQUEST['payment_method'];

        //Проверка сервера
        if (!isset($_REQUEST['recipient']) OR empty($_REQUEST['recipient']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_recipient'])->danger();
        else
            $vars["recipient"] = $_REQUEST['recipient'];

        //Проверка сервера
        if (!isset($_REQUEST['type_id']) OR empty($_REQUEST['type_id']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_type_id'])->danger();
        else
            $vars["type_id"] = $_REQUEST['type_id'];

        if (isset($this->advertising['gawpid']) AND !empty($this->advertising['gawpid'])){
            if (isset($_COOKIE['_ga']) AND !empty($_COOKIE['_ga']))
                $vars["_ga"] = $_COOKIE['_ga'];

            $vars["gaid"] = $this->advertising['gawpid'];
        }
        if (isset($this->advertising['ymid']) AND !empty($this->advertising['ymid'])) {
            if (isset($_COOKIE['_ym_uid']) AND !empty($_COOKIE['_ym_uid']))
                $vars["_ym"] = $_COOKIE['_ym_uid'];

            $vars["ymid"] = $this->advertising['ymid'];
        }

        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_error_captcha'])->eval_js(captcha_reload('checkout'))->danger();


        //Ставим флаг создания простого платежа
        $vars["type"] = 2;

        $response = $api->checkout($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
            } else {
                if (isset($response["response"]->redirect)) {

                    if (isset($response["response"]->post) AND !empty($response["response"]->post) > 0)
                        $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                    else
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();

                } else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }


        return $send;

    }

    public function ajax_refresh_balance(){
        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->refresh_balance($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html((int) $response["response"]->data->user_data->balance, '.balance_html')->success();

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