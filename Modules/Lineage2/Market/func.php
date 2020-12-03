<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */

namespace Market;

use ApiLib\GlobalApi;
use ApiLib\LineageApi;

class func
{

    public $this_main = false;
    public $shop = array();
    public $att = array(
        0 => "Fire",
        1 => "Water",
        2 => "Wind",
        3 => "Earth",
        4 => "Holy",
        5 => "Dark",
    );

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

    public function widget_sell_character(){

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_sell_character.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    //'social_list' => $this->soc_network,
                    //'soc_list' => $soc_list,
                ),
                get_lang('market.lang')
            )
        );

    }




    //AJAX

    public function ajax_loud_inventory(){
        $api = new LineageApi();
        $vars = array('temp');

        if (!get_instance()->session->isLogin())
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        //аккаунт
        if (!isset($_POST['account_name']) OR empty($_POST['account_name']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_account_name'])->danger();
        else
            $vars["account_name"] = $_POST['account_name'];

        //персонаж
        if (!isset($_POST['char_name']) OR empty($_POST['char_name']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();
        else
            $vars["char_name"] = $_POST['char_name'];

        if (!isset($_POST['char_id']) OR empty($_POST['char_id']))
            return get_instance()->ajaxmsg->notify(get_lang('bonus_cod.lang')['ajax_empty_char_name'])->danger();


        $response = $api->character_items($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                else
                    $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

            } else {
                if (isset($response["response"]->items)) {
                    $items = json_encode($response["response"]->items);
                    $items = json_decode($items, true);
                    $send = get_instance()->ajaxmsg->html($this->items_form($items), '#inventory_'.$_POST['char_id'])->notify((string)$response["response"]->success)->success();

                } else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }


        return $send;
    }

    private function items_form($items){
        $lib = include_once ROOT_DIR.'/Library/lineage2db_augmentation.php';


        if (is_array($items)){
            $html = '<div class="list-group push size-2" style="font-size: 85%;">';

            foreach ($items as $item){
//array(15) {
//  ["uid"]=> "5016229"
//  ["i_a_1"]=> "0"
//  ["i_a_2"]=> "0"
//  ["i_i"]=> "2368"
//  ["i_e"]=> "0"
//  ["i_c"]=> "1"
//  ["i_w"]=> "0"
//  ["a_a_t"]=> "0"
//  ["a_a_v"]=> "0"
//  ["d_a_0"]=> "0"
//  ["d_a_1"]=> "0"
//  ["d_a_2"]=> "0"
//  ["d_a_3"]=> "0"
//  ["d_a_4"]=> "0"
//  ["d_a_5"]=> "0"
//}
                $att = '';
                if ($item["a_a_t"] > -1){
                    $att .= 'Attributes' . PHP_EOL;
                    $att .= $this->att[$item["a_a_t"]] . ": " . $item["a_a_v"] . PHP_EOL;
                    $att .= $this->att[0] . ": " . $item["d_a_0"] . PHP_EOL;
                    $att .= $this->att[1] . ": " . $item["d_a_1"] . PHP_EOL;
                    $att .= $this->att[2] . ": " . $item["d_a_2"] . PHP_EOL;
                    $att .= $this->att[3] . ": " . $item["d_a_3"] . PHP_EOL;
                    $att .= $this->att[4] . ": " . $item["d_a_4"] . PHP_EOL;
                    $att .= $this->att[5] . ": " . $item["d_a_5"] . PHP_EOL;
                }

                $count = '';
                if ($item['i_c'] > 1)
                    $count = 'x'.$item['i_c'];

                $enc = '';
                if ($item['i_e'] > 0)
                    $enc = '+'.$item['i_c'];

                $aug = '';
                if($item['i_a_1'] > 0){
                    $aug .= 'Augmentation' . PHP_EOL;
                    $aug .= $lib['augmentation'][$item['i_a_1']] . PHP_EOL;
                    $aug .= $lib['augmentation'][$item['i_a_2']];
                }

                //итд
                //грейды предметов итд в ключах '%id%', '%item_id%', '%name%', '%add_name%', '%description%', '%icon%', '%icon_panel%', '%stackable%', '%stackable%'

                $i = '<a class="list-group-item list-group-item-action text-left p-1 select_item_mr" id="u'.$item['uid'].'" data-uid="'.$item['uid'].'"  data-count="'.$item['i_c'].'"  data-stackable="%stackable%" data-name="%name% '.$enc.' '.$count.'" data-icon="%icon%" href="javascript:void(0)" title="'.$att.' '.$aug.'"><img src="%icon%" width="22px" class="mr-1" title="%name%">%name% '.$enc.' '.$count.'</a>';
                $html .= set_item($item['i_i'],false,false, $i);


            }
            $html .= '</div>';
            return $html;
        }else
            return 'На этом персонаже нет предметов';
    }

    public function ajax_sell_item(){

        $api = new LineageApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_POST['section']) OR empty($_POST['section']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["section"] = $_POST['section'];

            if (!isset($_POST['type']) OR empty($_POST['type']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["type"] = intval($_POST['type']);

            if (!isset($_POST['i']) OR empty($_POST['i']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["i"] = $_POST['i'];


            if (check_pin("pins_market_sell_item")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }


            $response = $api->market_buy($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html($response["response"]->data->user_data->balance, '.balance_html')->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }
            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        return $send;
    }
}