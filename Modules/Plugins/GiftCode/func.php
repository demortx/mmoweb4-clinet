<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace GiftCode;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $gift_code = array();


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\GiftCode\GiftCode*/
        $this->this_main = $this_main;
        $this->gift_code = &get_instance()->gift_code;

    }

    public function widget_gift_code(){
        $this->set_label_new();
        $sid = get_instance()->get_sid();

        if (isset($this->gift_code[$sid]['items'])){
            $items = $this->gift_code[$sid]['items'];
        }else
            $items = false;


        return get_instance()->fenom->fetch(
            get_tpl_file('gift_code.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'items' => $items,
                    'payment_system' => get_instance()->config['payment_system'],
                    'module_form' => 'Modules\\\\Plugins\\\\GiftCode\\\\GiftCode',
                    'module' => 'ajax_buy_gift',
                ),
                get_lang('gift_code.lang')
            )

        );

    }

    public function widget_gift_code_history(){
        return get_instance()->fenom->fetch(
            get_tpl_file('widget_gift_code_history.tpl', get_class($this->this_main)),
            get_lang('gift_code.lang')
        );
    }

    public function ajax_buy_gift(){

        $api = new GlobalApi();
        $vars = array('temp' => 0);

        if (get_instance()->session->isLogin()) {

            $sid = get_instance()->get_sid();

            if (!isset($this->gift_code[$sid]['items']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            if (!isset($this->gift_code[$sid]['items']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();

            if (!isset($_POST['id']) OR empty($_POST['id']))
                exit(get_instance()->ajaxmsg->notify(get_lang('gift_code.lang')['ajax_empty_id'])->danger());
            else
                $vars['id'] = (int) $_POST['id'];

            if (!isset($this->gift_code[$sid]['items'][(int)$_POST['id']]))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            $response = $api->gift_code_buy($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->location('panel/gift-code', 2000)->success();

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
        $t = filemtime(ROOT_DIR.'/Library/gift_code.php');
        set_cookie('gift_code_new', $t, strtotime("+1 year"));
    }
}