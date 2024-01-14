<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 24.09.2019
 * Time: 17:18
 */

namespace Referral;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\Referral\Referral*/
        $this->this_main = $this_main;

    }

    public function widget_referral(){
        if (get_instance()->check_plugin('referral') AND (isset(get_instance()->config['referral']['status']) AND get_instance()->config['referral']['status'])){

            if ((isset(get_instance()->config['referral']['individual']) AND get_instance()->config['referral']['individual']) AND get_instance()->session->session["user_data"]['referral']['individual'] != 1)
                return '';

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_referral.tpl', get_class($this->this_main)),
                get_lang('referral.lang')
            );
        }else
            return '';
    }

}