<?php
/********************************
 * Dev and Code by Demort
 * email : demortx@mail.ru
 ********************************/


define("ROOT_DIR", dirname(__FILE__));
require_once ROOT_DIR . "/Config.php";
//Developer log error

if (DEBUG OR $_SERVER[HEADER_IP] == DEBUG_IP) {
    error_reporting(E_ALL & ~E_NOTICE);
    @ini_set('display_errors', 1);
} else {
    error_reporting(0);
}
include_once ROOT_DIR . "/Helpers/function_helper.php";
include_once ROOT_DIR . "/Helpers/render_html.php";
include_once ROOT_DIR . "/Helpers/cookie_helper.php";
include_once ROOT_DIR . "/Helpers/utf8/utf8.php";


/*Переопределение IP адресов от cloudfire*/
if (CLOUD_FLARE)
    CloudFire();
//Отслеживание рекламы
get_utm();

//include class
spl_autoload_register(function ($class) {

    $loud = false;
    $path = ROOT_DIR;

    //если опрашивается старинцы шаблона и его нет ридирект в лк
    if ($class == 'Template\Pages'){
        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/Pages.php')) {
            include_once ROOT_DIR.TEMPLATE_DIR . '/Pages.php';
            $loud = true;
        }else {
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }
    }else if (file_exists($path . '/Class/' . $class . '.php')) {
        require_once($path . '/Class/' . $class . '.php');
        $loud = true;
    } else if (file_exists($path . '/Class/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php')) {
        require_once($path . '/Class/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php');
        $loud = true;
    } else if (file_exists($path .'/'. str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php')) {
        require_once($path .'/'. str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php');
        $loud = true;
    }

    if (!$loud) {
        echo 'Unable to locate the specified Class: ' . $class . '.php';
        exit(5); // EXIT_UNK_CLASS
    }
});


//start Router
global $URI, $RTR, $_POLL;
$URI = new URI();
$ignore_detect_lang_page = array(
    //Приложение
    '/app',
    '/app/check_version',
    '/app/get_current_version',
    '/app/get_payment_methods',
    '/app/signin',
    '/app/signup',
    '/app/activation',
    '/app/reminder',
    '/app/refresh_accounts',
    '/app/get_account_password',
    '/app/create_game_account',
    '/app/refresh_balance',
    '/app/change_password',
    '/app/change_password_game_account',
    '/app/forgot_password_game_account',
    '/app/checkout',
    '/app/buy_in_game_currency',
    '/app/get_bonus_cod',
    '/app/get_server_list',
    '/app/get_in_game_currency',
    '/app/get_bonus_pay',
    '/app/server_change',
    '/app/get_daily_rewards',
    '/app/give_daily_rewards',
    '/app/get_user_info',
    //Апи
    '/api/send_email',
    '/api/update_session',
    '/api/connection_check',
    '/api/config',
    '/api/shop',
    '/api/market',
    '/api/service',
    '/api/cases',
    '/api/lucky_wheel',
    '/api/daily_rewards',
    '/api/gift_code',
    '/api/money_withdrawal',
    '/api/item',
    '/api/payment/unitpay/'.PAYMENT_KEY,
    '/api/payment/nextpay/'.PAYMENT_KEY,
    '/api/payment/freekassa/'.PAYMENT_KEY,
    '/api/payment/paypal/'.PAYMENT_KEY,
    '/api/payment/paygol/'.PAYMENT_KEY,
    '/api/payment/g2a/'.PAYMENT_KEY,
    '/api/payment/payop/'.PAYMENT_KEY,
    '/api/payment/alikassa/'.PAYMENT_KEY,
    '/api/payment/payu/'.PAYMENT_KEY,
    '/api/payment/enot/'.PAYMENT_KEY,
    '/api/payment/ipay/'.PAYMENT_KEY,
    '/api/payment/paysafecard/'.PAYMENT_KEY,
    '/api/payment/ips_payment/'.PAYMENT_KEY,
    '/api/payment/digiseller/'.PAYMENT_KEY,
    '/api/payment/paymentwall/'.PAYMENT_KEY,
    '/api/payment/qiwi/'.PAYMENT_KEY,
    '/text',
    '/captcha/img',
    '/prefix/refresh',
    '/promo-game',
    '/input',
);

$search_get = strstr($_SERVER['REQUEST_URI'], '?', true);
if (
    @$_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'
    AND !in_array( ($search_get == false ? $_SERVER['REQUEST_URI'] : $search_get), $ignore_detect_lang_page)
){
    detect_lang();
}
$RTR = new Router(null, $URI);

/**
 * Reference to the Controller method.
 *
 * @return \Controller
 */
function &get_instance()
{
    return Controller::get_instance();
}

$e404 = FALSE;
$class = ucfirst($RTR->class);
$method = $RTR->method;

if (empty($class) OR !file_exists(ROOT_DIR . '/Controllers/' . $RTR->directory . $class . '.php')) {
    $e404 = TRUE;
} else {

    require_once(ROOT_DIR . '/Controllers/' . $RTR->directory . $class . '.php');

    if (!class_exists($class, FALSE) OR $method[0] === '_' OR method_exists('Controller', $method)) {
        $e404 = TRUE;
    } elseif (method_exists($class, '_remap')) {
        $params = array($method, array_slice($URI->rsegments, 2));
        $method = '_remap';
    }
    // WARNING: It appears that there are issues with is_callable() even in PHP 5.2!
    // Furthermore, there are bug reports and feature/change requests related to it
    // that make it unreliable to use in this context. Please, DO NOT change this
    // work-around until a better alternative is available.
    elseif (!in_array(strtolower($method), array_map('strtolower', get_class_methods($class)), TRUE)) {
        $e404 = TRUE;
    }
}

if ($e404) {
    if (!empty($RTR->routes['404_override'])) {
        if (sscanf($RTR->routes['404_override'], '%[^/]/%s', $error_class, $error_method) !== 2) {
            $error_method = 'index';
        }

        $error_class = ucfirst($error_class);

        if (!class_exists($error_class, FALSE)) {
            if (file_exists(ROOT_DIR . '/Controllers/' . $RTR->directory . $error_class . '.php')) {
                require_once(ROOT_DIR . '/Controllers/' . $RTR->directory . $error_class . '.php');
                $e404 = !class_exists($error_class, FALSE);
            } // Were we in a directory? If so, check for a global override
            elseif (!empty($RTR->directory) && file_exists(ROOT_DIR . '/Controllers/' . $error_class . '.php')) {
                require_once(ROOT_DIR . '/Controllers/' . $error_class . '.php');
                if (($e404 = !class_exists($error_class, FALSE)) === FALSE) {
                    $RTR->directory = '';
                }
            }
        } else {
            $e404 = FALSE;
        }
    }

    // Did we reset the $e404 flag? If so, set the rsegments, starting from index 1
    if (!$e404) {
        $class = $error_class;
        $method = $error_method;

        $URI->rsegments = array(
            1 => $class,
            2 => $method
        );
    } else {
        show_404($RTR->directory . $class . '/' . $method);
    }
}

if ($method !== '_remap') {
    $params = array_slice($URI->rsegments, 2);
}


/*
 * ------------------------------------------------------
 *  Instantiate the requested controller
 * ------------------------------------------------------
 */
$CI = new $class();

/*
 * ------------------------------------------------------
 *  Call the requested method
 * ------------------------------------------------------
 */
call_user_func_array(array(&$CI, $method), $params);