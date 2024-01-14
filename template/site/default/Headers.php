<?php

/**
 *  %site_name%             => Имя проекта,
 *  %server_name%           => Имя текушего сервера,
 *  %platform_server_name%  => Платформа и имя сервера пример: Lineage2 > Gracia Final,
 *  %url%                   => ссылка на сайт пример: https://mw4.mmoweb.ru/,
 *
 *  Class/SeoX.php method initReplaceTeg() Добовление тегов
 */


return array(
    'ru' => array(
        //Общий конфиг для лк
        'init' => array(
            'head' => array(
                ['idx' => 'title',      'typex' => 'title',                                         'content' => '%site_name% Сайт сервера %server_name%.'],
                ['idx' => 'og_title',   'typex' => 'meta', 'property' => 'og:title',                'content' => '%site_name% Сайт сервера %server_name%.'],
                ['idx' => 'og_s_name',  'typex' => 'meta', 'property' => 'og:site_name',            'content' => '%site_name%'],
                ['idx' => 'og_type',    'typex' => 'meta', 'property' => 'og:type',                 'content' => 'website'],
                ['idx' => 'og_url',     'typex' => 'meta', 'property' => 'og:url',                  'content' => '%url%'],

                ['idx' => 'desc',       'typex' => 'meta', 'name' => 'description',                 'content' => '%site_name% Сайт сервера %server_name%!'],
                ['idx' => 'og_desc',    'typex' => 'meta', 'property' => 'og:description',          'content' => '%site_name% Сайт сервера %server_name%!'],
                ['idx' => 'tw_desc',    'typex' => 'meta', 'property' => 'twitter:description',     'content' => '%site_name% Сайт сервера %server_name%!'],

                ['idx' => 'keywords',   'typex' => 'meta', 'name' => 'keywords',                    'content' => 'mmoweb, mmoweb4'],

            ),
        ),


    ),
    'en' => array(

    ),
);