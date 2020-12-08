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
    public $market = array();
    public $sid;
    public $att = array(
        0 => "Fire",
        1 => "Water",
        2 => "Wind",
        3 => "Earth",
        4 => "Holy",
        5 => "Dark",
    );


    public $datatable;
    public $datatable_column;

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Lineage2\Market\Market*/
        $this->this_main = $this_main;
        $this->market = $this->this_main->market;
        $this->sid = get_sid();

        $this->datatable  = new \DataTable('Modules\\\Lineage2\\\Market\\\Market', 'ajax_get_market_list');
        $this->datatable_column = array(
            'icon' => array(
                'name' => '',
                'orderable' => 'false',
                'position' => 0,
                'formatter' => function($val, $row) {
                    return '<div class="item-name">'
                        . '<img src="'.check_icon_item($val, $this->sid).'">'
                        . '<div>'
                        . "<span class='item-name__content'>" . $row['name'] . ' <span class="item-name__additional">' . $row['add_name'] . "</span>"
                        . ($row['enc'] > 0 ? "+" . $row['enc'] : '') . "</span>"
                        . (get_augmentation($row['aug_1']) != "" ? "<span class='item-augment'>"
                            . "<span>" . get_augmentation($row['aug_1']) . "</span><span>" . get_augmentation($row['aug_2']) . "</span>"
                            . "</span>" : "")
                        . "</div>"
                        . "</div>";
                }
            ),
            'grade' => array(
                'name' => 'Ранг',
                'orderable' => 'true',
                'position' => 1,
                'formatter' => function($val, $row) {
                    return '<span class="item-grade">' . ($val == "non" ? "NG" : $val) . '</span>';
                }
            ),
            'a_att_type' => array(
                'name' => 'Атрибут',
                'orderable' => 'false',
                'position' => 2,
                'formatter' => function($val, $row) {

                    $att = ($row['a_att_value'] > 0 ? $this->att[$val] . ' ' . $row['a_att_value'] . "<br>" : '');

                    $att .= ($row["d_att_0"] != 0 ? $this->att[0] . " " . $row["d_att_0"] . '<br>' : '');
                    $att .= ($row["d_att_1"] != 0 ? $this->att[1] . " " . $row["d_att_1"] . '<br>' : '');
                    $att .= ($row["d_att_2"] != 0 ? $this->att[2] . " " . $row["d_att_2"] . '<br>' : '');
                    $att .= ($row["d_att_3"] != 0 ? $this->att[3] . " " . $row["d_att_3"] . '<br>' : '');
                    $att .= ($row["d_att_4"] != 0 ? $this->att[4] . " " . $row["d_att_4"] . '<br>' : '');
                    $att .= ($row["d_att_5"] != 0 ? $this->att[5] . " " . $row["d_att_5"] : '');

                    return $att;
                }
            ),
            'count' => array(
                'name' => 'В наличии',
                'orderable' => 'true',
                'position' => 3,
                'formatter' => function($val, $row) {
                    return $val;
                }
            ),
            'price' => array(
                'name' => 'Цена',
                'orderable' => 'true',
                'position' => 4,
                'formatter' => function($val, $row) {
                    $cfg = $this->check_price($row["item_id"], 'array');
                    $r = '<div class="btn-group"><span class="item-price">';
                    if (isset($cfg["step"])){

                        $r .= number_format((float) $val, 2, '.', '') . ' за x'.$cfg["step"];
                    }else
                        $r .= number_format((float) $val, 2, '.', '');

                    $r .= '</span><button type="submit" class="btn btn-sm btn-outline-primary submit-btn" '.btn_ajax("Modules\Lineage2\Market\Market", "ajax_buy_shop", ['id' => $row['id']]).'>Купить</button>';

                    return $r . "</div>";
                }
            ),


        );//Создаем разметку для таблицы
        $this->datatable->loudColumn($this->datatable_column);


    }

    /**
     * @return array
     */
    private function get_count_section(){
        $count_section = array();
        $count_temp = $this->this_main->db->query('SELECT 
            s.section, COUNT(i.id) as counts
            FROM `mw_market_shop_items` AS i
            LEFT JOIN `mw_market_shop` AS s ON s.id = i.shop_id
            GROUP BY s.section')
            ->fetchAll(\PDO::FETCH_ASSOC);

        if (!is_null($count_temp)){
            foreach ($count_temp as $sec) {
                $count_section[$sec['section']] = $sec['counts'];
            }

        }
        return $count_section;
    }

    public function widget_categories_vertical(){


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_categories.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'count_section' => $this->get_count_section(),
                    'section_status' => $this->market['section'],
                ),
                get_lang('market.lang')
            )
        );

    }

    public function widget_list_market(){
        $url_array = get_instance()->url->segment_array();
        if(isset($url_array[3]) AND in_array($url_array[3], $this->market['section'])){
            $section = $url_array[3];
            $this->datatable->addPost(['sid' => $this->sid, 'section' => $section]);

            return get_instance()->fenom->fetch(
                get_tpl_file('widget_list_market.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        "datatable_render" => $this->datatable->renderTemplate(),
                    ),
                    get_lang('market.lang')
                )
            );

        }else
            return error_404_html('Внимание', 'Раздел отключен', 'Рынок отключен или еще не настроен.');

    }

    public function ajax_get_market_list(){
        
        if (isset($_POST['custom'])) {
      
            $section = isset($_POST['custom']['section']) ? $_POST['custom']['section'] : false;

            if (!in_array($section, $this->market['section']))
                return false;

            $columns = isset($_POST['columns']) ? $_POST['columns'] : array();
            $draw = isset ( $_POST['draw'] ) ? intval( $_POST['draw'] ) : 0;
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;;
            $length = isset($_POST['length']) ? intval($_POST['length']) : 30;
            $order = isset($_POST['order']) ? $_POST['order'] : array();
            $search = isset($_POST['search']) ? $_POST['search'] : array();


            $limit_sql = '';
            if ( isset($start) && $length != -1 ) {
                $limit_sql = "LIMIT $start, ".$length;
            }
            $order_sql = '';
            if ( is_array($order) && count($order) ) {
                foreach($order as $order_val){
                    $key = $columns[ $order_val['column'] ]['name'];
                    if( isset($this->datatable_column[$key]) ) {
                        if ($columns[ $order_val['column'] ]['orderable'] == 'true') {
                            $dir = $order_val['dir'] === 'asc' ? 'ASC' : 'DESC';
                            $orderBy[] = '`' . $key . '` ' . $dir;
                        }
                    }
                    $key = null;
                }
                $order_sql = 'ORDER BY ' . implode(', ', $orderBy);
            }
            $where = '';

            if(!empty($search['value'])){
                $field_search = array('i.`name`', 'i.`add_name`', 'i.`description`');
                $globalSearch = array();
                foreach($field_search as $column){
                    $globalSearch[] = "$column LIKE ".$this->this_main->db->quote('%'.$search['value'].'%');
                }
                if (is_array($globalSearch) AND count( $globalSearch ) ) {
                    $where = 'AND ('.implode(' OR ', $globalSearch).')';
                }
                unset($globalSearch);
            }

            $section = $this->this_main->db->quote($section);
            $this->sid = intval($this->sid);

            $result = $this->this_main->db->query("SELECT
                                                    si.`id`, 
                                                    si.`shop_id`,
                                                    s.`type`,
                                                    s.`data_create`,
                                                    si.`item_id`,
                                                    si.`price`, 
                                                    si.`count`, 
                                                    si.`enc`, 
                                                    si.`aug_1`, 
                                                    si.`aug_2`, 
                                                    si.`a_att_type`, 
                                                    si.`a_att_value`, 
                                                    si.`d_att_0`, 
                                                    si.`d_att_1`, 
                                                    si.`d_att_2`, 
                                                    si.`d_att_3`, 
                                                    si.`d_att_4`, 
                                                    si.`d_att_5`,
                                                    i.`name`,
                                                    i.`add_name`,
                                                    i.`description`,
                                                    i.`icon`,
                                                    i.`icon_panel`,
                                                    i.`grade`,
                                                    i.`stackable`
                                                    FROM `mw_market_shop_items` AS si
                                                    LEFT JOIN  `mw_market_shop` AS s ON s.id = si.shop_id
                                                    LEFT JOIN  `mw_item_db` AS i ON i.item_id = si.item_id AND i.sid = s.sid
                                                    WHERE s.sid = {$this->sid} AND s.`section`= {$section}  {$where}
                                              {$order_sql}
                                              {$limit_sql};")->fetchAll(\PDO::FETCH_ASSOC);
            $out = array();
            foreach($result as $value){
                $row = array();
                foreach($this->datatable_column as $name_colum => $data){
                    if ( isset( $data['formatter'] ) ) {
                        $row[ $data['position'] ] = $data['formatter']( (isset($value[$name_colum]) ? $value[$name_colum] : NULL), $value);
                    }
                    else {
                        $row[ $data['position'] ] = $value[ $name_colum ];
                    }
                }
                $out[] = $row;
            }
            $result = $out;
            unset($out , $row);

            // Data set length after filtering
            $recordsFiltered = $this->this_main->db->query("SELECT COUNT(si.`id`)
                                    FROM `mw_market_shop_items` AS si
                                    LEFT JOIN  `mw_market_shop` AS s ON s.id = si.shop_id
                                    LEFT JOIN  `mw_item_db` AS i ON i.item_id = si.item_id AND i.sid = s.sid
                                    WHERE s.sid = {$this->sid} AND s.`section`= {$section}  {$where};")->fetch(\PDO::FETCH_UNIQUE)[0];

            $recordsTotal = $this->this_main->db->query("SELECT COUNT(si.`id`)
                                    
                                    FROM `mw_market_shop_items` AS si
                                    LEFT JOIN  `mw_market_shop` AS s ON s.id = si.shop_id
                                    WHERE s.sid = {$this->sid} AND s.`section`= {$section} ;")->fetch(\PDO::FETCH_UNIQUE)[0];


            return json_encode( array(
                "draw"            => $draw,
                "recordsTotal"    => intval( $recordsTotal ),
                "recordsFiltered" => intval( $recordsFiltered ),
                "data"            =>  $result
            ));
            
            
            
        }


        return '';
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
                    'market_cfg' => $this->market,
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
                    'count_section' => $this->get_count_section(),
                    'section_status' => $this->market['section'],
                ),
                get_lang('market.lang')
            )
        );

    }

    public function widget_sell_character(){
        if (!in_array('character', $this->market['section']))
            return error_404_html('Внимание', 'Продажа персонажей отключена администрацией', 'Рынок отключен или еще не настроен.');

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

    public function widget_market_disable(){

        return error_404_html('Внимание', 'Рынок отключен администрацией', 'Рынок отключен или еще не настроен.');

    }




    //AJAX

    /**
     * @return false|string
     */
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

        if (!isset($_POST['type']) OR empty($_POST['type']))
            $type = 'select';
        else
            $type = $_POST['type'];


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
                    $send = get_instance()->ajaxmsg->html($this->items_form($items, $type), '#inventory_'.$_POST['char_id'])->notify((string)$response["response"]->success)->success();

                } else
                    $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

            }

        } else {
            $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
        }


        return $send;
    }

    /**
     * @param $items
     * @return string
     */
    private function items_form($items, $type){

        if (is_array($items)){

            $html_item = '';
            $html_item_disable = '';

            foreach ($items as $item){

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

                    $aug .= get_augmentation($item['i_a_1']) . PHP_EOL;
                    $aug .= get_augmentation($item['i_a_1']);
                }


                $item_info = set_item($item['i_i'],false,true);

                if (!is_array($item_info))
                    continue;

                $item = array_merge($item, $item_info);
                if($this->check_item($item) AND $type == 'select') {
                    $price = $this->check_price($item["i_i"]);
                    $html_item .= '<a class="list-group-item list-group-item-action text-left p-1 select_item_mr" id="u' . $item['uid'] . '" data-uid="' . $item['uid'] . '"  data-count="' . $item['i_c'] . '"  data-stackable="' . $item['stackable'] . '" data-name="' . $item['name'] . ' ' . $enc . ' ' . $count . '" data-icon="' . $item['icon'] . '" '.$price.' href="javascript:void(0)" title="' . $att . ' ' . $aug . '"><img src="' . $item['icon'] . '" width="22px" class="mr-1" title="' . $item['name'] . '">' . $item['name'] . ' ' . $enc . ' ' . $count . '</a>';

                }else
                    $html_item_disable .= '<div class="list-group-item list-group-item-action text-left p-1 not-sell"  title="'.$att.' '.$aug.'"><img src="'.$item['icon'].'" width="22px" class="mr-1 imgdis" title="'.$item['name'].'">'.$item['name'].' '.$enc.' '.$count.'</div>';

            }


            $html = '<div class="list-group push size-2" style="font-size: 85%;">';
            $html .= $html_item;
            $html .= $html_item_disable;
            $html .= '</div>';
            return $html;
        }else
            return 'На этом персонаже нет предметов';
    }

    /**
     * @param $item_id
     * @param string $type
     * @return string
     */
    public function check_price($item_id, $type = 'html'){

        if(is_array($this->market["price"]) AND count($this->market["price"]) > 0){
            foreach ($this->market["price"] as $cfg){

                if ($cfg['id'] == $item_id){
                    if ($type == 'html')
                        return ' data-min="'.$cfg['min'].'" data-max="'.$cfg['max'].'" data-step="'.$cfg['step'].'" ';
                    else
                        return $cfg;
                }
            }
        }
        if ($type == 'html')
            return '';
        else
            false;
    }

    /**
     * @param $item
     * @return bool
     */
    public function check_item($item){

        if(in_array($item["i_i"] , explode(',',$this->market["items_allowed"])))
            return true;
        elseif( in_array($item["i_i"] , explode(',',$this->market["items_prohibited"])))
            return false;
        elseif( ($item["i_a_1"] != 0) AND !in_array("augmentation", $this->market["options"]))
            return false;
        elseif( ($item["stackable"] != 0) AND !in_array("stackable", $this->market["options"]))
            return false;
        elseif( ($item["a_a_t"] > -1) AND !in_array("attributes", $this->market["options"]))
            return false;
        else{

            if(is_array($this->market["grade"])) {
                if (!in_array($item["grade"], $this->market["grade"]))
                    return false;
            }else
                return false;

            if(is_array($this->market["type"])){
                if(!in_array($item["type"], $this->market["type"]))
                    return false;
            }else
                return false;

            return true;
        }
    }

    /**
     * @return false|string
     */
    public function ajax_sell_item(){


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

            if (!isset($_POST['terms']) OR empty($_POST['terms']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["terms"] = $_POST['terms'];


            if (check_pin("pins_market_sell_item")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }



            $api = new LineageApi();
            $response = $api->market_sell($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/market')->success();
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

    public function ajax_withdrawal(){
        $vars = array();

        if (get_instance()->session->isLogin()) {

//withdrawal_type: withdrawal_bank
//delivery_method: qiwi
//wallet: 12
//withdrawal_sum: 12

            if (!isset($_POST['withdrawal_type']) OR empty($_POST['withdrawal_type']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["withdrawal_type"] = $_POST['withdrawal_type'];

            if ($_POST['withdrawal_type'] == 'withdrawal_bank') {

                if (!isset($_POST['delivery_method']) or empty($_POST['delivery_method']))
                    return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
                else
                    $vars["delivery_method"] = $_POST['delivery_method'];

                if (!isset($_POST['wallet']) or empty($_POST['wallet']))
                    return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
                else
                    $vars["wallet"] = $_POST['wallet'];
            }

            if (!isset($_POST['withdrawal_sum']) OR empty($_POST['withdrawal_sum']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["withdrawal_sum"] = $_POST['withdrawal_sum'];



            if (check_pin("pins_market_withdrawal")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }



            $api = new LineageApi();
            if ($_POST['withdrawal_type'] == 'withdrawal_bank')
                $response = $api->market_withdraw($vars);
            else
                $response = $api->market_transfer($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/market')->success();
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

    public function ajax_sell_character(){
        $vars = array();

        if (get_instance()->session->isLogin()) {


            if (!isset($_POST['character']) OR empty($_POST['character']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["character"] = $_POST['character'];

            if (!isset($_POST['account']) OR empty($_POST['account']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["account"] = $_POST['account'];

            if (!isset($_POST['price']) OR empty($_POST['price']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["price"] = $_POST['price'];


            if (!isset($_POST['terms']) OR empty($_POST['terms']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars["terms"] = $_POST['terms'];

            if (check_pin("pins_market_sell_char")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }


            $api = new LineageApi();
            $response = $api->market_character($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->success)) {
                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, '/panel/market')->success();
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