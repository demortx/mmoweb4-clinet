<?php

namespace Template;

/**
 * Компоненты сайта
 */

class SiteComponents
{

    static function db(){

        try {
            return get_instance()->db();
        }catch (\Exception $e){
            echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
            exit;
        }
    }


    static function test_func(){
        return 'MmoWeb v4';
    }


}