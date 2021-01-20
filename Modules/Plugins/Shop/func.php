<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace Shop;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $shop = array();
    //Language/support.lang.php
    public $payment_list = array(
        'freekassa',
        'g2a',
        'unitpay',
        'payu',
        'paypal',
        'payop',
        'paymentwall',
        'pagseguro',
        'nextpay',
        'paygol',
        'alikassa',
        'enot',
        'ipay',
        'paysafecard',
        'ips_payment',
        'digiseller',
    );
    public $advertising = false;

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\Shop\Shop*/
        $this->this_main = $this_main;
        $this->shop = &get_instance()->shop;

        if ($this->advertising === false)
            $this->advertising = include ROOT_DIR . '/Library/advertising.php';

        if (isset(get_instance()->config['payment_system']['sorting_pay']))
            $this->payment_list = get_instance()->config['payment_system']['sorting_pay'];
    }


    public function widget_shop_no_auth(){

        $this->set_label_new();
        $sid = get_instance()->get_sid();

        $category = array();
        if (isset($this->shop['category'][$sid]))
            $category = $this->shop['category'][$sid];

        $shop = array();
        if (isset($this->shop['shop'][$sid])) {
            $shop = $this->shop['shop'][$sid];
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('shop_list_no_auth.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'categorys' => $category,
                    'shops' => $shop,
                ),
                get_lang('shop.lang')
            )

        );

    }

    public function widget_item_no_auth($name_id)
    {

        if (strpos($name_id, '.') === false)
            return error_404_html();

        list(, $item_id) = explode('.', $name_id);
        $item_id = intval($item_id);

        $sid = get_instance()->get_sid();


        if (isset($this->shop['shop'][$sid][$item_id]))
            $item = $this->shop['shop'][$sid][$item_id];
        else
            return error_404_html();


        $category = array();
        if (isset($this->shop['category'][$sid]))
            $category = $this->shop['category'][$sid];

        if ($item['type'] == 'shop') {

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_item_no_auth.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'payment_system' => get_instance()->config['payment_system'],
                        'payment_list' => $this->payment_list,
                        'categorys' => $category,
                        'item' => $item,
                    ),
                    get_lang('shop.lang'),
                    get_lang('course.lang')
                )

            );

        }else if(isset($item['type'])){

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_service_no_auth.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'payment_system' => get_instance()->config['payment_system'],
                        'categorys' => $category,
                        'item' => $item,
                        'tpl_enrollment' => $item['type']
                    ),
                    get_lang('shop.lang')
                )

            );
        }else
            return error_404_html();
    }

    public function ajax_checkout_shop_no_auth(){
        $api = new GlobalApi();
        $vars = array();

        //ид магазина
        if (!isset($_POST['shop_id']) OR empty($_POST['shop_id']))
            return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
        else
            $vars["shop_id"] = intval($_POST['shop_id']);
        //ид магазина
        if (!isset($_POST['payment_method']) OR empty($_POST['payment_method']))
            return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_payment_method'])->danger();
        else
            $vars["payment_method"] = $_POST['payment_method'];

        //тип доставки
        if (!isset($_POST['type_buy']) OR empty($_POST['type_buy']))
            return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_type_buy'])->danger();
        else{

            if($_POST['type_buy'] == '#nick-name') { // Передать на персонажа по нику
                $vars["type_buy"] = 'nick_name';

                if (!isset($_POST['nick_name']) OR empty($_POST['nick_name']))
                    return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_nick_name'])->danger();
                else
                    $vars["nick_name"] = $_POST['nick_name'];

            }else { //Доставить на склад МА
                $vars["type_buy"] = 'warehouse';

                if (!isset($_POST['email']) OR empty($_POST['email']))
                    return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_email'])->danger();
                else
                    $vars["email"] = $_POST['email'];
            }
        }

        $sid = get_instance()->get_sid();

        if (!isset($this->shop['shop'][$sid][$vars["shop_id"]]))
            return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();
        else
            $shop = $this->shop['shop'][$sid][$vars["shop_id"]];

        if ($shop["complect"] == 0){
            if (!isset($_POST['items']) OR empty($_POST['items']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_items'])->danger();
            else
                $vars["items"] = $_POST['items'];

            $vars["complect"] = $shop["complect"];
        }

        //Ставим флаг создания простого платежа
        $vars["type"] = 3;

        if (isset($this->advertising['gawpid']) AND !empty($this->advertising['gawpid'])){
            if (isset($_COOKIE['_ga']) AND !empty($_COOKIE['_ga']))
                $vars["_ga"] = $_COOKIE['_ga'];

            $vars["gaid"] = $this->advertising['gawpid'];
        }
        if (isset($this->advertising['ymid']) AND !empty($this->advertising['ymid'])) {
            if (isset($_COOKIE['_ym_uid']) AND !empty($_COOKIE['_ym_uid']))
                $vars["_ym"] = $_COOKIE['_ym_uid'];

            $vars["ymid"] = $this->advertising['ymid'];
        }

        $response = $api->checkout($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
            } else {
                if (isset($response["response"]->redirect)) {
                    $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                } else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }


        return $send;
    }


    public function widget_shop_advertising(){
        $sid = get_instance()->get_sid();

        $category = array();
        if (isset($this->shop['category'][$sid]))
            $category = $this->shop['category'][$sid];

        $shop = array();
        if (isset($this->shop['shop'][$sid]))
            $shop = $this->shop['shop'][$sid];

        array_sort_by_column($shop, 'sale_id', SORT_DESC);

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_shop_advertising.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'categorys' => $category,
                    'shops' => $shop,
                    'sale_ma' => get_instance()->session->getDiscount('shop')
                ),
                get_lang('shop.lang')
            )

        );
    }

    public function widget_item(){

        $name_id = get_instance()->url->segment(3);

        if (strpos($name_id, '.') === false)
            return error_404_html();

        list( ,$item_id) = explode('.', $name_id);
        $item_id = intval($item_id);

        $sid = get_instance()->get_sid();

        if (isset($this->shop['shop'][$sid][$item_id]))
            $item = $this->shop['shop'][$sid][$item_id];
        else
            return error_404_html();

        $category = array();
        if (isset($this->shop['category'][$sid]))
            $category = $this->shop['category'][$sid];


        if ($item['type'] == 'shop') {

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_item.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'payment_system' => get_instance()->config['payment_system'],
                        'categorys' => $category,
                        'item' => $item,
                        'char_list' => get_instance()->session->getGameChars(),
                        'sale_ma' => get_instance()->session->getDiscount('shop')
                    ),
                    get_lang('shop.lang')
                )

            );
        }else{

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_service.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'payment_system' => get_instance()->config['payment_system'],
                        'categorys' => $category,
                        'item' => $item,
                        'char_list' => get_instance()->session->getGameChars(),
                        'char_list_full' => get_instance()->session->getGameChars(false, true),
                        'sale_ma' => get_instance()->session->getDiscount('service'),

                        'tpl_enrollment' => $item['type']
                    ),
                    get_lang('shop.lang')
                )

            );
        }
    }


    public function widget_shop(){
        $this->set_label_new();
        $sid = get_instance()->get_sid();

        $category = array();
        if (isset($this->shop['category'][$sid]))
            $category = $this->shop['category'][$sid];

        $shop = array();
        if (isset($this->shop['shop'][$sid]))
            $shop = $this->shop['shop'][$sid];

        return get_instance()->fenom->fetch(
            get_tpl_file('shop_list.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'categorys' => $category,
                    'shops' => $shop,
                    'sale_ma' => get_instance()->session->getDiscount('shop')
                ),
                get_lang('shop.lang')
            )

        );
    }

    public function ajax_buy_shop(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид магазина
            if (!isset($_POST['shop_id']) OR empty($_POST['shop_id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["shop_id"] = intval($_POST['shop_id']);

            //тип доставки
            if (!isset($_POST['type_buy']) OR empty($_POST['type_buy']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_type_buy'])->danger();
            else{

                if($_POST['type_buy'] == '#ma') { //Получить в пределах ма
                    $vars["type_buy"] = 'ma';

                    if (!isset($_POST['account_name']) OR empty($_POST['account_name']))
                        return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_account_name'])->danger();
                    else
                        $vars["account_name"] = $_POST['account_name'];

                    if (!isset($_POST['char_name']) OR empty($_POST['char_name']))
                        return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_char_name'])->danger();
                    else
                        $vars["char_name"] = $_POST['char_name'];

                }elseif($_POST['type_buy'] == '#nick-name') { // Передать на персонажа по нику
                    $vars["type_buy"] = 'nick_name';

                    if (!isset($_POST['nick_name']) OR empty($_POST['nick_name']))
                        return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_nick_name'])->danger();
                    else
                        $vars["nick_name"] = $_POST['nick_name'];

                }else //Доставить на склад МА
                    $vars["type_buy"] = 'warehouse';

            }

            $sid = get_instance()->get_sid();

            if (!isset($this->shop['shop'][$sid][$vars["shop_id"]]))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();
            else
                $shop = $this->shop['shop'][$sid][$vars["shop_id"]];

            if ($shop["complect"] == 0){
                if (!isset($_POST['items']) OR empty($_POST['items']))
                    return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_items'])->danger();
                else
                    $vars["items"] = $_POST['items'];

                $vars["complect"] = $shop["complect"];
            }

            $response = $api->buy_shop($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html($response["response"]->data->user_data->balance, '.balance_html')->success();

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

    public function ajax_buy_service(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид магазина
            if (!isset($_POST['shop_id']) OR empty($_POST['shop_id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["shop_id"] = intval($_POST['shop_id']);


            $sid = get_instance()->get_sid();

            if (!isset($this->shop['shop'][$sid][$vars["shop_id"]]))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_shop_not_found'])->danger();


            if (isset($_POST['items']) OR !empty($_POST['items']))
                $vars["items"] = $_POST['items'];

            unset($_POST['module_form'],$_POST['module'],$_POST['shop_id'],$_POST['items']);
            //перебераем входяшие данные
            foreach ($_POST as $key => $item) {
                $vars[$key] = $item;
            }

            $response = $api->buy_service($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html($response["response"]->data->user_data->balance, '.balance_html')->success();

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
        $t = filemtime(ROOT_DIR.'/Library/shop.php');
        set_cookie('shop_new', $t, strtotime("+1 year"));
    }
}