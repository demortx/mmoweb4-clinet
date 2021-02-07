<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
 ********************************/
if (!defined('ROOT_DIR')) {
    exit ("Error, wrong way to file.<a href=\"/\">Go to main</a>.");
}


class Controller
{

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;

    /**
    Переменная хранения данных с загруженых модулей
    */
    public $render_data = array(
        'settings' => array(),
        'search' => array(),
        'content' => array(),

    );
    /** @var Fenom $fenom */
    public $fenom;
    public $ajaxmsg = null;
    /**
     * @var $seo \SeoX
     */
    public $seo = null;


    public $language = null;
    public $select_lang = null;

    public $config = null;
    public $shop = null;
    public $market = null;

    /* Project ID*/
    public $pid = null;
    /* Server ID*/
    public $sid = null;
    /* Game type*/
    public $type_platform = null;

    //route
    public $route;
    public $url;


    //module
    public $module = array();
    //выгрузка ajax методов
    public $ajax_data = null;
    //User session main class
    public $session = null;

    //Режим редактирования
    public $ip_cabinet_exceptions = array();


    //настройка пин кода
    public $settings_pin = array(
        "pins_change_password_account"  => true,
        "pins_forgot_password_account"  => true,
        "pins_change_pwd_ma"            => true,
        "pins_bind_telegram"            => true,
        "pins_bind_email_send_code"     => true,
        "pins_bind_phone_send_code"     => true,
        "pins_manager_add"              => true,
        "pins_market_sell_item"         => true,
        "pins_market_sell_char"         => true,
        "pins_market_withdrawal"        => true,
        "pins_market_buy_shop"          => true,
        "pins_delete_bind_phone"        => true,

    );


    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct()
    {
        global $URI, $RTR;
        self::$instance =& $this;

        $this->config = include ROOT_DIR . '/Library/config.php';

        if (file_exists(ROOT_DIR . '/Library/shop.php'))
            $this->shop = include ROOT_DIR . '/Library/shop.php';

        if (file_exists(ROOT_DIR . '/Library/market.php'))
            $this->market = include ROOT_DIR . '/Library/market.php';


        if (!is_array($this->config))
            $this->config = array();
        //Сортируем список серверов
        $this->sortable_server_list();


        if($this->config['project']['protocol_site'] == 'https' AND !is_https() AND HTTP_FORWARDING){
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit;
        }

        //устанавливаем тайм зону
        date_default_timezone_set($this->config['site']['time_zone']);

        /**@var $route Router()*/
        $this->route = &$RTR;
        /**@var $url URI()*/
        $this->url = &$URI;

        //Объявляем переменные

        $this->select_lang = select_lang();

        $this->pid = (int) $this->config['pid'];

        $this->ajaxmsg = new \AjaxMsg();
        $this->seo = new \SeoX($this->select_lang, $this->url->uri_string());
        //Создаем сессию
        $this->session = new \User($this->config);

        if($this->session->isLogin()){
            //считываем сервер ид и платформу и принудительно меняем значения в COOKIE
            $this->sid = $_COOKIE['mw_sid'] = $this->session->getSid();
            $this->type_platform = $_COOKIE['mw_platform'] = $this->session->getPlatform();
        }else{
            $this->sid = (int) get_sid();
            $this->type_platform = get_platform();
        }


        $this->fenom = Fenom::factory(ROOT_DIR . VIEWPATH, ROOT_DIR . VIEWPATH . '/compiled');

        if (DEBUG)#TODO раскоментировать AUTO_STRIP
            $this->fenom->setOptions(/*Fenom::AUTO_STRIP |*/ Fenom::AUTO_RELOAD | Fenom::FORCE_COMPILE);
        else
            $this->fenom->setOptions(Fenom::AUTO_STRIP);

        $this->fenom->addProvider("panel", new Fenom\Provider(ROOT_DIR . VIEWPATH . '/panel/'), ROOT_DIR . VIEWPATH . '/compiled');

        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/Info.php'))
            $this->fenom->addProvider("site", new Fenom\Provider(ROOT_DIR.TEMPLATE_DIR.'/'), ROOT_DIR . VIEWPATH . '/compiled');

        $this->fenom->addAccessorSmart("site", "data", Fenom::ACCESSOR_PROPERTY);


        $this->fenom->data = array(
            '_LANG' =>  select_lang(),
            "to_year" => date("Y"),
            "dir_panel" => VIEWPATH.'/panel',
            "dir_site" => TEMPLATE_DIR,
            "config" => $this->config,
            "session" => &$this->session,
            "url_segment" => $this->url->segment_array(),
            "uri_string" => $URI->uri_string,
            "visualization" => $this->config['visualization'],
            "_SEO" => &$this->seo,
        );


        //Основная загрузка модулей
        $scan_module = $this->scan_dir_module(ROOT_DIR.'/Modules');

        foreach ($scan_module as $category => $folder_module){
            if(is_array($folder_module) AND count($folder_module)){
                foreach ($folder_module as $name_module => $__temp){
                    $class = "Modules\\$category\\$name_module\\$name_module";
                    if (class_exists($class) AND !in_array($class, $this->module))
                        $this->module[$class] = new $class;
                }
            }
        }

        $this->loud_modules($this->module);

    }

