<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
  * Date: 06.10.2015
 ********************************/

use ApiLib\GlobalApi;

if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}

class Panel extends Controller {

    public function __construct()
    {
        parent::__construct();
        //Проверка на тех работы
        if ($this->config['cabinet']['status_cabinet_jobs'] AND !in_array('panel-reconstruction' ,$this->url->segment_array())) {
            $redirect = true;
            //Блок проверки на ип исключения
            if (!empty($this->config['cabinet']['ip_cabinet_exceptions'])){
                $ip_list = explode(',', $this->config['cabinet']['ip_cabinet_exceptions']);
                if (in_array(get_ip(), $ip_list))
                    $redirect = false;

            }

            if ($redirect){
                header('Location: /panel-reconstruction', TRUE, 301);
                die;
            }
        }

        get_instance()->session->isLogin();


        //проверяем на отключение страницы

        $rules = $this->session->isLogin ? $this->config['project']['server_menu'][$this->get_sid()] : $this->config['cabinet']['page_active_no_auth'];

        $rules['sign-in'] = true;
        $rules['sign-up'] = true;
        $rules['reminder'] = true;
        $rules['logout'] = true;
        $rules['panel-reconstruction'] = true;
        $rules['panel'] = true;
        if (ADMIN_PANEL) {
            $rules['admin'] = true;
        }
        if(!in_array($this->url->segment(1) ,array_keys($rules)))
            show_404();

    }


    public function main(){

        if (!$this->session->isLogin()) {
            header('Location: /sign-in', TRUE, 301);
            die;
        }

        //var_dump(get_lang('auth.menu'));
        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT' => parse_row($this->render_data['content']),

                ),
                get_lang('login.menu.lang')
            )
        );


    }

    public function logout(){

        delete_cookie('id_mw');
        header('Location: /sign-in', TRUE, 301);
        die;
    }

    public function rating(){

        /**@var $rating \Modules\Globals\Statistic\Statistic*/
        $rating = $this->getModule('Modules\Globals\Statistic\Statistic');


        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT' => $rating->onRequest(),
                ),
                get_lang('login.menu.lang')
            )
        );

    }

    public function shop($s1 = false, $s2 = false, $s3 = false){

        if ($this->session->isLogin()) {
            header('Location: /panel/shop', TRUE, 301);
            die;
        }

        /**@var $donations \Modules\Plugins\Shop\Shop*/
        $donations = $this->getModule('Modules\Plugins\Shop\Shop');

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT' => $donations->onRequestShop($s1 , $s2, $s3),
                ),
                get_lang('login.menu.lang')
            )
        );


    }

    public function donations(){

        if ($this->session->isLogin()) {
            header('Location: /panel/donations', TRUE, 301);
            die;
        }


        /**@var $donations \Modules\Globals\Donations\Donations*/
        $donations = $this->getModule('Modules\Globals\Donations\Donations');

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT' => $donations->onRequest(),
                ),
                get_lang('login.menu.lang')
            )
        );

    }

    public function signin(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT_FULL' => $this->fenom->fetch("panel:signin.tpl",
                        array_merge(
                            array(
                                'config' => $this->config
                            ),
                            get_lang('signin.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );

    }


    public function signup(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }


        if($this->config['cabinet']['registration_login_prefix']) {
            if(isset($_SESSION['prefix_list']))
                unset($_SESSION['prefix_list']);

            $i = 0;
            while ($i < $this->config['cabinet']['registration_login_prefix_count']) {
                $i++;
                $_SESSION['prefix_list'][] = prefix();
            }
        }

        //get_instance()->seo->addTeg('head', 'telInput', 'link', ['rel'=>'stylesheet', 'href'=>'/template/panel/assets/css/intl-telInput/intlTelInput.css?ver=0.1']);
        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:signup.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                                'prefix_list' => @$_SESSION['prefix_list']
                            ),
                            get_lang('signup.lang')
                        )
                    ),
                    '_FOOTER' => false,

                ),
                get_lang('login.menu.lang')
            )
        );
    }

    public function signup_activation(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }
        if (!isset($_SESSION['signup'])) {
            header('Location: /sign-up', TRUE, 301);
            die;
        }
        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:signup/signup_activation.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                            ),
                            get_lang('signup.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );

    }

    public function signup_completed(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }
        if (!isset($_SESSION['signup'])) {
            header('Location: /sign-up', TRUE, 301);
            die;
        }
        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:signup/signup_completed.tpl",
                        get_lang('signup.lang')
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );


    }

    public function signup_code($code){

        $cfg = get_instance()->config['cabinet'];

        //Проверяем сессию если авторизован то переноправляем в кабинет
        if ($this->session->isLogin() ){
            header('Location: /panel', TRUE, 301);
            die;

            //Проверяем ключь по регулярке
        }elseif ($cfg['registration_confirmation'] == false OR !preg_match("/^[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}+-[_\.0-9a-z-]{4}$/i", $code)){
            header('Location: /sign-up', TRUE, 301);
            die;
        }



        $api = new GlobalApi();
        $vars = array();

        $vars["type"] = 'code';
        $vars["code"] = $code;

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

        }else
            $error = 1;


        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:signup/signup_code.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                                'message' => $msg,
                                'response_error' => $error,
                            ),
                            get_lang('signup.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );


    }

    public function reminder(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reminder.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                            ),
                            get_lang('reminder.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );
    }

    public function reminder_email(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reminder/reminder_email.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                            ),
                            get_lang('reminder.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );

    }

    public function reminder_phone(){

        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reminder/reminder_phone.tpl",
                        array_merge(
                            array(
                                'config' => $this->config,
                            ),
                            get_lang('reminder.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );

    }

    public function reminder_email_code($code){


        if ($this->session->isLogin()) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(

                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reminder/reminder_email_code.tpl",
                        array_merge(
                            array(
                                'code' => $code,
                                'config' => $this->config,
                            ),
                            get_lang('reminder.lang')
                        )
                    ),
                    '_FOOTER' => false,
                ),
                get_lang('login.menu.lang')
            )
        );
    }

    public function panel_reconstruction(){

        if ($this->config['cabinet']['status_cabinet_jobs'] == false) {
            header('Location: /panel', TRUE, 301);
            die;
        }

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reconstruction.tpl",
                        array(
                            'message' => $this->config['cabinet']['status_cabinet_jobs_msg'],
                        )
                    ),

                    '_PAGE_CONTENT_CLASS' => 'main-content-boxed',
                    '_MENU' => false,
                    '_FOOTER' => false,

                ),
                get_lang('reconstruction.lang')
            )
        );

    }

    public function admin($s1 = false,$s2 = false ){

        //авторизация в админ панель
        if(isset($_POST['login']) AND isset($_POST['password'])){
            if ($_POST['login'] == ADMIN_LOGIN AND $_POST['password'] == ADMIN_PASSWORD){
                $_SESSION['ADMIN'] = true;
                echo $this->ajaxmsg->notify(get_lang('signin.admin.lang')['signin_ajax_success_login'], '/admin')->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('signin.admin.lang')['signin_ajax_error_login'])->danger();
            return;
        }

        if (isset($_SESSION['ADMIN']) AND $_SESSION['ADMIN'] == true) {

            $admin = new Admin($this->fenom, $this->ajaxmsg, $this->config);
            $content_full = $admin->init($s1, $s2);

        }else{
            $content_full = $this->fenom->fetch("panel:admin/signin.tpl", get_lang('signin.admin.lang') );
        }

        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT_FULL' => $content_full,
                    '_FOOTER' => true,

                ),
                get_lang('admin.lang')
            )
        );

    }

}