<?php

use ApiLib\GlobalApi;

/**
 * Created by PhpStorm.
 * User: x88xa
 * Date: 13.10.2018
 * Time: 17:57
 */

class App extends Controller
{
    public $version = 112;
    public $installer_url = "http://alpachini.com/qplay_updater.exe";
    public $decrypt_key = "L!3T6/9dA8cmt>1M";
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
        'qiwi',
    );

    public $advertising = false;

    public function __construct(){
        parent::__construct();

        $this->gateway();

        if ($this->advertising === false)
            $this->advertising = include ROOT_DIR . '/Library/advertising.php';

        if (isset(get_instance()->config['payment_system']['sorting_pay']))
            $this->payment_list = get_instance()->config['payment_system']['sorting_pay'];

    }

    public function gateway(){

        header('Content-Type: application/json; charset=utf-8');
        if(!isset($this->config['project']['launcher_app']) OR $this->config['project']['launcher_app'] == false)
            exit(json_encode(array("error" => "API for the application has been disabled by the administration!","code" => 0)));

        if(!isset($this->config['project']['launcher_key']))
            exit(json_encode(array("error" => "API for the application has been disabled by the administration!","code" => 0)));

        if (!isset($_REQUEST['launcher_key']) OR empty($_REQUEST['launcher_key']))
            exit(json_encode(array("error" => "The key field cannot be empty!","code" => 0)));

        if ($this->config['project']['launcher_key'] != $_REQUEST['launcher_key'])
            exit(json_encode(array("error" => "The key does not fit!","code" => 0)));

    }

    public function index(){
        $method = array(
            'url' => $this->config['project']['url_site'].'/app',
            'method' => array(
                '/get_bonus_pay' => array(
                    'session' => false,
                ),
                '/get_in_game_currency' => array(
                    'session' => false,
                ),
                '/get_server_list' => array(
                    'session' => false,
                ),
                '/check_version' => array(
                    'session' => false,
                ),
                '/get_current_version' => array(
                    'session' => false,
                ),
                '/get_payment_methods' => array(
                    'session' => false,
                ),
                '/signin' => array(
                    'session' => false,
                ),
                '/signup' => array(
                    'session' => false,
                ),
                '/activation' => array(
                    'session' => false,
                ),
                '/reminder' => array(
                    'session' => false,
                ),
                '/refresh_accounts' => array(
                    'session' => true,
                ),
                '/get_account_password' => array(
                    'session' => true,
                ),
                '/create_game_account' => array(
                    'session' => true,
                ),
                '/refresh_balance' => array(
                    'session' => true,
                ),
                '/change_password' => array(
                    'session' => true,
                ),
                '/change_password_game_account' => array(
                    'session' => true,
                ),
                '/checkout' => array(
                    'session' => false,
                ),
                '/buy_in_game_currency' => array(
                    'session' => true,
                ),
                '/get_bonus_cod' => array(
                    'session' => true,
                ),
                '/server_change' => array(
                    'session' => true,
                ),
            ),

        );

        exit(json_encode($method, JSON_PRETTY_PRINT));

    }

    /**
     * Список акций при платеже
     */
    public function get_bonus_pay(){

        if (isset($_POST['sid']) AND isset(get_instance()->config['event'][$_POST['sid']]))
            exit( json_encode(array('bonus_pay' => get_instance()->config['event'][$_POST['sid']])));
        else
            exit( json_encode(array('bonus_pay' => get_instance()->config['event'])));
    }
    /**
     * Список внутриигровой валюты
     */
    public function get_in_game_currency(){

        if (isset($_POST['sid']) AND isset(get_instance()->config['in_game_currency'][$_POST['sid']]))
            exit( json_encode(array('in_game_currency' => get_instance()->config['in_game_currency'][$_POST['sid']])));
        else
            exit( json_encode(array('in_game_currency' => get_instance()->config['in_game_currency'])));
    }
    /**
     * Список серверов
     */
    public function get_server_list(){

        $server_site_cfg = require ROOT_DIR . '/Library/server_config.php';
        $list = array();
        foreach (get_instance()->config['project']['server_info'] as $platform => $servers_temp)
        {
            if (is_array($servers_temp)) {
                $servers = array();
                foreach ($servers_temp as $sid => $info) {


                    $chronicle = isset($server_site_cfg[$sid]['chronicle']) ? $server_site_cfg[$sid]['chronicle'] : 'none';

                    $servers[$chronicle][$sid]['name'] = $info['name'];
                    $servers[$chronicle][$sid]['rate'] = $info['rate'];

                    if (isset($server_site_cfg[$sid])) {


                        if(isset($server_site_cfg[$sid]['hide']) AND $server_site_cfg[$sid]['hide'] == 0) {
                            unset($servers[$chronicle][$sid]);
                            continue;
                        }

                        if ($server_site_cfg[$sid]['re_name'] AND !empty($server_site_cfg[$sid]['name']))
                            $servers[$chronicle][$sid]['name'] = $server_site_cfg[$sid]['name'];

                        if ($server_site_cfg[$sid]['re_rate'])
                            $servers[$chronicle][$sid]['rate'] = $server_site_cfg[$sid]['rate'];

                        $servers[$chronicle][$sid]['icon'] = $server_site_cfg[$sid]['icon'];
                        $servers[$chronicle][$sid]['img'] = $server_site_cfg[$sid]['img'];
                        $servers[$chronicle][$sid]['link'] = $server_site_cfg[$sid]['link'];
                        $servers[$chronicle][$sid]['chronicle'] = $server_site_cfg[$sid]['chronicle'];
                        $servers[$chronicle][$sid]['description'] = $server_site_cfg[$sid]['description'];
                        $servers[$chronicle][$sid]['date'] = $server_site_cfg[$sid]['date'];
                        $servers[$chronicle][$sid]['time'] = $server_site_cfg[$sid]['time'];
                        $servers[$chronicle][$sid]['time_zone'] = $server_site_cfg[$sid]['time_zone'];
                    } else {
                        $servers[$chronicle][$sid]['img'] = '';
                        $servers[$chronicle][$sid]['icon'] = '';
                        $servers[$chronicle][$sid]['link'] = '';
                        $servers[$chronicle][$sid]['chronicle'] = '';
                        $servers[$chronicle][$sid]['description'] = '';
                        $servers[$chronicle][$sid]['date'] = '';
                        $servers[$chronicle][$sid]['time'] = '';
                        $servers[$chronicle][$sid]['time_zone'] = '';
                    }



                    $list[$platform] = $servers;
                }
            }
        }



        exit(json_encode($list));
    }
    /**
     * Версия лаунчера
     */
    public function check_version(){

        echo json_encode(array( 'current_version' => $this->version));

    }

    /**
     * Линк на скачку
     */
    public function get_current_version(){

        echo json_encode(array( 'installer_url' => $this->installer_url));

    }

    /**
     * Список методов на оплату
     */
    public function get_payment_methods(){

        $list = array();

        if (isset($this->config['payment_system']) AND is_array($this->config['payment_system'])){
            foreach ($this->payment_list as $sys){
                if (isset($this->config['payment_system'][$sys]) AND $this->config['payment_system'][$sys]){
                    $list[] = $sys;
                }
            }
        }

        echo json_encode(array( 'payments' => $list));

    }

    /**
     * Авторизация
     */
    public function signin(){

        $api = new GlobalApi();
        $vars = array();

        $vars['type'] = 'signin';

        if (!isset($_POST['type_login']))
            exit(get_instance()->ajaxmsg->notify('Empty type_login')->danger());


        if ($_POST['type_login'] == 'phone'){

            //Проверка телефона
            if (!isset($_POST['phone']) OR empty($_POST['phone']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone'])->danger());
            else
                $vars["phone"] = str_replace(array(' ', '-'), '', $_POST['phone']);

            //Проверка телефона
            if (!isset($_POST['phone_code']) OR empty($_POST['phone_code']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_phone_code'])->danger());
            else
                $vars["phone_code"] = $_POST['phone_code'];

            $vars['type_login'] = 'phone';

        }else{

            if (!isset($_POST['email']) OR empty($_POST['email']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_email_phone'])->danger());


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
            exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error_type'])->danger());


        //Проверка Пароля
        if (!isset($_POST['password']) OR empty($_POST['password']))
            exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_password'])->danger());
        else
            $vars["password"] = $_POST['password'];

        //Проверка сервера
        if (!isset($_POST['sid']) OR empty($_POST['sid']))
            exit(get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_empty_sid'])->danger());
        else{
            $vars["sid"] = $_POST['sid'];
            get_instance()->set_sid((int) $vars["sid"], false);
        }


        //подписка
        if (isset($_POST["remember-me"]))
            $vars["remember-me"] = $_POST["remember-me"];

        if (isset($_SESSION['promo_game']['status']) AND $_SESSION['promo_game']['status'] == 'finish')
            $vars["promo_game"] = $_SESSION['promo_game'];

        //Передаем UTM метки
        $vars["utm"] = array(
            "utm_source" => 'launcher',
            "utm_fp" => isset($_POST['hwid']) ? $_POST['hwid'] : '',
        );
        //информируем что лаунчер
        $vars["launcher"] = 1;

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

                    $send = get_instance()->ajaxmsg->notify( (string) $response["response"]->success)->variables($response["response"]->data)->success();

                }else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        exit($send);



    }

    /**
     * Регистрация
     */
    public function signup(){

        $api = new GlobalApi();
        $vars = array();

        $cfg = $this->config['cabinet'];

        if ($cfg['registration_login']) {

            //Проверка логина
            if ($cfg['registration_login_optional'] == false AND (!isset($_POST['login']) OR empty($_POST['login'])))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_login'])->danger());


            if (isset($_POST['login']) AND !empty($_POST['login'])) {
                $vars["login"] = $_POST['login'];

                //Проверка префикса
                if ($cfg['registration_login_prefix']) {
                    if (isset($_POST["prefix"])) {
                        $vars['prefix'] = $_POST["prefix"];
                    }

                    if (!isset($vars['prefix']))
                        exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_prefix'])->danger());

                }


                //Проверка сервера
                if (!isset($_POST['sid']) OR empty($_POST['sid']))
                    exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sid'])->danger());
                else {
                    if (checkSID((int)$_POST['sid'])) {
                        $vars["sid"] = (int)$_POST['sid'];
                        get_instance()->set_sid((int)$vars["sid"], false);
                    } else
                        exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_missing_sid'])->danger());
                }
            }

        }

        //Проверка Пароля
        if (!isset($_POST['password']) OR empty($_POST['password']))
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_password'])->danger());
        else
            $vars["password"] = $_POST['password'];


        //Регистрация по почте
        if (isset($cfg['registration_type']['email']) AND $_POST["type_reg"] == '#r-email') {

            $vars['type'] = 'email';

            //Проверка Почты
            if (!isset($_POST['email']) OR empty($_POST['email']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_email'])->danger());
            else
                $vars["email"] = $_POST['email'];

            //Регистрация через телефон
        } elseif (isset($cfg['registration_type']['phone']) AND $_POST["type_reg"] == '#r-phone') {

            $vars['type'] = 'phone';

            //Проверка телефона
            if (!isset($_POST['phone']) OR empty($_POST['phone']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone'])->danger());
            else
                $vars["phone"] = $_POST['phone'];

            //Проверка телефона
            if (!isset($_POST['phone_code']) OR empty($_POST['phone_code']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone_code'])->danger());
            else
                $vars["phone_code"] = $_POST['phone_code'];

            //Проверка телефона
            if (!isset($_POST['sms_cod']) OR empty($_POST['sms_cod']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sms_cod'])->danger());
            else
                $vars["sms_cod"] = $_POST['sms_cod'];


            //Проверка Почты
            if (isset($_POST['email-phone']) OR !empty($_POST['email-phone']))
                $vars["email"] = $_POST['email-phone'];



        } else
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_type_reg'])->danger());


        //Проверка правил
        if (!isset($_POST["terms"]))
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_terms'])->danger());
        else
            $vars["terms"] = $_POST["terms"];

        //подписка
        if (isset($_POST["subscribe"]))
            $vars["subscribe"] = $_POST["subscribe"];

        if (isset($_SESSION['promo_game']['status']) AND $_SESSION['promo_game']['status'] == 'finish')
            $vars["promo_game"] = $_SESSION['promo_game'];


        //Передаем UTM метки
        $vars["utm"] = array(
            "utm_source" => 'launcher',
            "utm_fp" => isset($_POST['hwid']) ? $_POST['hwid'] : '',
        );



        $response = $api->signup($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


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

                $send = get_instance()->ajaxmsg->notify($response["response"]->success)->variables(array('activation' => _boolean($response["response"]->register_activation), 'signup' => $_SESSION['signup']))->success();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        exit($send);
    }

    /**
     * активация регистрации
     */
    public function activation(){

        $cfg = $this->config['cabinet'];

        //Проверяем сессию если авторизован то переноправляем в кабинет
        if ($this->session->isLogin() ){
            exit(get_instance()->ajaxmsg->notify('You are logged in')->danger());

        }

        if(!isset($_POST['code']))
            exit(get_instance()->ajaxmsg->notify('Empty code')->danger());

        //Проверяем ключь по регулярке
        if ($cfg['registration_confirmation'] == false OR !preg_match("/^[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}$/i", $_POST['code'])){
            exit(get_instance()->ajaxmsg->notify('Empty type_login')->danger());
        }



        $api = new GlobalApi();
        $vars = array();

        $vars["type"] = 'code';
        $vars["code"] = $_POST['code'];

        $response = $api->signup($vars);


        if($response['ok']){

            if(isset($response["response"]->success)) {
                $error = 0;
                $msg = (string) $response["response"]->success;

                $response["response"] = json_decode(json_encode($response["response"]),true);


                unset($_SESSION['signup']);

                if (isset($response["response"]["login"]) AND !empty($response["response"]["login"])) {
                    $_SESSION['signup']['login'] = $response["response"]["login"];
                    if (isset($response["response"]["prefix"]) AND !empty($response["response"]["prefix"]))
                        $_SESSION['signup']['prefix'] = $response["response"]["prefix"];
                }

                if (isset($response["response"]["password"]) AND !empty($response["response"]["password"]))
                    $_SESSION['signup']['password'] = $response["response"]["password"];
                if (isset($response["response"]["email"]) AND !empty($response["response"]["email"]))
                    $_SESSION['signup']['email'] = $response["response"]["email"];
                if (isset($response["response"]["phone"]) AND !empty($response["response"]["phone"]))
                    $_SESSION['signup']['phone'] = $response["response"]["phone"];
                if (isset($response["response"]["subscribe"]) AND !empty($response["response"]["subscribe"]))
                    $_SESSION['signup']['subscribe'] = $response["response"]["subscribe"];
                if (isset($response["response"]->pin) AND (int)$response["response"]["pin"] > 0)
                    $_SESSION['signup']['pin'] = (int)$response["response"]["pin"];

            }else{
                $error = 1;
                $msg = (string) $response["response"]->error;
            }

        }else{
            $error = 1;
            $msg = $response['http_error'];
        }


        if ($error == 1)
            exit(get_instance()->ajaxmsg->notify($msg)->danger());
        else
            exit(get_instance()->ajaxmsg->notify($msg)->variables(array('signup' => $_SESSION['signup']))->success());

    }

    /**
     * Восстановление пароля
     */
    public function reminder(){

        if(!isset($_POST['type_reminder']))
            exit(get_instance()->ajaxmsg->notify('Empty type_reminder')->danger());

        $api = new GlobalApi();
        $vars = array();

        $cfg = get_instance()->config['cabinet'];

        //Востоновление через почту
        if (isset($cfg['reminder_type']['email']) AND $_REQUEST["type_reminder"] == '#r-email') {

            $vars['type'] = 'email';

            //Проверка Почты
            if (!isset($_REQUEST['email']) OR empty($_REQUEST['email']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_email'])->danger());
            else
                $vars["email"] = $_REQUEST['email'];

            //Востоновление через телефон
        } elseif (isset($cfg['reminder_type']['phone']) AND $_REQUEST["type_reminder"] == '#r-phone') {

            $vars['type'] = 'phone';

            //Проверка телефона
            if (!isset($_REQUEST['phone']) OR empty($_REQUEST['phone']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone'])->danger());
            else
                $vars["phone"] = $_REQUEST['phone'];

            //Проверка телефона
            if (!isset($_REQUEST['phone_code']) OR empty($_REQUEST['phone_code']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_phone_code'])->danger());
            else
                $vars["phone_code"] = $_REQUEST['phone_code'];

            //Проверка телефона
            if (!isset($_REQUEST['sms_cod']) OR empty($_REQUEST['sms_cod']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_sms_cod'])->danger());
            else
                $vars["sms_cod"] = $_REQUEST['sms_cod'];


        } else
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_type_reg'])->danger());



        //Передаем UTM метки
        $vars["utm"] = array(
            "utm_source" => 'launcher',
            "utm_fp" => isset($_POST['hwid']) ? $_POST['hwid'] : '',
        );
        $response = $api->reminder($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

            } else {


                $send = get_instance()->ajaxmsg->notify($response["response"]->success)->variables(array('type' => $vars['type']))->success();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }

        exit($send);

    }

    /**
     * Обновление списка персонажей
     */
    public function refresh_accounts(){

        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->refresh_accounts($vars);

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


                        $send = get_instance()->ajaxmsg->variables($response["response"]->data)->notify((string)$response["response"]->success)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);

    }

    /**
     * Получения ключа авторизации
     */
    public function get_account_password(){

        if(!isset($_POST['account_name']))
            exit(get_instance()->ajaxmsg->notify('Empty account_name')->danger());

        $api = new GlobalApi();
        $vars = array(
            "account" => $_POST['account_name']
        );

        if (get_instance()->session->isLogin()) {

            $response = $api->in_game($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data)) {
                        $send = get_instance()->ajaxmsg->variables(array('password' => qplay_decrypt($response["response"]->data, $this->decrypt_key)))->notify((string)$response["response"]->success)->success();
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);

    }

    /**
     * Создание игрового аккаунта
     */
    public function create_game_account(){
        $api = new GlobalApi();
        $vars = array();

        $cfg = get_instance()->config['cabinet'];

        //Проверка префикса
        if ($cfg['registration_login_prefix'] AND !empty($_REQUEST['login'])) {
            if (isset($_REQUEST["prefix"])) {
               $vars['prefix'] = $_REQUEST["prefix"];
            }

            if (!isset($vars['prefix']))
                exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_not_found_prefix'])->danger());

        }

        //Проверка логина
        if (!isset($_REQUEST['login']) OR empty($_REQUEST['login']))
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_login'])->danger());
        else
            $vars["login"] = $_REQUEST['login'];

        //Проверка Пароля
        if (!isset($_REQUEST['password']) OR empty($_REQUEST['password']))
            exit(get_instance()->ajaxmsg->notify(get_lang('signup.lang')['signup_ajax_empty_password'])->danger());
        else
            $vars["password"] = $_REQUEST['password'];

        //Передаем UTM метки
        $vars["utm"] = array(
            "utm_source" => 'launcher',
            "utm_fp" => isset($_POST['hwid']) ? $_POST['hwid'] : '',
        );

        if (get_instance()->session->isLogin()) {

            $response = $api->create_game_account($vars);

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

                        $send = get_instance()->ajaxmsg->variables($response["response"]->data)->notify((string)$response["response"]->success)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);
    }

    /**
     * Обновление баланса
     */
    public function refresh_balance(){
        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->refresh_balance($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->variables(array('balance' => (int) $response["response"]->data->user_data->balance))->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }
            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        exit($send);
    }

    /**
     * Смена пароля мастер аккаунта
     */
    public function change_password(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_POST['password_old']) OR empty($_POST['password_old']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_old'])->danger());
            else
                $vars["password_old"] = $_POST['password_old'];

            if (!isset($_POST['password_new']) OR empty($_POST['password_new']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new'])->danger());
            else
                $vars["password_new"] = $_POST['password_new'];

            if (!isset($_POST['password_new_confirm']) OR empty($_POST['password_new_confirm']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new_confirm'])->danger());
            else
                $vars["password_new_confirm"] = $_POST['password_new_confirm'];
            //Проверка пин кода
            if (check_pin("pins_change_pwd_ma")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    exit(get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger());
                else
                    $vars["pin"] = $_POST['pin'];
            }


            $response = $api->change_pwd_ma($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);
    }

    /**
     * Смена пароля игрового аккаунта
     */
    public function change_password_game_account(){
        $api = new GlobalApi();
        $vars = array();

        if (!isset($_POST['account']) OR empty($_POST['account']))
            exit(get_instance()->ajaxmsg->notify(get_lang('settings.lang')['ajax_empty_account'])->danger());
        else
            $vars['account'] = $_POST['account'];

        if (!isset($_POST['password_old']) OR empty($_POST['password_old']))
            exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_old'])->danger());
        else
            $vars["password_old"] = $_POST['password_old'];

        if (!isset($_POST['password_new']) OR empty($_POST['password_new']))
            exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new'])->danger());
        else
            $vars["password_new"] = $_POST['password_new'];

        if (!isset($_POST['password_new_confirm']) OR empty($_POST['password_new_confirm']))
            exit(get_instance()->ajaxmsg->notify(get_lang('widget_change_password.lang')['ajax_empty_password_new_confirm'])->danger());
        else
            $vars["password_new_confirm"] = $_POST['password_new_confirm'];

        //Проверка пин кода
        if (check_pin("pins_change_password_account")) {
            if (!isset($_POST['pin']) OR empty($_POST['pin']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger());
            else
                $vars["pin"] = $_POST['pin'];
        }

        if (get_instance()->session->isLogin()) {

            $response = $api->change_password_account($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel')->success();
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);
    }

    /**
     * Создание платежа
     */
    public function checkout(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {
            /**
             * Оплата авторизованного
             */
            //Проверка сервера
            if (!isset($_REQUEST['sum']) OR empty($_REQUEST['sum']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_sum'])->danger());
            else
                $vars["sum"] = $_REQUEST['sum'];


            //Проверка сервера
            if (!isset($_REQUEST['payment_method']) OR empty($_REQUEST['payment_method']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger());
            else
                $vars["payment_method"] = $_REQUEST['payment_method'];

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


            //Ставим флаг создания простого платежа
            $vars["type"] = 1;

            $response = $api->checkout($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {
                    if (isset($response["response"]->redirect)) {

                        if (isset($response["response"]->post) AND !empty($response["response"]->post) > 0)
                            $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                        else
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }


        }else{
            /**
             * Оплата не авторизованного
             */
            //Проверка сервера
            if (!isset($_REQUEST['sum']) OR empty($_REQUEST['sum']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_sum'])->danger());
            else
                $vars["sum"] = $_REQUEST['sum'];


            //Проверка сервера
            if (!isset($_REQUEST['payment_method']) OR empty($_REQUEST['payment_method']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger());
            else
                $vars["payment_method"] = $_REQUEST['payment_method'];

            //Проверка сервера
            if (!isset($_REQUEST['recipient']) OR empty($_REQUEST['recipient']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_recipient'])->danger());
            else
                $vars["recipient"] = $_REQUEST['recipient'];

            //Проверка сервера
            if (!isset($_REQUEST['type_id']) OR empty($_REQUEST['type_id']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_type_id'])->danger());
            else
                $vars["type_id"] = $_REQUEST['type_id'];

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

            //Ставим флаг создания простого платежа
            $vars["type"] = 2;

            $response = $api->checkout($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {
                    if (isset($response["response"]->redirect)) {

                        if (isset($response["response"]->post) AND !empty($response["response"]->post) > 0)
                            $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                        else
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }


        }


        exit($send);
    }

    /**
     * Покупка внутриигровой валюты
     */
    public function buy_in_game_currency(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид платежки
            if (!isset($_REQUEST['type_id']) OR empty($_REQUEST['type_id']))
                exit(get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_type_id'])->danger());
            else
                $vars["type_id"] = intval($_REQUEST['type_id']);

            //Количество покупаемых предметов
            if (!isset($_REQUEST['count']) OR empty($_REQUEST['count']))
                exit(get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_count'])->danger());
            else
                $vars["count"] = intval($_REQUEST['count']);

            //аккаунт
            if (!isset($_REQUEST['account_name']) OR empty($_REQUEST['account_name']))
                exit(get_instance()->ajaxmsg->notify(get_lang('ingame.lang')['ajax_empty_account_name'])->danger());
            else
                $vars["account_name"] = $_REQUEST['account_name'];

            //персонаж
            if (isset($_REQUEST['char_name']) OR !empty($_REQUEST['char_name']))
                $vars["char_name"] = $_REQUEST['char_name'];



            $response = $api->buy_in_game_currency($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->variables(array('balance' => (int) $response["response"]->data->user_data->balance))->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }
            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        exit($send);
    }

    /**
     * Активация бонус кода
     */
    public function get_bonus_cod(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //ид магазина
            if (!isset($_REQUEST['cod']) OR empty($_REQUEST['cod']))
                exit(get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_cod'])->danger());
            else
                $vars["cod"] = trim($_REQUEST['cod']);


            if (!isset($_REQUEST['select_recipient']))
                exit(get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_cod'])->danger());
            else
                $vars["select_recipient"] = intval($_REQUEST['select_recipient']);

            if ($_REQUEST['select_recipient'] == '1') {
                //аккаунт
                if (!isset($_REQUEST['account_name']) OR empty($_REQUEST['account_name']))
                    exit(get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger());
                else
                    $vars["account_name"] = $_REQUEST['account_name'];

                //персонаж
                if (!isset($_REQUEST['char_name']) OR empty($_REQUEST['char_name']))
                    exit(get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger());
                else
                    $vars["char_name"] = $_REQUEST['char_name'];

            }


            $response = $api->get_bonus_cod($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {

                        if ($response["response"]->select_recipient){
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->variables(array('action'=>'show_chars'))->success();
                        }else{

                            if (isset($response["response"]->data)) {
                                $data = json_encode($response["response"]->data);
                                $data = json_decode($data, true);
                                get_instance()->session->updateSessionDB($data);
                                //->html($response["response"]->data->user_data->balance, '.balance_html')
                            }
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->success();
                        }
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }
            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        exit($send);
    }

    /**
     * Смена сервера
     */
    public function server_change(){
        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_POST['set_sid']) OR empty($_POST['set_sid']))
                exit(get_instance()->ajaxmsg->notify(get_lang('widget_social.lang')['signin_ajax_empty_sid'])->danger());
            else{
                $vars["sid"] = $_POST['set_sid'];
                get_instance()->set_sid((int) $vars["sid"], false);
            }



            $response = $api->server_change($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();


                } else {


                    if (isset($response["response"]->data->master_account)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->variables($data)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        exit($send);
    }

}