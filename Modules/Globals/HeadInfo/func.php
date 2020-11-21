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
        $status_bonus_cod = get_instance()->status_plugin('bonus_cod');

        $col = 10; //за вычетом кнопки перевести в игру и банера

        if ($status_warehouse)
            $col -= 2;

        if ($status_discount)
            $col -= 2;

        if ($col > 6 AND $status_bonus_cod)
            $col -= 2;
        else
            $status_bonus_cod = false;

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_head.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'status_warehouse' => $status_warehouse,
                    'status_discount' => $status_discount,
                    'status_bonus_cod' => $status_bonus_cod,
                    'row_col' => $col,
                ),
                get_lang('widget_head.lang')
            )

        );


    }

}