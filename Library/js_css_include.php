<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 12.02.2020
 * Time: 21:24
 */

return array(
    'ru' => [
        'init' => [
            'head' => array(
                ['idx' => 'vp', 'typex' => 'meta', 'charset' => 'utf-8'],
                ['idx' => 'ct', 'typex' => 'meta', 'name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, shrink-to-fit=no'],


                ['idx' => 'og_image', 'typex' => 'meta', 'property' => 'og:image', 'content' => VIEWPATH.'/panel/assets/media/favicons/favicons/favicon-192x192.png'],
                ['idx' => 'favicons', 'typex' => 'link', 'rel' => 'shortcut icon', 'href' => VIEWPATH.'/panel/assets/media/favicons/favicon.ico'],
                ['idx' => '192x192_icon', 'typex' => 'link', 'rel' => 'icon', 'type' => 'image/png', 'sizes' => '192x192', 'href' => VIEWPATH.'/panel/assets/media/favicons/favicon-192x192.png'],
                ['idx' => '16x16_icon', 'typex' => 'link', 'rel' => 'icon', 'type' => 'image/png', 'sizes' => '16x16', 'href' => VIEWPATH.'/panel/assets/media/favicons/favicon-16x16.png'],
                ['idx' => 'apple_icon', 'typex' => 'link', 'rel' => 'apple-touch-icon', 'sizes' => '32x32', 'href' => VIEWPATH.'/panel/assets/media/favicons/favicon-32x32.png'],


                ['idx' => 'fonts_gg', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700'],
                ['idx' => 'codebase_css', 'typex' => 'link', 'id'=>'css-main', 'rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/css/codebase.css?v=' . filemtime(ROOT_DIR.VIEWPATH.'/panel/assets/css/codebase.css')],
                ['idx' => 'custom_css', 'typex' => 'link', 'rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/css/custom.css?v=' . filemtime(ROOT_DIR.VIEWPATH.'/panel/assets/css/custom.css')],
            ),
            'body' => array(),
            'footer' => array(

                ['idx' => 'core', 'typex' => 'script', 'src' => VIEWPATH.'/panel/assets/js/codebase.core.min.js?v=' . filemtime(ROOT_DIR.VIEWPATH.'/panel/assets/js/codebase.core.min.js')],
                ['idx' => 'app', 'typex' => 'script', 'src' => VIEWPATH.'/panel/assets/js/codebase.app.min.js?v=' . filemtime(ROOT_DIR.VIEWPATH.'/panel/assets/js/codebase.app.min.js')],

                ['idx' => 'notify', 'typex' => 'script', 'src' => VIEWPATH.'/panel/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js'],
                ['idx' => 'history-tabs', 'typex' => 'script', 'src' => VIEWPATH.'/panel/assets/js/plugins/bootstrap-history-tabs/bootstrap-history-tabs.js?v=2'],

                ['idx' => 'js_mmoweb', 'typex' => 'script', 'src' => VIEWPATH.'/panel/assets/js/mmoweb.js?v=' . filemtime(ROOT_DIR.VIEWPATH.'/panel/assets/js/mmoweb.js')],
                ['idx' => 'webstat', 'typex' => 'script', 'src' => 'https://mmo24.ru/webstat/watch.js'],
                ['idx'=> 'historyTabs', 'typex' => 'script', 'js' => "$('.nav-tabs a').historyTabs();"],
            ),
        ],


    ],

);