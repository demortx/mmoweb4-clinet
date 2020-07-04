<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 15.10.2019
 * Time: 16:23
 */

namespace Modules\Globals\Reminder;

use ApiLib\GlobalApi;
use Modules\MainModulesClass;

class Reminder extends MainModulesClass
{

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль восстановления пароля',
                'en' => 'Password recovery module',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "15.10.2019",
            "lastUpdated" => "15.10.2019",
            "class" => __CLASS__,

        );
    }


    public function onAjax()
    {

        return array(
            'reminder' => function () { return $this->ajax_reminder(); },
            'reminder_sms' => function () { return $this->ajax_reminder_sms(); },
            'reminder_change' => function () { return $this->ajax_reminder_change (); },
        );

    }

    public function ajax_reminder(){

        $api = new GlobalApi();
        $vars = array();

        $cfg = get_instance()->config['cabinet'];

        //Востоновление через почту
        if (isset($cfg['reminder_type']['email']) AND $_REQUEST["type_reminder"] == '#r-email') {

            $vars['type'] = 'email';

            //Проверка Почты
            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_email'])->danger();
            else
                $vars["email"] = $_REQUEST['email'];

            //Востоновление через телефон
        } elseif (isset($cfg['reminder_type']['phone']) AND $_REQUEST["type_reminder"] == '#r-phone') {

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


        } else
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_type_reg'])->danger();



        if (!captcha_check())
            return get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_error_captcha'])->danger();
        //Передаем UTM метки
        $vars["utm"] = get_utm();

        $response = $api->reminder($vars);



        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

            } else {

                //куда переноправить
                if ($vars['type'] == 'email')
                    $url = '/reminder/email';
                else
                    $url = '/reminder/phone';

                $send = get_instance()->ajaxmsg->notify($response["response"]->success, $url, 'fa fa-clock-o')->success();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        return $send;


    }

    public function ajax_reminder_sms(){

        $cfg = get_instance()->config['cabinet'];

        if (isset($cfg['reminder_type']['phone'])) {

            $api = new GlobalApi();
            $vars = array();
            $vars["type"] = 'sms';
            $vars["phone_code"] = intval($_REQUEST["phone_code"]);
            $vars["phone"] = intval($_REQUEST["phone"]);

            if ($vars["phone_code"] < 1)
                $send = get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_sms_phone_code_empty'])->danger();
            elseif ($vars["phone"] < 1)
                $send = get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_sms_phone_empty'])->danger();
            else {

                $response = $api->reminder($vars);

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
            $send = get_instance()->ajaxmsg->notify(get_lang('reminder.lang')['reminder_ajax_sms_disable'])->danger();


        return $send;

    }

    public function ajax_reminder_change(){

        $cfg = get_instance()->config['cabinet'];


        if (isset($cfg['reminder_type']['email'])) {

            $vars = array();

            //Проверка code
            if (!isset($_REQUEST['code']) OR empty($_REQUEST['code']) OR !preg_match("/^([A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4})$/", $_REQUEST['code']))
                return get_instance()->ajaxmsg->notify(get_lang('reminder.lang')['reminder_ajax_empty_code'])->danger();
            else
                $vars["code"] = $_REQUEST['code'];

            //Проверка password
            if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
                return get_instance()->ajaxmsg->notify(get_lang('reminder.lang')['reminder_ajax_empty_password'])->danger();
            else
                $vars["password"] = $_REQUEST['password'];



            $vars["type"] = 'code';

            $api = new GlobalApi();
            $response = $api->reminder($vars);

            if ($response['ok']) {
                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else
                    $send = get_instance()->ajaxmsg->notify($response["response"]->success, '/sign-in')->success();

            } else
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();


        } else
            $send = get_instance()->ajaxmsg->notify(get_lang('reminder.lang')['reminder_ajax_email_disable'])->danger();


        return $send;

    }
}