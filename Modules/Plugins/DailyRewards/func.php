<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace DailyRewards;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $daily_rewards = array();


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\DailyRewards\DailyRewards*/
        $this->this_main = $this_main;
        $this->daily_rewards = &get_instance()->daily_rewards;

    }

    public function widget_daily_rewards(){

        $sid = get_instance()->get_sid();

        if (isset($this->daily_rewards[$sid]))
            $dr_list = $this->daily_rewards[$sid];
        else
            return '';

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_daily_rewards.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'daily_rewards_list' => $dr_list,
                ),
                get_lang('daily_rewards.lang')
            )

        );

    }

    public function give_daily_rewards(){

        $api = new GlobalApi();
        $vars = array('temp' => 0);

        if (get_instance()->session->isLogin()) {

            $sid = get_instance()->get_sid();

            if (!isset($_POST['day']) OR empty($_POST['day']))
                return get_instance()->ajaxmsg->notify(get_lang('daily_rewards.lang')['ajax_empty_day'])->danger();
            else
                $vars['day'] = (int) $_POST['day'];



            if (!isset($this->daily_rewards[$sid]))
                return get_instance()->ajaxmsg->notify(get_lang('daily_rewards.lang')['ajax_daily_rewards_disable'])->danger();


            if (!isset($this->daily_rewards[$sid]["rewards"][$vars['day']]))
                return get_instance()->ajaxmsg->notify(get_lang('daily_rewards.lang')['ajax_missing_day'])->danger();


            $response = $api->give_daily_rewards($vars);

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


                        $send = get_instance()->ajaxmsg->html('<i class="fa fa-check mr-5"></i>'.get_lang('daily_rewards.lang')['daily_received'], '#button_rewards')->notify((string)$response["response"]->success)->success();

                    }else
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