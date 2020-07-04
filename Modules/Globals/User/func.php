<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace User;


class func
{

    public $this_main = false;
    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\User\User*/
        $this->this_main = $this_main;
    }

    public function widget_account_list(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_account_list_index.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'content_account_list' => $this->fragment_account_list(),
                ),
                get_lang('user.lang')
            )

        );


    }

    public function fragment_account_list(){
        $platform = get_instance()->get_platform();

        if (!isset(get_instance()->session->session["user_data"]["account"]['error_exception']))
        {

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_account_list_'.$platform.'.tpl', get_class($this->this_main)),
                array_merge(
                    array('payment_system' => get_instance()->config['payment_system'],),
                    get_lang('user.lang')
                )
            );

        }else{
            return get_instance()->fenom->fetch(
                get_tpl_file('widget_account_list_error.tpl', get_class($this->this_main)),
                get_lang('user.lang')
            );
        }



    }



}