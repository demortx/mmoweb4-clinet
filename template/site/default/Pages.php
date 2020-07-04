<?php

namespace Template;
trait Pages {

    public function __construct()
    {
        parent::__construct();
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