<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\SignIn;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;


class SignIn extends MainModulesClass
{

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль авторизации',
                'en' => 'Registration module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "24.05.2019",
            "lastUpdated" => "24.05.2019",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        return array(
            'signin' => function () {
                return $this->signin();
            },
            'signin_social' => function () {
                return $this->signin_social();
            },
        );

    }


    /*
     * CODE
     */

    public function signin()
    {

        $api = new GlobalApi();
        $vars = array();

        $vars['type'] = 'signin';


        if ($_REQUEST['type_login'] == 'phone'){
            $vars['type_login'] = 'phone';

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



        }else{
            $vars['type_login'] = 'email';

            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_email_phone'])->danger();
            else
                $vars["email"] = $_REQUEST['email'];

        }


        //Проверка Пароля
        if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_password'])->danger();
        else
            $vars["password"] = $_REQUEST['password'];

        //Проверка сервера
        if (!isset($_REQUEST['sid']) OR empty($_REQUEST['sid']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_sid'])->danger();
        else{
            $vars["sid"] = $_REQUEST['sid'];
            get_instance()->set_sid((int) $vars["sid"], false);
        }



        //подписка
        if (isset($_REQUEST["remember-me"]))
            $vars["remember-me"] = $_REQUEST["remember-me"];


        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_error_captcha'])->danger();
        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->signin($vars);



        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


            } else {

                if (isset($response["response"]->data->session_data)){

                    $data = json_encode($response["response"]->data);
                    $data = json_decode($data, true);
                    get_instance()->session->setSessionDB($data);
                    get_instance()->session->setSessionIdCookie(
                        $data['session_data']['session_id'],
                        $data['session_data']['session_end']
                    );

                    //выстовляем куки сервера сид
                    //выстовляем куки платформы


                    $send = get_instance()->ajaxmsg->notify( (string) $response["response"]->success, '/panel')->success();

                }else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        return $send;


    }


    public function signin_social()
    {
        $api = new GlobalApi();
        $vars = array();

        $vars['type'] = 'signin_social';


        if (!isset($_REQUEST['token']) OR empty($_REQUEST['token']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_email_phone'])->danger();
        else
            $vars["token"] = $_REQUEST['token'];


        $vars['host'] = $_SERVER['HTTP_HOST'];

        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->signin($vars);



        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

            } else {

                if (isset($response["response"]->data->session_data)){

                    $data = json_encode($response["response"]->data);
                    $data = json_decode($data, true);
                    get_instance()->session->setSessionDB($data);
                    get_instance()->session->setSessionIdCookie(
                        $data['session_data']['session_id'],
                        $data['session_data']['session_end']
                    );

                    $send = get_instance()->ajaxmsg->notify( (string) $response["response"]->success, '/panel')->success();

                }else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        return $send;
    }

}