    public function getModule($name_class){

        if (isset($this->module[$name_class]))
            return $this->module[$name_class];
        else
            return false;
    }

    // --------------------------------------------------------------------

    /**
     * @return PDO
     */
    public function db(){
        global $TEMP;
        if (isset($TEMP['DB']))
            return $TEMP['DB'];
        else {
            $TEMP['DB'] = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
            return $TEMP['DB'];
        }
    }

    public function loud_modules(array $install_modules)
    {

        if (is_array($install_modules)) {
            foreach ($install_modules as $module => $obj) {
                $obj->onLoad();
            }

        }

        if ((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'))
            $this->ajax_main_loud($install_modules);
        else
            $this->render_main_loud($install_modules);

    }

    public function is_render_content($renderWindow)
    {
        //Поиск ключа из масива $renderWindow по регулярному вырожению. возврошает ключ масива

        if (is_array($renderWindow)) {
            foreach ($renderWindow as $href => $value) {
                if (preg_match('/' . str_replace('/', '\/', $href) . '+$/', '/' . $this->url->uri_string()))
                    return $href;
            }
        }
        return false;
    }
    #TODO Реализовать рендеринг модулей
    public function render_main_loud(array $install_modules)
    {
        foreach ($install_modules as $module => $obj) {


            if ($href = $this->is_render_content($obj->renderWindow())) {
                //отрисовка по найденому урл регулярному выражению
                if (isset($this->render_data['content'][$href]))
                    $this->render_data['content'][$href] = array_merge_recursive($this->render_data['content'][$href], $obj->renderWindow()[$href]);
                else
                    $this->render_data['content'][$href] = $obj->renderWindow()[$href];
            }


            $this->render_data['side'][] = $obj->renderSide();


        }
    }

    public function ajax_main_loud(array $install_modules)
    {

        foreach ($install_modules as $module => $obj) {
            $this->ajax_data[$obj->info()['class']] = $obj->onAjax();
        }
    }

    public function scan_dir_module($dir) {

        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $result[$value] = $this->scan_dir_module($dir . DIRECTORY_SEPARATOR . $value);
                }
            }
        }

