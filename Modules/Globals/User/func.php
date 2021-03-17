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

        if (!isset(get_instance()->session->session["user_data"]["account"]['error_exception']))
        {
            $platform = get_instance()->get_platform();
            $sid = get_instance()->get_sid();

            $server_info = isset(get_instance()->config['project']['server_info'][$platform][$sid]) ? get_instance()->config['project']['server_info'][$platform][$sid] : array();

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_account_list_'.$platform.'.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'payment_system' => get_instance()->config['payment_system'],
                        'server_info' => $server_info,


                        ),
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