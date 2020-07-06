<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\SignUp;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;


class SignUp extends MainModulesClass
{

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль регистрации',
                'en' => 'Registration module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "05.03.2019",
            "lastUpdated" => "05.03.2019",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'signup' => function () {
                return $this->signup();
            },
            'send_sms' => function () {
                return $this->send_sms();
            },
        );

    }


    /*
     * CODE
     */

    public function signup()
    {

        $api = new GlobalApi();
        $vars = array();

        $cfg = get_instance()->config['cabinet'];

        if ($cfg['registration_login']) {

            //Проверка логина
            if ($cfg['registration_login_optional'] == false AND (!isset($_REQUEST['login']) OR empty($_REQUEST['login'])))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_login'])->danger();


            if (isset($_REQUEST['login']) AND !empty($_REQUEST['login'])) {
                $vars["login"] = $_REQUEST['login'];

                //Проверка префикса
                if ($cfg['registration_login_prefix']) {
                    if (isset($_REQUEST["prefix"]) AND isset($_SESSION["prefix_list"])) {
                        if (in_array($_REQUEST["prefix"], $_SESSION['prefix_list']))
                            $vars['prefix'] = $_REQUEST["prefix"];
                    }

                    if (!isset($vars['prefix']))
                        return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_prefix'])->danger();

                }


                //Проверка сервера
                if (!isset($_REQUEST['sid']) OR empty($_REQUEST['sid']))
                    return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sid'])->danger();
                else {
                    if (checkSID((int)$_REQUEST['sid'])) {
                        $vars["sid"] = (int)$_REQUEST['sid'];
                        get_instance()->set_sid((int)$vars["sid"], false);
                    } else
                        return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_missing_sid'])->danger();
                }
            }

        }

        //Проверка Пароля
        if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_password'])->danger();
        else
            $vars["password"] = $_REQUEST['password'];


        //Регистрация по почте
        if (isset($cfg['registration_type']['email']) AND $_REQUEST["type_reg"] == '#r-email') {

            $vars['type'] = 'email';

            //Проверка Почты
            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_email'])->danger();
            else
                $vars["email"] = $_REQUEST['email'];

        //Регистрация через телефон
        } elseif (isset($cfg['registration_type']['phone']) AND $_REQUEST["type_reg"] == '#r-phone') {

            $vars['type'] = 'phone';

            //Проверка телефона
            if (!isset($_REQUEST['phone']) OR empty($_REQUEST['phone']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone'])->danger();
            else
                $vars["phone"] = $_REQUEST['phone'];

            //Проверка телефона
            if (!isset($_REQUEST['phone_code']) OR empty($_REQUEST['phone_code']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone_code'])->danger();
            else
                $vars["phone_code"] = $_REQUEST['phone_code'];

            //Проверка телефона
            if (!isset($_REQUEST['sms_cod']) OR empty($_REQUEST['sms_cod']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sms_cod'])->danger();
            else
                $vars["sms_cod"] = $_REQUEST['sms_cod'];


            //Проверка Почты
            if (isset($_REQUEST['email-phone']) OR !empty($_REQUEST['email-phone']))
                $vars["email"] = $_REQUEST['email-phone'];



        } else
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_type_reg'])->danger();


        //Проверка правил
        if (!isset($_REQUEST["terms"]))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_terms'])->danger();
        else
            $vars["terms"] = $_REQUEST["terms"];

        //подписка
        if (isset($_REQUEST["subscribe"]))
            $vars["subscribe"] = $_REQUEST["subscribe"];


        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_error_captcha'])->danger();
        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->signup($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


            } else {


                unset($_SESSION['signup']);

                if (isset($response["response"]->login) AND !empty($response["response"]->login)) {
                    $_SESSION['signup']['login'] = (string)$response["response"]->login;
                    if (isset($response["response"]->prefix) AND !empty($response["response"]->prefix))
                        $_SESSION['signup']['prefix'] = (string)$response["response"]->prefix;
                }

                if (isset($response["response"]->password) AND !empty($response["response"]->password))
                    $_SESSION['signup']['password'] = (string)$response["response"]->password;
                if (isset($response["response"]->email) AND !empty($response["response"]->email))
                    $_SESSION['signup']['email'] = (string)$response["response"]->email;
                if (isset($response["response"]->phone) AND !empty($response["response"]->phone))
                    $_SESSION['signup']['phone'] = (string)$response["response"]->phone;
                if (isset($response["response"]->subscribe) AND !empty($response["response"]->subscribe))
                    $_SESSION['signup']['subscribe'] = (string)$response["response"]->subscribe;
                if (isset($response["response"]->pin) AND (int)$response["response"]->pin > 0)
                    $_SESSION['signup']['pin'] = (int)$response["response"]->pin;



                if ((string)$response["response"]->register_activation == 'true') {
                    $send = get_instance()->ajaxmsg->notify($response["response"]->success, '/sign-up/activation', 'fa fa-clock-o')->success();
                } else {
                    $send = get_instance()->ajaxmsg->notify($response["response"]->success, '/sign-up/completed', 'fa fa-check')->success();
                }

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        return $send;


    }


    public function send_sms()
    {
        $cfg = get_instance()->config['cabinet'];

        if (isset($cfg['registration_type']['phone'])) {

            $api = new GlobalApi();
            $vars = array();
            $vars["type"] = 'sms';
            $vars["phone_code"] = isset($_REQUEST["phone_code"]) ? intval($_REQUEST["phone_code"]) : 0;
            $vars["phone"] = isset($_REQUEST["phone"]) ? intval($_REQUEST["phone"]) : 0;

            if ($vars["phone_code"] < 1)
                $send = get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_sms_phone_code_empty'])->danger();
            elseif ($vars["phone"] < 1)
                $send = get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_sms_phone_empty'])->danger();
            else {

                $response = $api->signup($vars);

                if ($response['ok']) {
                    if (isset($response['error'])) {
                        if (isset($response["response"]->input))
                            $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                        else
                            $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                    } else
                        $send = get_instance()->ajaxmsg->notify($response["response"]->success)->success();

                } else
                    $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        } else
            $send = get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_sms_disable'])->danger();


        return $send;
    }

}