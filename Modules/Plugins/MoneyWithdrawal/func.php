<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */
namespace MoneyWithdrawal;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $money_withdrawal = array();


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\MoneyWithdrawal\MoneyWithdrawal*/
        $this->this_main = $this_main;
        $this->money_withdrawal = &get_instance()->money_withdrawal;

    }

    public function widget_withdrawal(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_withdrawal.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'money_withdrawal' => $this->money_withdrawal,
                    'payment_system' => get_instance()->config['payment_system'],
                ),
                get_lang('withdrawal.lang')
            )
        );

    }

    public function widget_log_transfer(){

        if (!get_instance()->session->isLogin()){
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }

        $api = new GlobalApi();
        $vars = array('temp' => 0);
        $response = $api->withdrawal_log($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/withdrawal');
                else
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/withdrawal');

            } else {
                if (isset($response["response"]->success)) {
                    $items = json_encode($response["response"]);
                    $items = json_decode($items, true);
                    // 0 - создана,
                    // 1 - подтверждена,
                    // 2 - отклонена средства возвращены на баланс рынка,
                    // 3 - отклонена средства изъяты

                    return get_instance()->fenom->fetch(
                        get_tpl_file('widget_log_transfer.tpl', get_class($this->this_main)),
                        array_merge(
                            array(
                                'count_log' => $items['success'],
                                'log_list' => $items['log'],
                                'status' => [
                                    0 => get_lang('withdrawal.lang')['created'],
                                    1 => get_lang('withdrawal.lang')['accepted'],
                                    2 => get_lang('withdrawal.lang')['rejected_refunded'],
                                    3 => get_lang('withdrawal.lang')['rejected_not_refunded']
                                ],
                                'money_withdrawal' => $this->money_withdrawal,
                            ),
                            get_lang('withdrawal.lang')
                        )
                    );


                } else{
                    header('Location: '.set_url('/sign-in', false), TRUE, 301);
                    die;
                }


            }

        } else {
            return error_404_html(200, 'Oops.. You just found an error page..', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'], '/panel/market');
        }

    }

    public function widget_withdrawal_item(){

        $name_id = intval(get_instance()->url->segment(3));

        $api = new GlobalApi();
        $vars = array('id' => $name_id);
        $response = $api->withdrawal_log($vars);

        if ($response['ok'])
        {
            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/withdrawal');
                else
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/withdrawal');

            } else {
                if (isset($response["response"]->success)) {
                    return get_instance()->fenom->fetch(
                        get_tpl_file('widget_withdrawal_item.tpl', get_class($this->this_main)),
                        array_merge(
                            array(
                                'log_list' => (array)$response['response']->log,
                                'status' => [
                                    0 => get_lang('withdrawal.lang')['created'],
                                    1 => get_lang('withdrawal.lang')['accepted'],
                                    2 => get_lang('withdrawal.lang')['rejected_refunded'],
                                    3 => get_lang('withdrawal.lang')['rejected_not_refunded']
                                ],
                                'money_withdrawal' => $this->money_withdrawal,
                            ),
                            get_lang('market.lang')
                        )
                    );
                }
                else
                {
                    header('Location: '.set_url('/sign-in', false), TRUE, 301);
                    die;
                }
            }
        }
        else
        {
            return error_404_html(200, 'Oops.. You just found an error page..', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'], '/panel/market');
        }
    }

    public function ajax_withdrawal(){
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_POST['delivery_method']) or empty($_POST['delivery_method']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_delivery_method'])->danger();
            else
                $vars["delivery_method"] = $_POST['delivery_method'];

            if ($vars["delivery_method"] == 'card'){

                if (!isset($_POST['reg_name']) or empty($_POST['reg_name']))
                    return get_instance()->ajaxmsg->notify(get_lang('withdrawal.lang')['ajax_empty_reg_name'])->danger();
                else
                    $vars["reg_name"] = $_POST['reg_name'];

                if (!isset($_POST['reg_name_f']) or empty($_POST['reg_name_f']))
                    return get_instance()->ajaxmsg->notify(get_lang('withdrawals.lang')['ajax_empty_reg_name_f'])->danger();
                else
                    $vars["reg_name_f"] = $_POST['reg_name_f'];

            }



            if (!isset($_POST['wallet']) or empty($_POST['wallet']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_wallet'])->danger();
            else
                $vars["wallet"] = $_POST['wallet'];

            if (!isset($_POST['withdrawal_sum']) OR empty($_POST['withdrawal_sum']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_sum'])->danger();
            else
                $vars["withdrawal_sum"] = $_POST['withdrawal_sum'];



            if (check_pin("pins_market_withdrawal")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }




            $api = new GlobalApi();
            $response = $api->withdrawal($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {


                        if (isset($response["response"]->data->user_data)) {
                            $data = json_encode($response["response"]->data);
                            $data = json_decode($data, true);
                            get_instance()->session->updateSessionDB($data);
                        }

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/withdrawal')->success();
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