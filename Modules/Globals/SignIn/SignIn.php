<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
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
            "author" => "mmoweb",
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


        if ($_POST['type_login'] == 'phone'){

            //Проверка телефона
            if (!isset($_POST['phone']) OR empty($_POST['phone']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone'])->danger();
            else
                $vars["phone"] = str_replace(array(' ', '-'), '', $_POST['phone']);

            //Проверка телефона
            if (!isset($_POST['phone_code']) OR empty($_POST['phone_code']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone_code'])->danger();
            else
                $vars["phone_code"] = $_POST['phone_code'];

            $vars['type_login'] = 'phone';

        }else{

            if (!isset($_POST['email']) OR empty($_POST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_email_phone'])->danger();


            if (preg_match("/.+@.+\..+/i", $_POST['email'])) {
                $vars["email"] = $_POST['email'];
                $vars['type_login'] = 'email';
            }else{
                $vars["login"] = $_POST['email'];
                $vars['type_login'] = 'login';
                $vars['type'] = 'signin_ig_login';
            }

        }



        if (!array_key_exists($vars['type_login'], get_instance()->config['cabinet']['signin_type']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error_type'])->danger();


        //Проверка Пароля
        if (!isset($_POST['password']) OR empty($_POST['password']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_password'])->danger();
        else
            $vars["password"] = $_POST['password'];

        //Проверка сервера
        if (!isset($_POST['sid']) OR empty($_POST['sid']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_sid'])->danger();
        else{
            $vars["sid"] = $_POST['sid'];
            get_instance()->set_sid((int) $vars["sid"], false);
        }



        //подписка
        if (isset($_POST["remember-me"]))
            $vars["remember-me"] = $_POST["remember-me"];

        if (isset($_SESSION['promo_game']['status']) AND $_SESSION['promo_game']['status'] == 'finish')
            $vars["promo_game"] = $_SESSION['promo_game'];

        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_error_captcha'])->eval_js(captcha_reload('sign_in'))->danger();
        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->signin($vars);



        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->eval_js(captcha_reload('sign_in'))->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->eval_js(captcha_reload('sign_in'))->danger();


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
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->eval_js(captcha_reload('sign_in'))->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->eval_js(captcha_reload('sign_in'))->danger();
        }

        return $send;


    }


    public function signin_social()
    {
        $api = new GlobalApi();
        $vars = array();

        $vars['type'] = 'signin_social';


        if (!isset($_POST['token']) OR empty($_POST['token']))
            return get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_email_phone'])->danger();
        else
            $vars["token"] = $_POST['token'];


        $vars['host'] = $_SERVER['HTTP_HOST'];

        if (isset($_SESSION['promo_game']['status']) AND $_SESSION['promo_game']['status'] == 'finish')
            $vars["promo_game"] = $_SESSION['promo_game'];

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