<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 24.09.2019
 * Time: 17:18
 */

namespace BonusCod;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $shop = array();

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\BonusCod\BonusCod*/
        $this->this_main = $this_main;
        $this->shop = &get_instance()->shop;
    }

    public function ajax_open_form(){


        $title = get_lang('bonus_cod.lang')['title_popup_lang'] . get_sid_name(false, true);

        $content = get_instance()->fenom->fetch(
            get_tpl_file('ajax_open_form.tpl', get_class($this->this_main)),
            array_merge(
                array(

                    'char_list' => get_instance()->session->getGameChars(),
                ),
                get_lang('bonus_cod.lang')
            )
        );

        $footer = '<div class="row justify-content-center">
                    <button type="submit" class="btn btn-alt-primary float-right submit-form"><i class="si si-action-redo mr-5"></i> '.get_lang('bonus_cod.lang')['title_popup_lang_btn'].'</button>
                   </div>';



        return get_instance()->ajaxmsg->popup($title, $content, $footer)->send();
    }

    public function ajax_get_bonus(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид магазина
            if (!isset($_REQUEST['cod']) OR empty($_REQUEST['cod']))
                return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_cod'])->danger();
            else
                $vars["cod"] = trim($_REQUEST['cod']);


            if (!isset($_REQUEST['select_recipient']))
                return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_cod'])->danger();
            else
                $vars["select_recipient"] = intval($_REQUEST['select_recipient']);

            if ($_REQUEST['select_recipient'] == '1') {
                //аккаунт
                if (!isset($_REQUEST['account_name']) OR empty($_REQUEST['account_name']))
                    return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
                else
                    $vars["account_name"] = $_REQUEST['account_name'];

                //персонаж
                if (!isset($_REQUEST['char_name']) OR empty($_REQUEST['char_name']))
                    return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
                else
                    $vars["char_name"] = $_REQUEST['char_name'];

            }


            $response = $api->get_bonus_cod($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {

                        if ($response["response"]->select_recipient){
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->eval_js('$(\'.select_recipient\').show();$(\'[name="select_recipient"]\').val(1);')->success();
                        }else{

                            if (isset($response["response"]->data)) {
                                $data = json_encode($response["response"]->data);
                                $data = json_decode($data, true);
                                get_instance()->session->updateSessionDB($data);
                                //->html($response["response"]->data->user_data->balance, '.balance_html')
                            }
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
                        }
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