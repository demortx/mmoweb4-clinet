<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 23.09.2019
 * Time: 13:49
 */

namespace InGameCurrency;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\InGameCurrency\InGameCurrency*/
        $this->this_main = $this_main;
    }

    public function ajax_open_form(){
        $account_name = isset($_REQUEST['login']) ? $_REQUEST['login'] : false;
        $char_name = isset($_REQUEST['char']) ? $_REQUEST['char'] : false;



        $title = get_lang('ingame.lang')['title_popup_lang'] . get_sid_name(false, true);

        $content = get_instance()->fenom->fetch(
            get_tpl_file('ajax_open_form.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'select_account' => $account_name,
                    'select_char' => $char_name,

                    'char_list' => get_instance()->session->getGameChars(),
                ),
                get_lang('ingame.lang')
            )
        );

        $footer = '<div class="row">
                    <div class="col-6 p-1">
                        <div class="m-5">'.get_lang('ingame.lang')['title_popup_lang_price'].' <span id="out_price">0</span></div>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-alt-primary float-right submit-form"><i class="si si-action-redo mr-5"></i> '.get_lang('ingame.lang')['title_popup_lang_btn'].'</button>
                    </div></div>';



        $send = get_instance()->ajaxmsg->popup($title, $content, $footer)->success();
        return $send;


    }

    public function ajax_buy_in_game(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид платежки
            if (!isset($_REQUEST['type_id']) OR empty($_REQUEST['type_id']))
                return get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_type_id'])->danger();
            else
                $vars["type_id"] = intval($_REQUEST['type_id']);

            //Количество покупаемых предметов
            if (!isset($_REQUEST['count']) OR empty($_REQUEST['count']))
                return get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_count'])->danger();
            else
                $vars["count"] = intval($_REQUEST['count']);

            //аккаунт
            if (!isset($_REQUEST['account_name']) OR empty($_REQUEST['account_name']))
                return get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_account_name'])->danger();
            else
                $vars["account_name"] = $_REQUEST['account_name'];

            //персонаж
            if (isset($_REQUEST['char_name']) OR !empty($_REQUEST['char_name']))
                $vars["char_name"] = $_REQUEST['char_name'];



            $response = $api->buy_in_game_currency($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html($response["response"]->data->user_data->balance, '.balance_html')->success();

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