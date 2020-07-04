<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 23.09.2019
 * Time: 13:49
 */

namespace HeadInfo;


class func
{

    public $this_main = false;
    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Globals\HeadInfo\HeadInfo*/
        $this->this_main = $this_main;
    }

    public function widget_head(){

        $status_warehouse = get_instance()->status_plugin('warehouse');
        $status_discount = get_instance()->status_plugin('discount');

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_head.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'status_warehouse' => $status_warehouse,
                    'status_discount' => $status_discount,
                ),
                get_lang('widget_head.lang')
            )

        );


    }

}