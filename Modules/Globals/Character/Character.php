<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Globals\Character;

use ApiLib\GlobalApi;
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
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Модуль персонажа',
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
        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        $vars['account'] = '';
        $vars['char_name'] = '';



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


}