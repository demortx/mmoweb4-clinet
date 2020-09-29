<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */

namespace Market;

use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    public $shop = array();

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Lineage2\Market\Market*/
        $this->this_main = $this_main;
        $this->shop = &get_instance()->shop;
    }

    public function widget_categories_vertical(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_categories.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );

    }

    public function widget_total_stats(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_total_stats.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );
    }

    public function widget_user_bar(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_user_bar.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );
    }

    public function widget_new_item(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_new_item.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );

    }

    public function widget_withdrawal(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_withdrawal.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );

    }

    public function widget_sell(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_sell.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );

    }

}