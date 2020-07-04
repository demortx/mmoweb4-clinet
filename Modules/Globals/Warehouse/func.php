<?php
namespace Warehouse;


use ApiLib\GlobalApi;

class func
{
    public $this_main;

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\Warehouse\Warehouse*/
        $this->this_main = $this_main;
    }

    public function widget_warehouse(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_warehouse.tpl', get_class($this->this_main)),
            get_lang('warehouse.lang')
        );

    }

    public function ajax_send_item(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид платежки
            if (!isset($_REQUEST['wh_id']) OR empty($_REQUEST['wh_id']))
                return get_instance()->ajaxmsg->notify(get_lang('warehouse.lang')['ajax_empty_wh_id'])->danger();
            else
                $vars["wh_id"] = intval($_REQUEST['wh_id']);

            //Количество покупаемых предметов
            if ((!isset($_REQUEST['wh_char_name']) OR empty($_REQUEST['wh_char_name'])) AND (!isset($_REQUEST['wh_char_name_out']) OR empty($_REQUEST['wh_char_name_out'])))
                return get_instance()->ajaxmsg->notify(get_lang('warehouse.lang')['ajax_empty_wh_char_name'])->danger();
            else {
                if (isset($_REQUEST['wh_account']))
                    $vars["wh_account"] = $_REQUEST['wh_account'];
                if (isset($_REQUEST['wh_char_name']))
                    $vars["wh_char_name"] = $_REQUEST['wh_char_name'];
                if (isset($_REQUEST['wh_char_name_out']))
                    $vars["wh_char_name_out"] = $_REQUEST['wh_char_name_out'];
            }

            $response = $api->give_item_warehouse($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->location('panel/warehouse', 2000)->success();

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