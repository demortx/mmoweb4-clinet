<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 12.02.2020
 * Time: 21:24
 */

return array(
    'ru' => [
        'init' => [
            'head' => array(
                ['idx' => 'charset', 'typex' => 'meta', 'charset' => 'utf-8'],
                ['idx' => 'viewport', 'typex' => 'meta', 'name' => 'viewport', 'content' => 'width=device-width'],
                ['idx' => 'favicons', 'typex' => 'link', 'rel' => 'shortcut icon', 'href' => TEMPLATE_DIR.'/images/favicon.ico'],
            ),
            'body' => array(),
            'footer' => array(
                //<!-- Get-Web Libs  -->
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/libs/jquery/jquery-3.4.1.js'],
                ['idx' => 'jquery', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => TEMPLATE_DIR.'/libs/fontello/css/fontello.css'],
                ['idx' => 'jquery', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => TEMPLATE_DIR.'/fonts/BeaufortforLOL/fonts.css'],
                //<!-- fancybox -->
                ['idx' => 'jquery', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => TEMPLATE_DIR.'/libs/fancybox/css/jquery.fancybox.min.css'],
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/libs/fancybox/js/jquery.fancybox.min.js'],
                //<!-- circle-progress -->
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/libs/circle-progress/js/circle-progress.min.js'],
                //<!-- countdown -->
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/libs/countdown/js/jquery.plugin.min.js'],
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/libs/countdown/js/jquery.countdown.min.js'],

                //<!-- Main style -->
                ['idx' => 'jquery', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => TEMPLATE_DIR.'/css/style.css?ver=' . filemtime(ROOT_DIR.TEMPLATE_DIR.'/css/style.css')],
                //<!-- Adaptation style -->
                ['idx' => 'jquery', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => TEMPLATE_DIR.'/css/adaptation.css?ver=' . filemtime(ROOT_DIR.TEMPLATE_DIR.'/css/adaptation.css')],
                //<!-- Main app -->
                ['idx' => 'jquery', 'typex' => 'script', 'src' => TEMPLATE_DIR.'/js/app.js?ver=' . filemtime(ROOT_DIR.TEMPLATE_DIR.'/js/app.js')],
                //MMOWEB STAT
                ['idx' => 'webstat', 'typex' => 'script', 'src' => 'https://mmoweb.biz/watch.js'],

                //['idx'=> '', 'typex' => 'script', 'js' => 'alert(1)'],
            ),
        ],
    ],

    'en' => [],
);
