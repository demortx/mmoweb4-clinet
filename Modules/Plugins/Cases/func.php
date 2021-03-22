<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace Cases;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $cases = array();


    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\Cases\Cases*/
        $this->this_main = $this_main;
        $this->cases = &get_instance()->cases;

    }

    public function widget_cases(){

        $this->set_label_new();
        $sid = get_instance()->get_sid();

        $category = array();
        if (isset($this->cases['category'][$sid]))
            $category = $this->cases['category'][$sid];

        $shop = false;
        if (isset($this->cases['shop'][$sid])) {
            $shop = $this->cases['shop'][$sid];
        }


        return get_instance()->fenom->fetch(
            get_tpl_file('cases.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'categorys' => $category,
                    'shops' => $shop,
                ),
                get_lang('cases.lang')
            )

        );
    }

    public function widget_cases_open(){

        $name_id = get_instance()->url->segment(3);

        if (strpos($name_id, '.') === false)
            return error_404_html();

        list( ,$item_id) = explode('.', $name_id);
        $item_id = intval($item_id);

        $sid = get_instance()->get_sid();

        if (isset($this->cases['shop'][$sid][$item_id]))
            $item = $this->cases['shop'][$sid][$item_id];
        else
            return error_404_html();


        if (is_array($item['items']) AND count($item['items'])){
            foreach ($item['items'] as &$i) {
                unset($i['chance']);
                unset($i['key']);
            }
        }

        $category = array();
        if (isset($this->cases['category'][$sid]))
            $category = $this->cases['category'][$sid];

        return get_instance()->fenom->fetch(
            get_tpl_file('cases_open.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'categorys' => $category,
                    'item' => $item,

                    'module_form' => 'Modules\\\\Plugins\\\\Cases\\\\Cases',
                    'module' => 'ajax_get_prize',
                ),
                get_lang('cases.lang')
            )

        );
    }

    public function ajax_get_prize(){

        $api = new GlobalApi();
        $vars = array('temp' => 0);

        if (get_instance()->session->isLogin()) {

            $sid = get_instance()->get_sid();

            if (!isset($_POST['cases_id']) OR empty($_POST['cases_id']))
                return get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger();
            else
                $vars['cases_id'] = (int) $_POST['cases_id'];

            if (!isset($this->cases['shop'][$sid][$vars['cases_id']]))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            $response = $api->cases_buy($vars);

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
                        header("Content-type: application/json");
                        $send =  json_encode(array(
                            'result'    => 'success', //success/error/warning/info
                            'balance'    => (float) $response["response"]->data->user_data->balance,
                            'item'    => array(
                                'name' => (string) $response["response"]->items->name,
                                'desc' => (string) $response["response"]->items->desc,
                                'img' => (string) $response["response"]->items->img,
                                'count' => (int) $response["response"]->items->count,
                                'enc' => (int) $response["response"]->items->enc,
                            ),
                        ));
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


    public function set_label_new(){
        $t = filemtime(ROOT_DIR.'/Library/cases.php');
        set_cookie('cases_new', $t, strtotime("+1 year"));
    }
}