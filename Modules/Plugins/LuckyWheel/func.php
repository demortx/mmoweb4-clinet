<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace LuckyWheel;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $lucky_wheel = array();


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\LuckyWheel\LuckyWheel*/
        $this->this_main = $this_main;
        $this->lucky_wheel = &get_instance()->lucky_wheel;

    }

    public function widget_lucky_wheel(){
        $this->set_label_new();
        $sid = get_instance()->get_sid();

        $price = 1;
        if (isset($this->lucky_wheel[$sid]['items'])){
            $items = array_values($this->lucky_wheel[$sid]['items']);
            $price = floatval($this->lucky_wheel[$sid]['price']);
        }else
            $items = false;


        if (is_array($items) AND count($items)){
            foreach ($items as &$i) {
               unset($i['chance']);
            }
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('lucky_wheel.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'items' => $items,
                    'price' => $price,

                    'module_form' => 'Modules\\\\Plugins\\\\LuckyWheel\\\\LuckyWheel',
                    'module' => 'ajax_get_prize',
                ),
                get_lang('lucky_wheel.lang')
            )

        );

    }

    public function ajax_get_prize(){

        $api = new GlobalApi();
        $vars = array('temp' => 0);

        if (get_instance()->session->isLogin()) {

            $sid = get_instance()->get_sid();

            if (!isset($this->lucky_wheel[$sid]['items']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            $response = $api->lucky_wheel_buy($vars);

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
                        header("Content-type: application/json");
                        $send =  json_encode(array(
                            'result'    => 'success', //success/error/warning/info
                            'balance'    => (float) $response["response"]->data->user_data->balance,
                            'count'    => round($response["response"]->data->user_data->balance / $this->lucky_wheel[$sid]['price']),
                            'item'    => array(
                                'name' => (string) $response["response"]->items->name,
                                'desc' => (string) $response["response"]->items->desc,
                                'img' => (string) $response["response"]->items->img,
                                'count' => (int) $response["response"]->items->count,
                                'enc' => (int) $response["response"]->items->enc,
                            ),
                        ));
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

    public function ajax_get_history(){

        $api = new GlobalApi();
        $vars = array('temp' => 0);

        if (get_instance()->session->isLogin()) {

            $sid = get_instance()->get_sid();

            if (!isset($this->lucky_wheel[$sid]['items']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            $response = $api->lucky_wheel_history($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {

                        $items = json_encode($response["response"]->items);
                        $items = json_decode($items, true);
                        $html = get_instance()->fenom->fetch(
                            get_tpl_file('history.tpl', get_class($this->this_main)),
                            array_merge(
                                array(
                                    'items' => $items,
                                ),
                                get_lang('shop.lang')
                            )

                        );

                        $send = get_instance()->ajaxmsg->html($html, '.history_loud')->success();

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






    public function set_label_new(){
        $t = filemtime(ROOT_DIR.'/Library/lucky_wheel.php');
        set_cookie('lucky_wheel_new', $t, strtotime("+1 year"));
    }
}