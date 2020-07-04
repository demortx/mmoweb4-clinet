<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 23.09.2019
 * Time: 13:49
 */

namespace Settings;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;

    public $soc_network = array(
        1 => 'vkontakte',
        2 => 'mailru',
        3 => 'google',
        4 => 'facebook',
        5 => 'wargaming',
        6 => 'odnoklassniki',
        7 => 'twitter',
        8 => 'yandex',
        9 => 'steam',
        10 => "instagram",
        11 => "openid",
        12 => "soundcloud",
        13 => "googleplus",
        14 => "youtube",
        15 => "webmoney",
        16 => "liveid"

    );

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\Settings\Settings*/
        $this->this_main = $this_main;
    }

    public function widget_settings(){

        $render = array(
            'widget_confirm_email',
            'widget_bind_phone',
            'widget_reset_pin',
            'widget_social',
            'widget_telegram',
            'widget_change_password',
        );

        $content = '';
        foreach ($render as $row) {
            $content .= $this->$row();
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_settings.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'content' => $content,
                    'check_plugin_man_acc' => get_instance()->check_plugin('manager_account'),
                    'manager_content' => $this->widget_manager(),
                    'account_list_hide' => $this->account_list_hide(),
                ),
                get_lang('settings.lang')
            )
        );


    }

    public function widget_confirm_email(){


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_confirm_email.tpl', get_class($this->this_main)),
            get_lang('widget_confirm_email.lang')
        );


    }

    public function widget_bind_phone(){

        if (isset(get_instance()->config['cabinet']['signin_type']['phone'])) {
            return get_instance()->fenom->fetch(
                get_tpl_file('widget_bind_phone.tpl', get_class($this->this_main)),
                get_lang('widget_bind_phone.lang')
            );
        }else
            return '';

    }

    public function widget_telegram(){


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_telegram.tpl', get_class($this->this_main)),
            get_lang('widget_telegram.lang')
        );


    }

    public function widget_change_password(){


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_change_password.tpl', get_class($this->this_main)),
            get_lang('widget_change_password.lang')
        );


    }

    public function widget_reset_pin(){
        if (get_instance()->config['cabinet']['pin_shield'] == false){
            return '';
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_reset_pin.tpl', get_class($this->this_main)),
            get_lang('widget_reset_pin.lang')
        );


    }

    public function widget_social(){
        if (get_instance()->config['cabinet']['signin_social']) {

            if (is_array(get_instance()->config['cabinet']['signin_social_type'])) {

                foreach ($this->soc_network as $id => $soc_link){
                    if (!in_array($soc_link, get_instance()->config['cabinet']['signin_social_type']))
                        unset($this->soc_network[$id]);
                }

                $soc_list_temp = get_instance()->session->getSession()["user_data"]["social"];

                $soc_list = array();

                if (is_array($soc_list_temp) AND count($soc_list_temp) > 0) {
                    foreach ($soc_list_temp as $item) {
                        $soc_list[$this->soc_network[$item['type_soc']]] = $item;
                    }
                }
                unset($soc_list_temp);


                return get_instance()->fenom->fetch(
                    get_tpl_file('widget_social.tpl', get_class($this->this_main)),
                    array_merge(
                        array(
                            'social_list' => $this->soc_network,
                            'soc_list' => $soc_list,
                    ),
                        get_lang('widget_social.lang')
                    )
                );
            }
        }

    }

    public function widget_manager(){
        if (isset(get_instance()->config['cabinet']['manager_ma']) AND get_instance()->config['cabinet']['manager_ma'] AND get_instance()->check_plugin('manager_account')) {

            $manager_list = isset(get_instance()->session->getSession()["user_data"]["manager"]) ? get_instance()->session->getSession()["user_data"]["manager"] : array();

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_manager_ma.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'manager_list' => $manager_list
                    ),
                    get_lang('widget_manager.lang')
                )
            );
        }
        return '';
    }

    public function account_list_hide(){

        return get_instance()->fenom->fetch(
            get_tpl_file('account_list_hide.tpl', get_class($this->this_main)),
            get_lang('account_list_hide.lang')
        );

    }

    /* AJAX */

    public function ajax_change_password_account_open(){

        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();

        $account = $_REQUEST['account'];
        $title = get_lang('settings.lang')['title_change_password_account'] . $account;

        $content = get_instance()->fenom->fetch(
            get_tpl_file('ajax_change_password_account.tpl', get_class($this->this_main)),
            array_merge(
                array('account' => $account),
                get_lang('settings.lang')
            )
        );
        $footer = '<div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-save mr-5"></i> '.get_lang('settings.lang')['lang_button_change'].'
            </button>
        </div>';



        $send = get_instance()->ajaxmsg->popup($title, $content, $footer)->success();
        return $send;
    }

    public function ajax_change_password_account(){

        $api = new GlobalApi();
        $vars = array();

        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();
        else
            $vars['account'] = $_REQUEST['account'];

        if (!isset($_REQUEST['password_old']) OR empty($_REQUEST['password_old']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_old'])->danger();
        else
            $vars["password_old"] = $_REQUEST['password_old'];

        if (!isset($_REQUEST['password_new']) OR empty($_REQUEST['password_new']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new'])->danger();
        else
            $vars["password_new"] = $_REQUEST['password_new'];

        if (!isset($_REQUEST['password_new_confirm']) OR empty($_REQUEST['password_new_confirm']))
            return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new_confirm'])->danger();
        else
            $vars["password_new_confirm"] = $_REQUEST['password_new_confirm'];

        //Проверка пин кода
        if (get_instance()->config['cabinet']['pin_shield']) {
            if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
            else
                $vars["pin"] = $_REQUEST['pin'];
        }

        if (get_instance()->session->isLogin()) {

            $response = $api->change_password_account($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel')->success();
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

    public function ajax_forgot_password_account_open(){
        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();

        $account = $_REQUEST['account'];
        $title = get_lang('settings.lang')['title_forgot_password_account'] . $account;

        $content = get_instance()->fenom->fetch(
            get_tpl_file('ajax_forgot_password_account.tpl', get_class($this->this_main)),
            array_merge(
                array('account' => $account),
                get_lang('settings.lang')
            )
        );
        $footer = '<div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-save mr-5"></i> '.get_lang('settings.lang')['lang_button_forgot'].'
            </button>
        </div>';



        $send = get_instance()->ajaxmsg->popup($title, $content, $footer)->success();
        return $send;

    }

    public function ajax_forgot_password_account(){
        $api = new GlobalApi();
        $vars = array();

        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();
        else
            $vars['account'] = $_REQUEST['account'];


        //Проверка пин кода
        if (get_instance()->config['cabinet']['pin_shield']) {
            if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
            else
                $vars["pin"] = $_REQUEST['pin'];
        }


        if (get_instance()->session->isLogin()) {

            $response = $api->forgot_password_account($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {
                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel')->success();
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

    public function ajax_server_change(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['set_sid']) OR empty($_REQUEST['set_sid']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['signin_ajax_empty_sid'])->danger();
            else{
                $vars["sid"] = $_REQUEST['set_sid'];
                get_instance()->set_sid((int) $vars["sid"], false);
            }



            $response = $api->server_change($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel')->success();

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

    public function ajax_social_bind(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['token']) OR empty($_REQUEST['token']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['social_empty_token'])->danger();
            else
                $vars["token"] = $_REQUEST['token'];


            $vars['host'] = $_SERVER['HTTP_HOST'];

            $response = $api->social_bind($vars);


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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;
    }

    public function ajax_social_delete(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['delete']) OR empty($_REQUEST['delete']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['social_empty_token'])->danger();
            else
                $vars["delete"] = $_REQUEST['delete'];



            $response = $api->social_delete($vars);


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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_recovery_pin(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['type']) OR empty($_REQUEST['type']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_type'])->danger();
            else
                $vars["type"] = $_REQUEST['type'];



            $response = $api->recovery_pin($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
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

    public function ajax_pin_system(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            if (get_instance()->config['cabinet']['pin_shield'] == false) {
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_type'])->danger();
            }

            //Проверка сервера
            if (!isset($_REQUEST['enable']) OR empty($_REQUEST['enable']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_type'])->danger();
            else
                $vars["enable"] = $_REQUEST['enable'];


            if (!_boolean($vars["enable"]) AND get_instance()->session->checkShield()){
                //Пин не передан открываем попап с вводом пина
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];

            }


            $response = $api->pin_system($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {

                        if (isset($response["response"]->data->master_account)) {
                            $data = json_encode($response["response"]->data);
                            $data = json_decode($data, true);
                            get_instance()->session->updateSessionDB($data);
                        }

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();
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

    public function ajax_change_pwd_ma(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_REQUEST['password_old']) OR empty($_REQUEST['password_old']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_old'])->danger();
            else
                $vars["password_old"] = $_REQUEST['password_old'];

            if (!isset($_REQUEST['password_new']) OR empty($_REQUEST['password_new']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new'])->danger();
            else
                $vars["password_new"] = $_REQUEST['password_new'];

            if (!isset($_REQUEST['password_new_confirm']) OR empty($_REQUEST['password_new_confirm']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new_confirm'])->danger();
            else
                $vars["password_new_confirm"] = $_REQUEST['password_new_confirm'];
            //Проверка пин кода
            if (get_instance()->config['cabinet']['pin_shield']) {
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];
            }


            $response = $api->change_pwd_ma($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
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

    public function ajax_confirm_email_send_code(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            $vars['send'] = 1;

            $response = $api->confirm_email_send_code($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;
        //Отправка емаил письма с кодом

    }

    public function ajax_confirm_email(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['cod_confirm']) OR empty($_REQUEST['cod_confirm']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_confirm_email.lang')['empty_cod_confirm'])->danger();
            else
                $vars["cod_confirm"] = $_REQUEST['cod_confirm'];



            $response = $api->confirm_email($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_bind_telegram(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //Проверка сервера
            if (!isset($_REQUEST['type']) OR empty($_REQUEST['type']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_type'])->danger();
            else
                $vars["type"] = $_REQUEST['type'];

            if (get_instance()->config['cabinet']['pin_shield']) {
                //Проверка сервера
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];
            }

            if ($vars["type"] == 'enable'){
                //Проверка сервера
                if (!isset($_REQUEST['telegram']) OR empty($_REQUEST['telegram']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_confirm_email.lang')['empty_cod_confirm'])->danger();
                else
                    $vars["telegram"] = $_REQUEST['telegram'];
            }


            $response = $api->bind_telegram($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_bind_email_send_code(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //Проверка сервера
            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_confirm_email.lang')['empty_email'])->danger();
            else
                $vars["email"] = $_REQUEST['email'];

            if (get_instance()->config['cabinet']['pin_shield']) {
                //Проверка сервера
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];
            }


            $response = $api->bind_email_send_code($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->eval_js('show_enter_code_bind();')->success();
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

    public function ajax_bind_email()
    {

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['cod_confirm']) OR empty($_REQUEST['cod_confirm']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_confirm_email.lang')['empty_cod_confirm'])->danger();
            else
                $vars["cod_confirm"] = $_REQUEST['cod_confirm'];


            $response = $api->bind_email($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        } else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_bind_phone_send_code(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //Проверка телефона
            if (!isset($_REQUEST['phone']) OR empty($_REQUEST['phone']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone'])->danger();
            else
                $vars["phone"] = str_replace(array(' ', '-'), '', $_REQUEST['phone']);

            //Проверка телефона
            if (!isset($_REQUEST['phone_code']) OR empty($_REQUEST['phone_code']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone_code'])->danger();
            else
                $vars["phone_code"] = $_REQUEST['phone_code'];

            if (get_instance()->config['cabinet']['pin_shield']) {
                //Проверка сервера
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];
            }


            $response = $api->bind_phone_send_code($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->eval_js('show_enter_code_bind_phone();')->success();
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

    public function ajax_bind_phone()
    {

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['cod_confirm']) OR empty($_REQUEST['cod_confirm']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_confirm_email.lang')['empty_cod_confirm'])->danger();
            else
                $vars["cod_confirm"] = $_REQUEST['cod_confirm'];


            $response = $api->bind_phone($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['error_response_data'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        } else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_manager_change(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin() AND get_instance()->check_plugin('manager_account')) {


            //Проверка сервера
            if (!isset($_REQUEST['mid']) OR empty($_REQUEST['mid']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_mid'])->danger();
            else{
                $vars["mid"] = $_REQUEST['mid'];
            }

            $response = $api->manager_change($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {

                    if (isset($response["response"]->data->master_account)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel')->success();
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

    public function ajax_manager_delete(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin() AND get_instance()->check_plugin('manager_account')) {


            //Проверка сервера
            if (!isset($_REQUEST['mid']) OR empty($_REQUEST['mid']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_mid'])->danger();
            else{
                $vars["mid"] = $_REQUEST['mid'];
            }

            $response = $api->manager_delete($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {

                    if (isset($response["response"]->data->user_data->manager)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings#manager')->success();
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

    public function ajax_manager_add(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin() AND get_instance()->check_plugin('manager_account')) {


            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_email'])->danger();
            else
                $vars["email"] = $_REQUEST['email'];

            if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_password'])->danger();
            else
                $vars["password"] = $_REQUEST['password'];
            //Проверка пин кода
            if (get_instance()->config['cabinet']['pin_shield']) {
                if (!isset($_REQUEST['pin']) OR empty($_REQUEST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_REQUEST['pin'];
            }

            $response = $api->manager_add($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data->manager)) {
                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings#manager')->success();
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

    public function ajax_manager_confirm(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin() AND get_instance()->check_plugin('manager_account')) {


            if (!isset($_REQUEST['mid']) OR empty($_REQUEST['mid']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_mid'])->danger();
            else
                $vars["mid"] = $_REQUEST['mid'];

            if (!isset($_REQUEST['key']) OR empty($_REQUEST['key']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_manager.lang')['ajax_empty_key'])->danger();
            else
                $vars["key"] = $_REQUEST['key'];


            $response = $api->manager_confirm($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data->manager)) {
                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/settings#manager')->success();
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