<?php

namespace Template;
trait Pages {

    /**
     * Callback _construct
     */
    public function tpl__construct(){
        //Пример кастомного тега вызывается в шаблоне {test_func}  - создается в SiteComponents.php в корне шаблона
        $this->fenom->addFunctionSmart('test_func', 'Template\SiteComponents::test_func');
        $this->fenom->addFunctionSmart('get_cache_online', 'Template\SiteComponents::get_cache_online');
        //произвольный код _construct

    }

    /**
     * Контролер главной страницы
     */
    public function index(){
        //Перезагружаем заголовки и файлы
        $this->seo->loudSite();


        $this->TPL(
            array()
        );
    }


    /**
     * Рендер шаблона
     */
    public function TPL($param){


        $this->fenom->display("site:index.tpl",
            array_merge(
                array(
                    '_CONTENT' => '',
                    '_SEO_HEAD' => $this->seo->getHead(),
                    '_SEO_BODY' => $this->seo->getBody(),
                    '_SEO_FOOTER' => $this->seo->getFooter(),
                    '_LANG' => select_lang(),
                ),
                loud_lang_site(),//Загрузка языка сайта из шаблона
                $param
            )
        );


    }
}