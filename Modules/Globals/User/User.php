<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\User;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;


class User extends MainModulesClass
{

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \User\func( $this );
        include_once ROOT_DIR.'/Library/aiondb.php';

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль пользователя',
                'en' => 'User module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "09.12.2019",
            "lastUpdated" => "09.12.2019",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'ajax_refresh_accounts' => function () { return $this->ajax_refresh_accounts(); },
            'ajax_refresh_warehouse' => function () { return $this->ajax_refresh_warehouse(); },
            'hide_game_account' => function () { return $this->ajax_hide_game_account(); },
            'show_game_account' => function () { return $this->ajax_show_game_account(); },

            'create_game_account_open' => function () { return $this->ajax_create_game_account_open(); },
            'create_game_account' => function () { return $this->ajax_create_game_account(); },

        );

    }

    public function renderWindow()
    {

        $content = array(

            '/panel' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'grid' => array(
                    array(
                        'class' => 'grid-item col-12 col-xl-8',
                        'level' => 3,
                        'widget_account_list' => function() { return $this->func->widget_account_list();},
                    ),


                ),
            ),

        );

        return $content;
        //return isset($content[$uri]) ? $content[$uri] : false;
    }

    /*
     * CODE
     */
    public function ajax_refresh_accounts()
    {
        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->refresh_accounts($vars);

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
                        get_instance()->session->rebootSession();


                        $send = get_instance()->ajaxmsg->html($this->func->fragment_account_list(), '#account_list_info')->notify((string)$response["response"]->success)->success();

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

    public function ajax_refresh_warehouse()
    {
        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->refresh_warehouse($vars);

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
                        get_instance()->session->rebootSession();


                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->eval_js('document.location.reload(true);')->success();

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


    public function ajax_hide_game_account(){
        $api = new GlobalApi();
        $vars = array();

        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();
        else
            $vars['account'] = $_REQUEST['account'];


        if (get_instance()->session->isLogin()) {

            $response = $api->hide_account($vars);

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
                        get_instance()->session->rebootSession();

                        $send = get_instance()->ajaxmsg->html($this->func->fragment_account_list(), '#account_list_info')->notify((string)$response["response"]->success)->success();

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

    public function ajax_show_game_account(){
        $api = new GlobalApi();
        $vars = array();

        if (!isset($_REQUEST['account']) OR empty($_REQUEST['account']))
            return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();
        else
            $vars['account'] = $_REQUEST['account'];


        if (get_instance()->session->isLogin()) {

            $response = $api->show_account($vars);

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
                        get_instance()->session->rebootSession();

                        $send = get_instance()->ajaxmsg->html($this->account_list_hide(), '#hide')->notify((string)$response["response"]->success)->success();

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

    public function account_list_hide(){

        return get_instance()->fenom->fetch(
            get_tpl_file('account_list_hide.tpl', 'Modules\Globals\Settings\Settings'),
            get_lang('account_list_hide.lang')
        );

    }


    public function ajax_create_game_account_open(){


        $title = get_lang('user.lang')['title_popup_lang'] . get_sid_name(false);

        if(get_instance()->config['cabinet']['registration_login_prefix']) {
            gen_prefix_tpl();
        }

        $content = get_instance()->fenom->fetch(
            get_tpl_file('ajax_create_game_account_open.tpl', get_class($this)),
            array_merge(
                array(
                    'prefix_list' => @$_SESSION['prefix_list'],
                ),
                get_lang('user.lang')
            )
        );
        $footer = '<div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-primary submit-form"><i class="fa fa-user-plus mr-5"></i> '.get_lang('user.lang')['lang_button_create_acc'].'
            </button>
        </div>';



        $send = get_instance()->ajaxmsg->popup($title, $content, $footer)->success();
        return $send;
    }

    public function ajax_create_game_account(){

        $api = new GlobalApi();
        $vars = array();

        $cfg = get_instance()->config['cabinet'];

        //Проверка префикса
        if ($cfg['registration_login_prefix'] AND !empty($_REQUEST['login'])) {
            if (isset($_REQUEST["prefix"]) AND isset($_SESSION["prefix_list"])) {
                if (in_array($_REQUEST["prefix"], $_SESSION['prefix_list']))
                    $vars['prefix'] = $_REQUEST["prefix"];
            }

            if (!isset($vars['prefix']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_prefix'])->danger();

        }

        //Проверка логина
        if (!isset($_REQUEST['login']) OR empty($_REQUEST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_login'])->danger();
        else
            $vars["login"] = $_REQUEST['login'];

        //Проверка Пароля
        if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_password'])->danger();
        else
            $vars["password"] = $_REQUEST['password'];

        $vars["utm"] = get_utm();

        if (get_instance()->session->isLogin()) {

            $response = $api->create_game_account($vars);

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
                        get_instance()->session->rebootSession();


                        $send = get_instance()->ajaxmsg->html($this->func->fragment_account_list(), '#account_list_info')->popup_close()->notify((string)$response["response"]->success)->success();

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