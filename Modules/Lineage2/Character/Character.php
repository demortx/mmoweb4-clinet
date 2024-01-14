<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Lineage2\Character;

use ApiLib\GlobalApi;
use ApiLib\LineageApi;
use Modules\MainModulesClass;


class Character extends MainModulesClass
{
    public function __construct()
    {

        $this->mDir = dirname(__FILE__);


    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль персонажа и аккаунта',
                'en' => 'Character module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "30.11.2020",
            "lastUpdated" => "30.11.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'ajax_character_items' => function () { return $this->ajax_character_items(); },


            'ingame_teleport_char' => function () { return $this->ajax_ingame_teleport_char(); },
            'ingame_reset_hwid_char' => function () { return $this->ajax_ingame_reset_hwid_char(); },
            'ingame_reset_pin_char' => function () { return $this->ajax_ingame_reset_pin_char(); },
            'ingame_reset_pin_account' => function () { return $this->ajax_ingame_reset_pin_account(); },
            'ingame_reset_hwid_account' => function () { return $this->ajax_ingame_reset_hwid_account(); },
        );

    }

    public function renderWindow()
    {

        return array();
    }

    /*
     * CODE
     */
    public function ajax_character_items()
    {
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['account_name']) OR empty($_POST['account_name']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['account_name'];

        //персонаж
        if (!isset($_POST['char_name']) OR empty($_POST['char_name']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
        else
            $vars["char_name"] = $_POST['char_name'];


        $response = $api->character_items($vars);

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


        return $send;
    }
    public function ajax_ingame_teleport_char(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['login']) OR empty($_POST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['login'];

        //персонаж
        if (!isset($_POST['char']) OR empty($_POST['char']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
        else
            $vars["char_name"] = $_POST['char'];

        $response = $api->teleport_char($vars);

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


        return $send;

    }

    public function ajax_ingame_reset_hwid_char(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['login']) OR empty($_POST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['login'];

        //персонаж
        if (!isset($_POST['char']) OR empty($_POST['char']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
        else
            $vars["char_name"] = $_POST['char'];

        $response = $api->reset_hwid_char($vars);

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


        return $send;
    }
    public function ajax_ingame_reset_pin_char(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['login']) OR empty($_POST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['login'];

        //персонаж
        if (!isset($_POST['char']) OR empty($_POST['char']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
        else
            $vars["char_name"] = $_POST['char'];

        $response = $api->reset_pin_char($vars);

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


        return $send;
    }
    public function ajax_ingame_reset_pin_account(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['login']) OR empty($_POST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['login'];


        $response = $api->reset_pin_account($vars);

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


        return $send;
    }
    public function ajax_ingame_reset_hwid_account(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['login']) OR empty($_POST['login']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['login'];


        $response = $api->reset_hwid_account($vars);

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


        return $send;
    }

}