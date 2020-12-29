<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
  * Date: 06.10.2015
 ********************************/
if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}

class Pages extends Controller {
    use Template\Pages;


    public function __construct()
    {
        parent::__construct();

        if ($this->config['site']['status'] == 0) {
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }

        //если в шаблоне нет info.php он не является шаблоном
        if (!file_exists(ROOT_DIR.TEMPLATE_DIR.'/Info.php')){
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }

        //сайт находится на реконструкции
        //the site is under reconstruction

        if ($this->config['site']['status_site_jobs'] AND !in_array('site-reconstruction' ,$this->url->segment_array())) {
            $redirect = true;
            if (!empty($this->config['site']['ip_site_exceptions'])){
                $ip_list = explode(',', $this->config['site']['ip_site_exceptions']);
                if (in_array(get_ip(), $ip_list))
                    $redirect = false;

            }

            if ($redirect){
                header('Location: '.set_url('/site-reconstruction', false), TRUE, 301);
                die;
            }
        }

        //Объявляем компоненты сайта
        $this->fenom->addFunctionSmart('news', 'SiteComponents::News');
        $this->fenom->addFunctionSmart('forum', 'SiteComponents::Forum');
        $this->fenom->addFunctionSmart('rating', 'SiteComponents::Rating');
        $this->fenom->addFunctionSmart('server', 'SiteComponents::Server');
        $this->fenom->addFunctionSmart('streams', 'SiteComponents::Streams');
        $this->fenom->addFunctionSmart('language', 'SiteComponents::Language');
        $this->fenom->addFunctionSmart('iblock', 'SiteComponents::IBlock');

    }

    public function page_static($s1 = false, $s2 = false){

        $s1 = trim(strtolower($s1));

        if (in_array($s1, array('page_static', 'initTPL', 'index')))
            show_404();


        $s2 = trim(strtolower($s2));
        $s1_this = str_replace('-', '_', $s1);
        if (in_array($s1_this, array('page_static', 'initTPL', 'index')))
            show_404();

        if(method_exists($this, $s1_this)){
            //Перезагружаем заголовки и файлы
            $this->seo->loudSite();

            $this->$s1_this($s2);
        }else{

            if (is_dir(ROOT_DIR.CACHEPATH.'/Pages')) {
                $page = $s1;

                if($s2 != false)
                    $page .='_'.$s2;

                if (file_exists(ROOT_DIR . CACHEPATH . '/Pages/' . $page . '.json')) {

                    $json = file_get_contents(ROOT_DIR.CACHEPATH.'/Pages/'.$page.'.json');
                    $json = json_decode($json, true);

                    if (_boolean($json['show'])) {

                        $page = get_lang($json['page']);
                        if($json['template'] == 'site'){
                            //Перезагружаем заголовки и файлы
                            $this->seo->loudSite();
                            $_CONTENT = $this->fenom->fetch("site:static.tpl",
                                array(
                                    'title' => $page["title"],
                                    'content' => $page["body"],
                                )
                            );
                        }else {
                            $_CONTENT = $this->fenom->fetch("panel:static.tpl",
                                array(
                                    'title' => $page["title"],
                                    'content' => $page["body"],
                                )
                            );
                        }


                        if (isset($page["meta_title"]) AND !empty($page["meta_title"])) {
                            $this->seo->addSeoTeg( 'title', 'title', array('content' => $page["meta_title"]));
                            $this->seo->addSeoTeg( 'og_title', 'meta', array('property' => 'og:title', 'content' => $page["meta_title"]));
                        }

                        if (isset($page["meta_description"]) AND !empty($page["meta_description"])) {
                            $this->seo->addSeoTeg( 'desc', 'meta', array('name' => 'description', 'content' => $page["meta_description"]));
                            $this->seo->addSeoTeg( 'og_desc', 'meta', array('property' => 'og:description', 'content' => $page["meta_description"]));
                            $this->seo->addSeoTeg( 'tw_desc', 'meta', array('property' => 'twitter:description', 'content' => $page["meta_description"]));
                        }

                        if (isset($page["meta_keywords"]) AND !empty($page["meta_keywords"])) {
                            $this->seo->addSeoTeg( 'keywords', 'meta', array('name' => 'keywords', 'content' => $page["meta_keywords"]));
                        }
                    }
                }
            }
            if (!isset($_CONTENT)){
                header("HTTP/1.0 404 Not Found");
                $_CONTENT = error_404_html();
            }

            if(isset($json['template']) AND $json['template'] == 'site') {
                $this->TPL(
                    array(
                        '_CONTENT' => $_CONTENT,
                    )
                );
            }else{
                $this->initTPL(
                    array_merge(
                        array(
                            '_CONTENT' => $_CONTENT,
                            '_PAGE_CONTENT_CLASS' => 'main-content-boxed',
                            '_FOOTER' => true,
                        ),
                        get_lang('login.menu.lang')
                    )
                );

            }
        }

    }


    public function site_reconstruction(){

        if ($this->config['site']['status_site_jobs'] == false) {
            header('Location: /', TRUE, 301);
            die;
        }
        $this->initTPL(
            array_merge(
                array(
                    '_CONTENT_FULL' => $this->fenom->fetch("panel:reconstruction.tpl",
                        array(
                            'message' => $this->config['site']['status_site_jobs_msg'],
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

}