        return $result;
    }


    /**
     * Глобальные функции
     * get_pid
     * get_secret_key
     * get_session
     * get_sid
     * get_lang
     */

    public function get_pid(){
        return $this->pid;
    }
    public function get_secret_key(){
        return $this->config['project']['secret_key'];
    }
    public function get_session(){
        return $this->session->isLogin() ? $this->session->getSessionId() : false;
    }
    public function get_sid(){
        return $this->sid;
    }
    public function get_lang(){
        return $this->select_lang;
    }
    public function get_platform(){
        return $this->type_platform;
    }

    public function set_sid($sid, $set_cookie = true){

        if ($this->sid != $sid) {
            if (is_array($this->config['project']['server_info'])) {
                foreach ($this->config['project']['server_info'] as $platform => $server_list) {
                    if (isset($server_list[$sid]) AND $server_list[$sid]['status'] == true) {
                        $this->sid = $sid;
                        $this->set_platform($platform);
                        if ($set_cookie) {
                            set_platform($platform);
                            set_sid($this->sid);
                        }
                        break;
                    }
                }
            }
        }
    }

    public function set_platform($platform){
        $this->type_platform = $platform;
    }



    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }

    /**
     * Метод проверки активности плагина
     * @param $name
     * @return bool
     */
    public function check_plugin($name){
        if (is_array($this->config['plugins']))
            return in_array($name, $this->config['plugins']);
        else
            return false;
    }

    /**
     * Метод проверки состоянии плагина
     * @param $name
     * @return bool
     */
    public function status_plugin($name){

        if (isset($this->config['project']['server_plugins'][$this->sid][$name])){
            return $this->config['project']['server_plugins'][$this->sid][$name];
        }else
            return false;

    }

    /**
     * сортировка серверов
     */
    public function sortable_server_list(){

        if (is_array($this->config['project']['server_sort']) AND count($this->config['project']['server_sort']) > 0) {

            foreach ($this->config['project']['server_sort'] as $platform_ => $server_sort) {
                $temp_server_list = array();
                ksort($server_sort);
                foreach ($server_sort as $key => $ids) {
                    $temp_server_list[$ids] = $this->config['project']['server_info'][$platform_][$ids];
                    unset($this->config['project']['server_info'][$platform_][$ids]);
                }
                if (isset($this->config['project']['server_info'][$platform_])
                    AND is_array($this->config['project']['server_info'][$platform_])
                    AND count($this->config['project']['server_info'][$platform_]) > 0) {
                    foreach ($this->config['project']['server_info'][$platform_] as $ids => $set)
                        $temp_server_list[$ids] = $set;

                }
                $this->config['project']['server_info'][$platform_] = $temp_server_list;
                unset($temp_server_list);

            }
        }
    }

    /** {include $.php.get_tpl_file('breadcrumb.tpl')}
     * Рендер шаблона
     */
    public function initTPL($param){

        $page_container_class = '';
        $menu = '';
        if (!isset($param['_PAGE_CONTENT_CLASS'])) {
            if ($this->session->isLogin) {
                //Определяем стили
                if ($menu = $this->config['visualization']['cabinet_layout_login'] == 'left') {
                    $page_container_class = 'sidebar-o side-scroll page-header-modern main-content-boxed enable-page-overlay';
                    if ($this->config['visualization']['cabinet_layout_login_color_menu'] == 'dark') $page_container_class .= ' sidebar-inverse';
                } else {
                    $page_container_class = 'sidebar-inverse side-scroll main-content-boxed enable-page-overlay side-trans-enabled';
                    if ($this->config['visualization']['cabinet_layout_login_color_menu'] == 'dark') $page_container_class .= ' sidebar-inverse black';
                }
                if ($this->config['visualization']['cabinet_layout_login_menu_fixed'] == 'fixed') $page_container_class .= ' page-header-fixed';
                //Конец определения стилей

            } else {
                //Определяем стили
                if ($menu = $this->config['visualization']['cabinet_layout_no_login'] == 'left') {
                    $page_container_class = 'sidebar-o side-scroll page-header-modern main-content-boxed enable-page-overlay';
                    if ($this->config['visualization']['cabinet_layout_no_login_color_menu'] == 'dark') $page_container_class .= ' sidebar-inverse';
                } else {
                    $page_container_class = 'sidebar-inverse side-scroll main-content-boxed enable-page-overlay side-trans-enabled';
                    if ($this->config['visualization']['cabinet_layout_no_login_color_menu'] == 'dark') $page_container_class .= ' sidebar-inverse black';
                }
                if ($this->config['visualization']['cabinet_layout_no_login_menu_fixed'] == 'fixed') $page_container_class .= ' page-header-fixed';
                //Конец определения стилей
            }
        }
        if (!isset($param['_MENU'])) {
            if ($menu == 'left')
                $menu = $this->fenom->fetch(get_tpl_file('menu_left.tpl'), get_lang('login.menu.lang'));
            else
                $menu = $this->fenom->fetch(get_tpl_file('menu_top.tpl'), get_lang('login.menu.lang'));
        }


        $this->fenom->display(get_tpl_file('index.tpl'),
            array_merge(
                array(
                    '_PAGE_CONTENT_CLASS' => $page_container_class,
                    '_PAGE_CONTENT_CLASS_ADD' => '',
                    '_MENU' => $menu,
                    '_CONTENT_FULL' => '',
                    '_FOOTER' => true,
                    '_SEO_HEAD' => $this->seo->getHead(),
                    '_SEO_BODY' => $this->seo->getBody(),
                    '_SEO_FOOTER' => $this->seo->getFooter(),
                    '_IFRAME' => false

                ),
                $param
            )
        );


    }

}