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
            if ($cfg['registration_login_optional'] == false AND (!isset($_POST['login']) OR empty($_POST['login'])))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_login'])->danger();


            if (isset($_POST['login']) AND !empty($_POST['login'])) {
                $vars["login"] = $_POST['login'];

                //Проверка префикса
                if ($cfg['registration_login_prefix']) {
                    if (isset($_POST["prefix"]) AND isset($_SESSION["prefix_list"])) {
                        if (in_array($_POST["prefix"], $_SESSION['prefix_list']))
                            $vars['prefix'] = $_POST["prefix"];
                    }

                    if (!isset($vars['prefix']))
                        return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_prefix'])->danger();

                }


                //Проверка сервера
                if (!isset($_POST['sid']) OR empty($_POST['sid']))
                    return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sid'])->danger();
                else {
                    if (checkSID((int)$_POST['sid'])) {
                        $vars["sid"] = (int)$_POST['sid'];
                        get_instance()->set_sid((int)$vars["sid"], false);
                    } else
                        return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_missing_sid'])->danger();
                }
            }

        }

        //Проверка Пароля
        if (!isset($_POST['password']) OR empty($_POST['password']))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_password'])->danger();
        else
            $vars["password"] = $_POST['password'];


        //Регистрация по почте
        if (isset($cfg['registration_type']['email']) AND $_POST["type_reg"] == '#r-email') {

            $vars['type'] = 'email';

            //Проверка Почты
            if (!isset($_POST['email']) OR empty($_POST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_email'])->danger();
            else
                $vars["email"] = $_POST['email'];

        //Регистрация через телефон
        } elseif (isset($cfg['registration_type']['phone']) AND $_POST["type_reg"] == '#r-phone') {

            $vars['type'] = 'phone';

            //Проверка телефона
            if (!isset($_POST['phone']) OR empty($_POST['phone']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone'])->danger();
            else
                $vars["phone"] = clean_phone($_POST["phone"]);

            //Проверка телефона
            if (!isset($_POST['phone_code']) OR empty($_POST['phone_code']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone_code'])->danger();
            else
                $vars["phone_code"] = $_POST['phone_code'];

            //Проверка телефона
            if (!isset($_POST['sms_cod']) OR empty($_POST['sms_cod']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sms_cod'])->danger();
            else
                $vars["sms_cod"] = $_POST['sms_cod'];


            //Проверка Почты
            if (isset($_POST['email-phone']) OR !empty($_POST['email-phone']))
                $vars["email"] = $_POST['email-phone'];



        } else
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_type_reg'])->danger();


        //Проверка правил
        if (!isset($_POST["terms"]))
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_terms'])->danger();
        else
            $vars["terms"] = $_POST["terms"];

        //подписка
        if (isset($_POST["subscribe"]))
            $vars["subscribe"] = $_POST["subscribe"];

        if (isset($_SESSION['promo_game']['status']) AND $_SESSION['promo_game']['status'] == 'finish')
            $vars["promo_game"] = $_SESSION['promo_game'];


        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_error_captcha'])->eval_js(captcha_reload('sign_up'))->danger();
        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->signup($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->eval_js(captcha_reload('sign_up'))->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->eval_js(captcha_reload('sign_up'))->danger();


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
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->eval_js(captcha_reload('sign_up'))->danger();
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
            $vars["phone_code"] = isset($_POST["phone_code"]) ? intval($_POST["phone_code"]) : 0;
            $vars["phone"] = isset($_POST["phone"]) ? intval(clean_phone($_POST["phone"])) : 0;

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