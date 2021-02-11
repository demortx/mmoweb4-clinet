<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
 * Date: 23.12.2015
 ********************************/

if ( ! function_exists('is_cli'))
{

    /**
     * Is CLI?
     *
     * Test to see if a request was made from the command line.
     *
     * @return 	bool
     */
    function is_cli()
    {
        return (PHP_SAPI === 'cli' OR defined('STDIN'));
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('show_404'))
{
    /**
     * 404 Page Handler
     *
     * This function is similar to the show_error() function above
     * However, instead of the standard error template it displays
     * 404 errors.
     *
     * @param	string
     * @param	bool
     * @return	void
     */
    function show_404($page = '', $log_error = TRUE)
    {
        header("HTTP/1.0 404 Not Found");
        include ROOT_DIR. VIEWPATH . "/panel/op_error_404.tpl";
        exit(4); // EXIT_UNKNOWN_FILE
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('remove_invisible_characters'))
{
    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param	string
     * @param	bool
     * @return	string
     */
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10),
        // carriage return (dec 13) and horizontal tab (dec 09)
        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }
}

// ------------------------------------------------------------------------


// ------------------------------------------------------------------------

if ( ! function_exists('lang_replace'))
{
    function lang_replace(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('select_lang')) {

    function select_lang()
    {
        $lang = get_cookie('mw_lang');


        if (!isset(get_instance()->config))
            $system = include ROOT_DIR . '/Library/config.php';
        else
            $system = get_instance()->config;

        if($lang !== false) {
            if (array_key_exists($lang, $system["site"]["language_list"]))
                return $lang;
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($language, array('ru', 'be', 'uk', 'ky', 'ab', 'mo', 'et', 'lv'))) {
                $language = 'ru';
            } else {
                $language = 'en';
            }
        }else
            return $system["site"]["language_active"];



        if (array_key_exists($language, $system["site"]["language_list"]))
            return $language;
        else
            return $system["site"]["language_active"];




    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_platform')) {

    function get_platform()
    {
        $type = get_cookie('mw_platform');
        $system = get_instance()->config;

        if($type !== false) {
            if (in_array($type, $system["game"]))
                return $type;
        }

        return array_shift($system["game"]);

    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('set_platform')) {

    function set_platform($platform)
    {
        set_cookie('mw_platform', $platform, strtotime("+1 year"));

    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('get_sid')) {

    function get_sid()
    {
        $sid = get_cookie('mw_sid');
        $system = get_instance()->config;

        if($sid !== false) {
            if (in_array($sid, $system['project']['server_sort'][get_platform()]))
                return $sid;
        }

        if (isset($system['project']['server_sort'][get_platform()]) AND is_array($system['project']['server_sort'][get_platform()]) AND count($system['project']['server_sort'][get_platform()]))
            return array_shift($system['project']['server_sort'][get_platform()]);
        else
            return 0;
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('get_sid_name')) {

    function get_sid_name($platform_show = true, $rate = false)
    {
        $sid = get_sid();
        $system = get_instance()->config;
        $system = $system['project']['server_info'][get_platform()][$sid];
        $str = '';

        if ($platform_show)
            $str .= ucfirst(get_platform()) . ' > ';

        $str .= $system['name'];

        if ($rate AND !empty($system['rate']) AND $system['rate']>0)
            $str .= ' x'.$system['rate'];


        return $str;
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('set_sid')) {

    function set_sid($sid)
    {
        set_cookie('mw_sid', intval($sid), strtotime("+1 year"));
    }
}

// ------------------------------------------------------------------------


if( ! function_exists('get_lang')){

    function get_lang($file){

        $lang = select_lang();

        if(is_array($file)){
            if(isset($file[$lang]) AND !empty($file[$lang]))
                return $file[$lang];
            else{
                $lang = array_keys($file);
                if (count($lang)) {
                    $lang = $lang[0];
                    return $file[$lang];
                }else
                    return array();
            }
        }

        if (!isset(get_instance()->language[$file])){

            if(file_exists(ROOT_DIR. "/Language/" . $file . ".php"))
                get_instance()->language[$file] = include_once ROOT_DIR. "/Language/" . $file . ".php";
            elseif(is_string($file) AND file_exists($file)){
                get_instance()->language[$file] = include_once $file;
            } else
                get_instance()->language[$file] = array();

        }

        if (isset(get_instance()->language[$file][$lang]) AND !empty(get_instance()->language[$file][$lang])){

            return get_instance()->language[$file][$lang];

        }else{

            $lang = array_keys(get_instance()->language[$file]);
            if (count($lang)){
                $lang = $lang[0];
                return get_instance()->language[$file][$lang];
            }else
                return array();

        }

    }

}


// ------------------------------------------------------------------------

if( ! function_exists('loud_lang_site')){
    function loud_lang_site(){
        global $TEMP;
        $s_lang = select_lang();
        if (isset($TEMP['site_lang'][$s_lang]))
            return $TEMP['site_lang'][$s_lang];

        if (is_dir(ROOT_DIR . TEMPLATE_DIR . '/Lang/')) {
            if (file_exists(ROOT_DIR . TEMPLATE_DIR . '/Lang/' . $s_lang . '.php')) {
                $TEMP['site_lang'][$s_lang] = include_once ROOT_DIR . TEMPLATE_DIR . '/Lang/' . $s_lang . '.php';
            } else {
                $lang_list = scandir(ROOT_DIR . TEMPLATE_DIR . '/Lang/');
                foreach ($lang_list as $lg_file) {
                    if (($lg_file != "." && $lg_file != "..") AND strripos($lg_file, '.php') !== false) {
                        $TEMP['site_lang'][$s_lang] = include_once ROOT_DIR . TEMPLATE_DIR . '/Lang/' . $lg_file;
                        break;
                    }
                }
            }
            return $TEMP['site_lang'][$s_lang];
        }else
            return $TEMP['site_lang'][$s_lang] = array();
    }
}


// ------------------------------------------------------------------------

if ( ! function_exists('SaveProjectConfig')) {

    function SaveProjectConfig($savedata)
    {

        $cfg_file = ROOT_DIR . "/Library/config.php";


        $fopen = fopen($cfg_file, "w");

        if (file_exists($cfg_file)) {


            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Dev and Code by Demort\n");
                fwrite($fopen, "* Skype x88xax88x / email : demortx@gmail.com\n");
                fwrite($fopen, "* https://mmoweb.ru\n");
                fwrite($fopen, "* Config - Global\n");
                fwrite($fopen, " ********************************/\n");
                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                fwrite($fopen, "\$system = array();\n");

                cfgWrite($fopen, $savedata, "\$system =");
                fwrite($fopen, "return \$system;");
                fclose($fopen);

                return true;

            }

        } else
            return false;

    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('SaveShopConfig')) {

    function SaveShopConfig($savedata)
    {

        $cfg_file = ROOT_DIR . "/Library/shop.php";


        $fopen = fopen($cfg_file, "w");

        if (file_exists($cfg_file)) {


            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Dev and Code by Demort\n");
                fwrite($fopen, "* Skype x88xax88x / email : demortx@gmail.com\n");
                fwrite($fopen, "* https://mmoweb.ru\n");
                fwrite($fopen, "* Shop - Global\n");
                fwrite($fopen, " ********************************/\n");
                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                fwrite($fopen, "\$shop = array();\n");

                cfgWrite($fopen, $savedata, "\$shop =");
                fwrite($fopen, "return \$shop;");
                fclose($fopen);

                return true;

            }

        } else
            return false;

    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('SaveMarketConfig')) {

    function SaveMarketConfig($savedata)
    {

        $cfg_file = ROOT_DIR . "/Library/market.php";


        $fopen = fopen($cfg_file, "w");

        if (file_exists($cfg_file)) {


            if ($fopen) {
                fwrite($fopen, "<?php\n");
                fwrite($fopen, "/********************************\n");
                fwrite($fopen, "* Dev and Code by Demort\n");
                fwrite($fopen, "* Skype x88xax88x / email : demortx@gmail.com\n");
                fwrite($fopen, "* https://mmoweb.ru\n");
                fwrite($fopen, "* Market - Lineage\n");
                fwrite($fopen, " ********************************/\n");
                fwrite($fopen, "defined('ROOT_DIR') OR exit('No direct script access allowed');\n");
                fwrite($fopen, "\$market = array();\n");

                cfgWrite($fopen, $savedata, "\$market =");
                fwrite($fopen, "return \$market;");
                fclose($fopen);

                return true;

            }

        } else
            return false;

    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('cfgWrite')) {

    function  cfgWrite($fopen, &$savedata, $amp = "")
    {

        $php_code = var_export($savedata, TRUE);
        $php_code = preg_replace("/'\s*=>\s*array\s*\(/m","'=>array(",$php_code);
        $php_code = preg_replace("/'(\d*)'/m","$1",$php_code);
        //$php_code = preg_replace("/'((?:\d+)?(?:.\d+)?)'/m","$1",$php_code);
        $php_code = preg_replace("/'true'/m","true",$php_code);
        $php_code = preg_replace("/'false'/m","false",$php_code);
        $php_code = str_replace("' => ,", "' => null,", $php_code);
        $php_code = str_replace("  ", "\t", $php_code);
        $php_code= $amp ." $php_code;\n";
        fwrite($fopen, $php_code);

    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_ip')) {


    function get_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) AND !empty($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        /*else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];*/
        else if (isset($_SERVER['HTTP_X_FORWARDED']) AND !empty($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']) AND !empty($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']) AND !empty($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER[HEADER_IP]) AND !empty($_SERVER[HEADER_IP]))
            $ipaddress = $_SERVER[HEADER_IP];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('prefix')) {

    function prefix()
    {
        $type = get_instance()->config['cabinet']['registration_login_prefix_type'];
        $letters = array("Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "A", "S", "D", "F", "G", "H", "J", "K", "L", "Z", "X", "C", "V", "B", "N", "M");
        $prefix = "";

        if ($type == 'PP_'){
            for ($i = 0; $i < 2; ++$i) {
                $prefix .= $letters[array_rand($letters)];
            }
            $prefix .= '_';
        }else{
            for ($i = 0; $i < 3; ++$i) {
                $prefix .= $letters[array_rand($letters)];
            }
        }
        return $prefix;

    }
}
if ( ! function_exists('is_https'))
{
    /**
     * Is HTTPS?
     *
     * Determines if the application is accessed via an encrypted
     * (HTTPS) connection.
     *
     * @return	bool
     */
    function is_https()
    {
        if ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
        {
            return TRUE;
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
        {
            return TRUE;
        }
        elseif ( ! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off')
        {
            return TRUE;
        }
        return FALSE;
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('form_hide_input')) {
    /**
     * Функция генерации скрытых полей для AJAX
     * @param string $class Имя класса. Пример: App\Modules\Globals\Project\Project&module
     * @param string $method Имя метода Пример: ajax_project_upload_settings
     * @param boolean $is_form Тип генерации данных
     * @return string HTML с скрытыми импутами
     */
    function form_hide_input($class , $method, $is_form = true)
    {

        if ($is_form){
            return '<input type="hidden" name="module_form" value="'.$class.'"><input type="hidden" name="module" value="'.$method.'">';
        }else{
            return http_build_query(array('module_form' => $class, 'module' => $method));
        }


    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('btn_ajax')) {
    /**
     * Функция генерации скрытых полей для кнопок AJAX. У кнопки должен стоять class .submit-btn
     * @param string $class Имя класса. Пример: App\Modules\Globals\Project\Project&module
     * @param string $method Имя метода Пример: ajax_project_upload_settings
     * @param array $param Массив данных для передачи
     * @param string $action URL куда будут отправлены данные
     * @return string Атрибуты для вставки HTML кнопки
     */
    function btn_ajax($class = null, $method = null, $param = array('e'=>0), $action = '/input')
    {

        if($class != null)
            $param['module_form'] = $class;
        if($method != null)
            $param['module'] = $method;

        $str = "";
        if(is_array($param) AND count($param))
            $str .= 'data-post="'.http_build_query($param).'" ';

        $str .= 'data-action="'.$action.'" ';

        return $str;

    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('captcha_check')) {

    function captcha_check(){

        $cfg = get_instance()->config['cabinet'];


        switch ($cfg['captcha']){
            case 'captcha':

                if (!isset($_SESSION['captcha'])) {
                    return false;
                }

                if ($_REQUEST["captcha"] == $_SESSION['captcha']) {
                    unset($_SESSION['captcha']);
                    return true;
                } else {
                    return false;
                }

                break;
            case 'recaptchav2':

                if(!isset($_POST['g-recaptcha-response']))
                    return false;

                if (empty($_POST['g-recaptcha-response']))
                    return false;

                $recaptcha = new \ReCaptcha\ReCaptcha($cfg['recaptcha_secret_key']);

                $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

                return $resp->isSuccess();

                break;
            case 'recaptchav3':

                if(!isset($_POST['captcha']))
                    return false;

                if (empty($_POST['captcha']))
                    return false;

                $recaptcha = new \ReCaptcha\ReCaptcha($cfg['recaptcha_secret_key']);

                $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                    ->setScoreThreshold(0.5)
                    ->verify($_POST['captcha'], $_SERVER['REMOTE_ADDR']);

                return $resp->isSuccess();

                break;
            case false:
                return true;
                break;
            default:
                return true;

        }

    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('captcha_reload')) {

    function captcha_reload($actions = 'sign_up'){

        $cfg = get_instance()->config['cabinet'];


        switch ($cfg['captcha']){
            case 'captcha':

                return "$('#captcha-img').attr('src','/captcha/img?'+Math.random());";

                break;
            case 'recaptchav2':

                return "grecaptcha.reset();";

                break;
            case 'recaptchav3':


                return "grecaptcha.ready(function() { grecaptcha.execute('".$cfg['recaptcha_public_key']."', { action: '".$actions."'}) .then(function(token) { $('#captcha').val(token); }); });";


                break;
            case false:
                return true;
                break;
            default:
                return 'console.log("Error captcha_reload");';

        }

    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_utm')) {

    function get_utm($type = false){

        $utm = array();

        if (isset($_GET["utm_source"])){
            $utm['utm_source'] = $_GET["utm_source"];
            setcookie("utm_source", $_GET["utm_source"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_source"])){
            $utm['utm_source'] = $_COOKIE["utm_source"];
        }

        if (isset($_GET["utm_medium"])) {
            $utm['utm_medium'] = $_GET["utm_medium"];
            setcookie("utm_medium", $_GET["utm_medium"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_medium"])){
            $utm['utm_medium'] = $_COOKIE["utm_medium"];
        }
        if (isset($_GET["utm_campaign"])) {
            $utm['utm_campaign'] = $_GET["utm_campaign"];
            setcookie("utm_campaign", $_GET["utm_campaign"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_campaign"])){
            $utm['utm_campaign'] = $_COOKIE["utm_campaign"];
        }

        if (isset($_GET["utm_content"])){
            $utm['utm_content'] = $_GET["utm_content"];
            setcookie("utm_content", $_GET["utm_content"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_content"])){
            $utm['utm_content'] = $_COOKIE["utm_content"];
        }

        if (isset($_GET["utm_term"])){
            $utm['utm_term'] = $_GET["utm_term"];
            setcookie("utm_term", $_GET["utm_term"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_term"])){
            $utm['utm_term'] = $_COOKIE["utm_term"];
        }

        if (isset($_GET["utm_referrer"])){
            $utm['utm_referrer'] = $_GET["utm_referrer"];
            setcookie("utm_referrer", $_GET["utm_referrer"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_referrer"])){
            $utm['utm_referrer'] = $_COOKIE["utm_referrer"];
        }


        if(isset($_SERVER['HTTP_REFERER']) AND !isset($_COOKIE['http_referrer'])){
            $utm['http_referrer'] = $_SERVER['HTTP_REFERER'];
            setcookie("http_referrer", $utm['http_referrer'], time() + 7776000, '/');
        }elseif(isset($_COOKIE['http_referrer'])) {
            $utm['http_referrer'] = $_COOKIE["http_referrer"];
        }

        if(isset($_SERVER['HTTP_REFERER']) AND !isset($_COOKIE['http_referrer_link'])){
            $rk = parse_url($_SERVER['HTTP_REFERER']);

            if(isset($rk['host']) AND !empty($rk['host'])){
                $utm['http_referrer_link'] = $rk['host'];
                setcookie("http_referrer_link", $rk['host'], time() + 7776000, '/');
            }elseif(isset($_COOKIE["http_referrer_link"])){
                $utm['http_referrer_link'] = $_COOKIE["http_referrer_link"];
            }
        }elseif(isset($_COOKIE['http_referrer_link'])) {
            $utm['http_referrer_link'] = $_COOKIE["http_referrer_link"];
        }

        //Кастомная метка специально вделенная под fingerprintjs
        if (isset($_GET["utm_fp"])){
            $utm['utm_fp'] = $_GET["utm_fp"];
            setcookie("utm_fp", $_GET["utm_fp"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_fp"])){
            $utm['utm_fp'] = $_COOKIE["utm_fp"];
        }

        //Кастомная метка специально вделенная под mmoweb
        if (isset($_GET["utm_mw"])){
            $utm['utm_mw'] = $_GET["utm_mw"];
            setcookie("utm_mw", $_GET["utm_mw"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["utm_mw"])){
            $utm['utm_mw'] = $_COOKIE["utm_mw"];
        }
        //Если клоуд фаир передает iso брать его и передовать
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY']))
            $utm['utm_iso'] = $_SERVER['HTTP_CF_IPCOUNTRY'];


        //Для гугл трекера
        if(isset($_COOKIE["_ga"])){
            $utm['_ga'] = $_COOKIE["_ga"];
        }

        //Кастомная для реферальныйх ссылок
        if (isset($_GET["referral"])){
            $utm['referral_mw'] = $_GET["referral"];
            setcookie("referral_mw", $_GET["referral"], time() + 7776000, '/');
        }elseif(isset($_COOKIE["referral_mw"])){
            $utm['referral_mw'] = $_COOKIE["referral_mw"];
        }


        if ($type == false)
            return $utm;
        else
            return isset($utm[$type]) ? $utm[$type] : false;
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('CloudFire')) {

    function CloudFire(){


        #CloudFire
        $cfIpRanges = array(
            '103.21.244.0/22',
            '103.22.200.0/22',
            '103.31.4.0/22',
            '104.16.0.0/12',
            '108.162.192.0/18',
            '131.0.72.0/22',
            '141.101.64.0/18',
            '162.158.0.0/15',
            '172.64.0.0/13',
            '173.245.48.0/20',
            '188.114.96.0/20',
            '190.93.240.0/20',
            '197.234.240.0/22',
            '198.41.128.0/17',
            '199.27.128.0/21',

        );
        $cidr_match = function ($ip, $range) {
            list ($subnet, $bits) = explode('/', $range);
            $ip = ip2long($ip);
            $subnet = ip2long($subnet);
            $mask = -1 << (32 - $bits);
            $subnet &= $mask;
            return ($ip & $mask) == $subnet;
        };
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            foreach ($cfIpRanges as $cfIpRange) {
                if ($cidr_match($_SERVER[HEADER_IP], $cfIpRange)) {
                    $_SERVER[HEADER_IP] = $_SERVER['HTTP_CF_CONNECTING_IP'];
                    break;
                }
            }
        }
        #CloudFire END
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('checkSID')) {

    function checkSID($sid){
        $server_list = get_instance()->config['project']['server_info'];

        foreach ($server_list as $game => $srv){
            if(isset($srv[$sid]) AND $srv[$sid]['status'])
                return true;
        }
        return false;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('reverse_parse_url')) {

    function reverse_parse_url(array $parts)
    {
        $url = '';
        if (!empty($parts['scheme'])) {
            $url .= $parts['scheme'] . ':';
        }
        if (!empty($parts['user']) || !empty($parts['host'])) {
            $url .= '//';
        }
        if (!empty($parts['user'])) {
            $url .= $parts['user'];
        }
        if (!empty($parts['pass'])) {
            $url .= ':' . $parts['pass'];
        }
        if (!empty($parts['user'])) {
            $url .= '@';
        }
        if (!empty($parts['host'])) {
            $url .= $parts['host'];
        }
        if (!empty($parts['port'])) {
            $url .= ':' . $parts['port'];
        }
        if (!empty($parts['path'])) {
            $url .= $parts['path'];
        }
        if (!empty($parts['query'])) {
            if (is_array($parts['query'])) {
                $url .= '?' . http_build_query($parts['query']);
            } else {
                $url .= '?' . $parts['query'];
            }
        }
        if (!empty($parts['fragment'])) {
            $url .= '#' . $parts['fragment'];
        }

        return $url;
    }
}
// ------------------------------------------------------------------------

if ( ! function_exists('detect_lang')) {

    function detect_lang(){
        global $URI;

        $config['language_abbr'] = select_lang();
        $config['sess_expiration'] = 36000000;

        $config_project = include ROOT_DIR . '/Library/config.php';

        if(isset($_SERVER['HTTP_HOST']) AND !empty($_SERVER['HTTP_HOST']))
            $pars_url = parse_url($_SERVER['HTTP_HOST']);
        elseif(isset($_SERVER['SERVER_NAME']) AND !empty($_SERVER['SERVER_NAME']))
            $pars_url = parse_url($_SERVER['SERVER_NAME']);
        else{
            $pars_url = parse_url($config_project['project']['url_site']);
        }

        $config['base_url'] = $config_project['project']['protocol_site'].'://'.$pars_url["path"].'/';

        $index_page    = '';//$config['index_page'];
        /* default language abbreviation */
        $lang_ignore   = !DETECT_LANG;
        /* set available language abbreviations */
        $default_abbr  = $config['language_abbr'];
        /* hide the language segment (use cookie) */
        $lang_uri_abbr = $config_project['site']['language_list'];

        /* get the language abbreviation from uri */
        $uri_abbr = $URI->segment(1);

        /* adjust the uri string leading slash */
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);

        if ($lang_ignore) {

            if (isset($lang_uri_abbr[$uri_abbr])) {

                /* set the language_abbreviation cookie */
                $_COOKIE['mw_lang'] = $uri_abbr;
                set_cookie('mw_lang', $uri_abbr, time() + $config['sess_expiration']);

            } else {

                /* get the language_abbreviation from cookie */
                $lang_abbr = get_cookie('mw_lang');

            }

            if (strlen($uri_abbr) == 2) {

                /* reset the uri identifier */
                $index_page .= empty($index_page) ? '' : '/';

                /* remove the invalid abbreviation */
                $URI->uri_string = preg_replace("|^\/?$uri_abbr\/?|", '', $URI->uri_string);
                if ($URI->uri_string == '/')
                    $URI->uri_string = '';

                $get_param = '';
                if(isset($_GET) AND count($_GET) > 0){
                    $get_param .= '?'.http_build_query($_GET);
                }

                /* redirect */
                header('Location: '.$config['base_url'].$index_page.$URI->uri_string.$get_param, TRUE, 301);
                exit;
            }

        } else {

            /* set the language abbreviation */
            $lang_abbr = $uri_abbr;
        }

        /* check validity against config array */

        if (isset($lang_uri_abbr[$lang_abbr]) AND !$lang_ignore) {

            /* reset uri segments and uri string */
            $segments_temp = $URI->segments;
            $segments_set = array_shift($segments_temp);

            if ($lang_abbr != $config['language_abbr']){

                $_COOKIE['mw_lang'] = $lang_abbr;
                set_cookie('mw_lang', $lang_abbr, time() + $config['sess_expiration']);

            }

            $segments[0] = null;
            foreach ($segments_temp as $seg){
                $segments[] = $seg;
            }
            unset($segments[0]);

            $URI->segments = $segments;
            $URI->segment($segments_set);

            $URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);


            /* set config language values to match the user language */
            $config['language_abbr'] = $lang_abbr;


            /* set the language_abbreviation cookie */
            // set_cookie('mw_lang', $lang_abbr, time() + $config['sess_expiration']);

        } else {

            /* if abbreviation is not ignored */
            if ( ! $lang_ignore) {

                /* check and set the uri identifier to the default value */
                $index_page .= empty($index_page) ? $default_abbr : "/$default_abbr";

                if (strlen($lang_abbr) == 2) {

                    /* remove invalid abbreviation */
                    $URI->uri_string = preg_replace("|^\/?$lang_abbr|", '', $URI->uri_string);

                }
                if ($URI->uri_string == '/')
                    $URI->uri_string = '';

                $get_param = '';
                if(isset($_GET) AND count($_GET) > 0){
                    $get_param .= '?'.http_build_query($_GET);
                }

                /* redirect */
                header('Location: '.$config['base_url'].$index_page.$URI->uri_string.$get_param, TRUE, 301);
                exit;
            }

            /* set the language_abbreviation cookie */
            $_COOKIE['mw_lang'] = $uri_abbr;
            set_cookie('mw_lang', $default_abbr, time() + $config['sess_expiration']);
        }

    }

}

if ( ! function_exists('get_cache')) {
    /**
     * Does the heavy lifting of actually retrieving the file and
     * verifying it's age.
     *
     * @param string $key
     * @param boolean $get_val
     * @param boolean $get_data
     * @param boolean $del_time_end
     *
     * @return boolean|mixed
     */
    function get_cache($key, $get_val = true, $get_data = false, $del_time_end = true)
    {

        $key = ROOT_DIR.CACHEPATH.'/' . $key . '.txt';

        if (! is_file($key))
        {
            return false;
        }

        $data = unserialize(file_get_contents($key));

        if ($data['ttl'] > 0 && time() > $data['time'] + $data['ttl'])
        {
            if ($del_time_end)
                unlink($key);

            if ($get_data){
                $data['cache_end'] = true;
                return $data;
            }else
                return false;
        }

        if ($get_val)
            return is_array($data) ? $data['data'] : false;
        else
            return $data;

    }
}


if ( ! function_exists('set_cache')) {

    /**
     * Saves an item to the cache store.
     *
     * @param string  $key   Cache item name
     * @param mixed   $value The data to save
     * @param integer $ttl   Time To Live, in seconds (default 60)
     *
     * @return mixed
     */
    function set_cache($key, $value, $ttl = 60)
    {
        $key = ROOT_DIR . CACHEPATH .'/' . $key . '.txt';

        $contents = array(
            'time' => time(),
            'ttl' => $ttl,
            'data' => $value,
        );


        $data = serialize($contents);

        if (($fp = @fopen($key, 'wb')) === false) {
            return false;
        }

        flock($fp, LOCK_EX);

        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($data, $written))) === false) {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        if (is_int($result)){
            chmod($key, 0640);
            return true;
        }else
            return false;

    }
}


if ( ! function_exists('check')) {
    /**
     * Restricts the number of requests made by a single IP address within
     * a set number of seconds.
     *
     * Example:
     *
     *  if (! $throttler->check($request->ipAddress(), 60, MINUTE))
     * {
     *      die('You submitted over 60 requests within a minute.');
     * }
     *
     * @param string $key The name to use as the "bucket" name.
     * @param integer $capacity The number of requests the "bucket" can hold
     * @param integer $seconds The time it takes the "bucket" to completely refill
     *
     * @return   boolean
     * @internal param int $maxRequests
     */

    function check($key, $capacity, $seconds)
    {
        $time = time();
        try {
            $db = get_instance()->db();
        }catch (\Exception $e){
            echo json_encode(array('text' => 'Error connecting to database'.DEBUG ? $e->getMessage() : '','status' => 'danger'));
            exit;
        }
        usleep(rand(50, 200));
        $STH = $db->prepare('SELECT COUNT(id) as `count` FROM mw_stop_spam WHERE ip=:ip AND `date` >= :time;');
        $STH->bindValue(':ip', $key, \PDO::PARAM_STR);
        $STH->bindValue(':time', $time - $seconds, \PDO::PARAM_INT);
        $STH->execute();
        $STH = $STH->fetch(\PDO::FETCH_ASSOC);
        //$STH

        if ((int)$STH["count"] >= $capacity){
            return false;
        }else{

            $STH = $db->prepare('INSERT INTO `mw_stop_spam` (`ip`,`date`) VALUES (:ip, :time);');
            $STH->bindValue(':ip', $key, \PDO::PARAM_STR);
            $STH->bindValue(':time', $time, \PDO::PARAM_INT);
            $STH->execute();
            return true;
        }

    }

}

if ( ! function_exists('_boolean')) {

    function _boolean($string){

        return filter_var($string, FILTER_VALIDATE_BOOLEAN);

    }

}

// ------------------------------------------------------------------------

if ( ! function_exists('startTime')) {

    function startTime()
    {
        $start_time = microtime();
        $start_array = explode(" ", $start_time);
        $start_time = $start_array[1] + $start_array[0];

        return $start_time;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('stopTime')) {

    function stopTime($start_time)
    {
        $end_time = microtime();
        $end_array = explode(" ", $end_time);
        $end_time = $end_array[1] + $end_array[0];
        $time = $end_time - $start_time;
        return "Запрос обработан за {$time} секунд";
    }
}


if ( ! function_exists('OnlineTime')) {

    function OnlineTime($inputSeconds)
    {

        if (empty($inputSeconds))
            return '-//-';

        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;

        $days = floor($inputSeconds / $secondsInADay);

        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        //$remainingSeconds = $minuteSeconds % $secondsInAMinute;
        //$seconds = ceil($remainingSeconds);

        /*$obj = array(
            'd' => (int) $days,
            'h' => (int) $hours,
            'm' => (int) $minutes,
            's' => (int) $seconds,
        );*/

        $str = '';
        if($days > 0){

            $str .= "$days d. ";
        }
        if($hours > 0){

            $str .= "$hours h. ";
        }

        if($minutes > 0 AND $days == 0){

            $str .= "$minutes m.";
        }
        return $str;
    }
}
//SHOP
if (!function_exists('get_shop_sale')) {

    function get_shop_sale($sale_id)
    {
        global $TEMP;

        //get_instance()->config['site']['time_zone'];
        if (isset($TEMP['shop_sale'][$sale_id]))
            return $TEMP['shop_sale'][$sale_id];

        $result = array(
            'status' => false,
            'start' => '',
            'end' => '',
            'sale' => 0,
            'name' => '',
            'timer' => false,
            'time_ribbon' => '',
            'date_step' => 0,
        );

        if (isset(get_instance()->shop['sale'][$sale_id])) {
            $sale = get_instance()->shop['sale'][$sale_id];

            if (strtotime($sale['start']) <= time() AND time() <= strtotime($sale['end'])){
                $result['status'] = true;
                $result['name'] = $sale['name'];
                $result['start'] = $sale['start'];
                $result['end'] = $sale['end'];
                $result['sale'] = (int)$sale['sale'];
                $result['timer'] =  $sale['timer'] == 1;
                $result['date_unix'] = strtotime($sale['end']);
                $result['date_step'] = $sale['step'] > 0 ? (time() + get_shop_step($sale['end'], (int) $sale['step'])) : 0;

                if ($sale['timer'] == 1){
                    if ($sale['step'] > 0)
                        $result['time_ribbon'] = '<div class="ribbon-box" title="'.$sale['name'].' - '.$sale['sale'].' %"><span data-sale-timer="'.($result['date_step']).'" data-sale-date="0">00:00:00</span> - '.$sale['sale'].' %</div>';
                    else
                        $result['time_ribbon'] = '<div class="ribbon-box" title="'.$sale['name'].' - '.$sale['sale'].' %"><span data-sale-timer="'.$result['date_unix'].'" data-sale-date="'.((($result['date_unix'] - 86000) > time()) ? 1 : 0).'">00:00:00</span> - '.$sale['sale'].' %</div>';
                }else
                    $result['time_ribbon'] = '<div class="ribbon-box" title="'.$sale['name'].' - '.$sale['sale'].'% - End: '.$sale['end'].'">'.$sale['name'].' - '.$sale['sale'].' %</div>';
            }
        }

        $TEMP['shop_sale'][$sale_id] = $result;

        return $result;
    }
}

if (!function_exists('get_shop_step')) {
    function get_shop_step($time, $step)
    {
        if (is_string($time))
            $time = strtotime($time);

        $end = $time - time();
        while ($end > ($step * 3600)) {
            $end = $end - ($step * 3600);
        }
        return $end;
    }
}

if (!function_exists('percentage')) {
    function percentage($sum, $percent)
    {
        return $sum - ($sum * $percent / 100);
    }
}


if (!function_exists('remove_emoji')) {
    function remove_emoji($string) {

        $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clear_string = preg_replace($regex_emoticons, '', $string);

        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clear_string = preg_replace($regex_symbols, '', $clear_string);

        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clear_string = preg_replace($regex_transport, '', $clear_string);

        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $clear_string = preg_replace($regex_misc, '', $clear_string);

        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $clear_string = preg_replace($regex_dingbats, '', $clear_string);

        return $clear_string;
    }
}

if (!function_exists('log_write')){

    function log_write($file, $data, $date_add = true, $eol = PHP_EOL){

        if($date_add)
            $file .= date("m.d.y");

        $new_file = false;
        $msg = '';

        if ( ! file_exists(ROOT_DIR."/Debug/log_" . $file . ".php"))
            $new_file = true;

        $fw = fopen(ROOT_DIR."/Debug/log_" . $file . ".php", "a+");

        if($new_file)
            $msg .= "<?php defined('ROOT_DIR') OR exit('No direct script access allowed'); ?>".PHP_EOL;

        $msg .= $data.$eol;

        fwrite($fw, $msg);
        fclose($fw);

        return $data;
    }

}

if (!function_exists('check_pin')){

    function check_pin($type = false){

        $settings = get_instance()->settings_pin;
        $pin_shield = get_instance()->config['cabinet']['pin_shield'];
        $user_shield = get_instance()->session->checkShield();

        if ($pin_shield){
            if ($type === false)
                return _boolean($user_shield);
            else{

                if (isset($settings[$type])){

                    if (isset(get_instance()->config['cabinet'][$type]) AND get_instance()->config['cabinet'][$type] === false)
                        return false;
                    else{
                        if ($settings[$type])
                            return true;
                        else
                            return _boolean($user_shield);
                    }
                }
                return _boolean($user_shield);
            }
        }else
            return false;

    }

}

if (!function_exists('get_class_name')) {
    function get_class_name($class_id, $lib = 'lineage2db')
    {
        global $TEMP;

        if (!isset($TEMP[$lib]) AND file_exists(ROOT_DIR . "/Library/{$lib}.php")) {
            $TEMP[$lib] = include_once ROOT_DIR . "/Library/{$lib}.php";
        }

        if (isset($TEMP[$lib]['prof'][$class_id]))
            return $TEMP[$lib]['prof'][$class_id];
        else
            return 'N/A';
    }
}

if (!function_exists('get_augmentation')) {
    function get_augmentation($aug_id, $lib = 'lineage2db_augmentation')
    {
        global $TEMP;

        if (empty($aug_id))
            return '';

        if (!isset($TEMP[$lib]) AND file_exists(ROOT_DIR . "/Library/{$lib}.php")) {
            $TEMP[$lib] = include_once ROOT_DIR . "/Library/{$lib}.php";
        }

        if (isset($TEMP[$lib]['augmentation'][$aug_id]))
            return $TEMP[$lib]['augmentation'][$aug_id];
        else
            return 'N/A';
    }
}

if (!function_exists('get_translation')) {
    function get_translation($str, $language_file = 'market.lang')
    {
        global $TEMP;

        if (empty($str))
            return '';

        if (!isset($TEMP['get_translation'])) {
            $TEMP['get_translation'] = get_lang($language_file);
        }

        if (isset($TEMP['get_translation'][$str]))
            return $TEMP['get_translation'][$str];
        else
            return $str;
    }
}

if ( ! function_exists('qplay_decrypt')) {

    function qplay_decrypt($data, $decrypt_key)
    {
        $data = base64_decode($data);
        $l = strlen($decrypt_key);
        ///выравнивание по размеру ключа
        if ($l < 16) $decrypt_key = str_repeat($decrypt_key, ceil(16 / $l));
        ///собственно дешифрование
        $val = openssl_decrypt($data, 'BF-ECB', $decrypt_key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);

        return $val;
    }

}


if ( ! function_exists('UpdateFinishCallback')) {

    function UpdateFinishCallback($updatedVersion, $sim)
    {
        $directory = ROOT_DIR . '/install';
        if (is_dir($directory)){
            if ($sim == false) {
                $files = scandir($directory);
                $files = array_diff($files, array('.', '..'));
                foreach ($files as $key => $name) {
                    if (file_exists($directory . $name) and is_file($directory . $name)) {
                        if (strripos($name, '.php') !== false) {
                            include $directory . $name;
                        }
                    }
                }
            }
            deleteDirectory($directory);
        }
    }
}


if ( ! function_exists('deleteDirectory')) {

    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }
}