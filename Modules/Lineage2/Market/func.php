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
    public $advertising;
    public $att = array(
        0 => "Fire",
        1 => "Water",
        2 => "Wind",
        3 => "Earth",
        4 => "Holy",
        5 => "Dark",
    );
    public $payment_list = array(
        'freekassa',
        'g2a',
        'unitpay',
        'payu',
        'paypal',
        'payop',
        'paymentwall',
        'pagseguro',
        'nextpay',
        'paygol',
        'alikassa',
        'enot',
        'ipay',
        'paysafecard',
        'ips_payment',
        'digiseller',
    );

    public $datatable;
    public $datatable_column;
    public $datatable_column_character;

    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Lineage2\Market\Market*/
        $this->this_main = $this_main;
        $this->market = $this->this_main->market;
        $this->sid = get_sid();

        if($this->market['balance'] == false) {
            if ($this->advertising === false)
                $this->advertising = include ROOT_DIR . '/Library/advertising.php';

            if (isset($this->market['payment']))
                $this->payment_list = array_keys($this->market['payment']);
        }

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
                'name' => get_lang('market.lang')['grade'],
                'orderable' => 'true',
                'position' => 1,
                'formatter' => function($val, $row) {
                    return '<span class="item-grade">' . ($val == "non" ? "NG" : $val) . '</span>';
                }
            ),
            'a_att_type' => array(
                'name' => get_lang('market.lang')['attribute'],
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
                'name' => get_lang('market.lang')['quantity'],
                'orderable' => 'true',
                'position' => 3,
                'formatter' => function($val, $row) {
                    return $val;
                }
            ),
            'price' => array(
                'name' => get_lang('market.lang')['price'],
                'orderable' => 'true',
                'position' => 4,
                'formatter' => function($val, $row) {
                    $cfg = $this->check_price($row["item_id"], 'array');
                    $r = '<div class="btn-group"><span class="item-price">';
                    if (isset($cfg["step"])){

                        $r .= number_format((float) $val, 2, '.', '') . ' за x'.$cfg["step"];
                    }else
                        $r .= number_format((float) $val, 2, '.', '');

                    $r .= '</span><button type="submit" class="btn btn-sm btn-outline-primary submit-btn" '.btn_ajax("Modules\Lineage2\Market\Market", "ajax_buy_shop_popup", ['id' => $row['id']]).'>' . get_lang('market.lang')['buy'] . '</button>';

                    return $r . "</div>";
                }
            ),


        );//Создаем разметку для таблицы
        $this->datatable_column_character = array(
            'char_info' => array(
                'name' => get_lang('market.lang')['character_column'],
                'orderable' => 'true',
                'position' => 0,
                'formatter' => function($val, $row) {
                    $char = json_decode($val, true);

                    return
                        "<span>"
                        . $char['name'] . "<br><small>" . get_class_name($char['class_id']) . " (Lv. " . $char['level'] . ")</small>"
                        . "</span>";
                }
            ),
            'char_inventory' => array(
                'name' => get_lang('market.lang')['inventory'],
                'orderable' => 'true',
                'position' => 1,
                'formatter' => function($val, $row) {
                    $inv = array_values(json_decode($val, true));

                    $r = "";

                    for ($i = 0; $i < 5; $i++) {
                        $r .= set_item($inv[$i]['i_i'], false, false, '<span data-item="%id%" style="margin: 0 1px;"><img src="%icon%" width="32px"></span>');
                    }

                    return $r . '<button type="submit" class="btn btn-sm btn-outline-primary submit-btn ml-1" '.btn_ajax("Modules\Lineage2\Market\Market", "ajax_show_inventory", ['id' => $row['shop_id']]).'>'.get_lang('market.lang')['all_inventory'].'</button>';
                }
            ),
            'price' => array(
                'name' => 'Цена',
                'orderable' => 'true',
                'position' => 2,
                'formatter' => function($val, $row) {
                    $cfg = $this->check_price($row["item_id"], 'array');
                    $r = '<div class="btn-group"><span class="item-price">';
                    if (isset($cfg["step"])){

                        $r .= number_format((float) $val, 2, '.', '') . ' за x'.$cfg["step"];
                    }else
                        $r .= number_format((float) $val, 2, '.', '');

                    $r .= '</span><button type="submit" class="btn btn-sm btn-outline-primary submit-btn" '.btn_ajax("Modules\Lineage2\Market\Market", "ajax_buy_shop_popup", ['id' => $row['id']]).'>'.get_lang('market.lang')['buy'].'</button>';

                    return $r . "</div>";
                }
            ),


        );//Создаем разметку для таблицы



    }

    /**
     * @return array
     */
    private function get_count_section(){
        $this->this_main->init_db();
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


            if($section != 'character')
                $this->datatable->loudColumn($this->datatable_column);
            else
                $this->datatable->loudColumn($this->datatable_column_character);

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
            return error_404_html(get_lang('market.lang')['warning'], get_lang('market.lang')['section_disabled'], get_lang('market.lang')['section_disabled_desc']);

    }

    public function ajax_get_market_list(){

        if (isset($_POST['custom'])) {
            $this->this_main->init_db();
            $section = isset($_POST['custom']['section']) ? $_POST['custom']['section'] : false;

            if (!in_array($section, $this->market['section']))
                return false;

            if($section != 'character')
                $this->datatable->loudColumn($this->datatable_column);
            else {
                $this->datatable->loudColumn($this->datatable_column_character);
                //переназначаем поля для выборки
                $this->datatable_column = $this->datatable_column_character;
            }

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
            $order_ = true;
            $orderBy = array();
            if ( is_array($order) && count($order) ) {

                foreach($order as $order_val){
                    $key = $columns[ $order_val['column'] ]['name'];
                    if( isset($this->datatable_column[$key]) ) {
                        if ($columns[ $order_val['column'] ]['orderable'] == 'true') {
                            $dir = $order_val['dir'] === 'asc' ? 'ASC' : 'DESC';
                            $orderBy[] = '`' . $key . '` ' . $dir;
                            $order_ = false;
                        }
                    }
                    $key = null;
                }


            }

            if ($order_)
                $orderBy[] = 'si.`id` DESC';

            if (count($orderBy))
                $order_sql = 'ORDER BY ' . implode(', ', $orderBy);


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
                                                    si.`char_info`,
                                                    si.`char_inventory`,
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



        if (!get_instance()->session->isLogin()){
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }




        $data = get_cache('widget_total_stats_market', false, true);
        $items = array();
        if ($data === false OR isset($data['cache_end'])) {
            set_cache('widget_total_stats_market', $data["data"],CACHE_NEWS);

            $api = new LineageApi();
            $vars = array('temp');
            $response = $api->stat_log($vars);

            if ($response['ok']) {
                if (!isset($response['error'])) {
                    if (isset($response["response"]->success)) {
                        $items = json_encode($response["response"]);
                        $items = json_decode($items, true);

                        set_cache('widget_total_stats_market', $items,CACHE_NEWS);
                    }
                }
            }

        } else
            $items = $data["data"];


        if (!isset($items['success'])){
            $items = array(
                'stat' =>
                    array (
                        'sales_today' => '-//-',
                        'sales_week' => '-//-',
                        'news_today' => '-//-',
                        'news_week' => '-//-',
                    ),
            );
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_total_stats.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'info' => $items,
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

    public function widget_new_item()
    {
        $new = [];

        foreach ($this->market['section'] as $section)
        {
            $result = $this->this_main->db->prepare("SELECT
                                                    si.`id`, 
                                                    si.`shop_id`,
                                                    s.`type`,
                                                    s.`data_create`,
                                                    si.`char_info`,
                                                    si.`char_inventory`,
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
                                                    WHERE s.sid = :sid AND s.`section` = :section LIMIT 5;");
            $result->bindValue(":sid", $this->sid);
            $result->bindValue(":section", $section);
            $result->execute();

            $data = $result->fetchAll();

            if ($section == "character")
            {
                foreach ($data as &$item)
                {
                    $item['char_info'] = json_decode($item['char_info'], true);
                    $item['char_inventory'] = array_values(json_decode($item['char_inventory'], true));
                }
            }

            $new[$section] = $data;
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_new_item.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'new' => $new,
                    'att_type' => $this->att,
                    'sid' => $this->sid,
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

    public function widget_log_transfer(){

        if (!get_instance()->session->isLogin()){
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }

        $api = new LineageApi();
        $vars = array('temp');
        $response = $api->transfer_log($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');
                else
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');

            } else {


                if (isset($response["response"]->success)) {
                    $items = json_encode($response["response"]);
                    $items = json_decode($items, true);


                    //$items['success']  - тут кол во магазинов
                    //$items['log']  - тут все магазины и в них вложены предметы

                    //  0 - создана,
                    // 1 - подтверждена,
                    // 2 - отклонена средства возвращены на баланс рынка,
                    // 3 - отклонена средства изъяты

                    return get_instance()->fenom->fetch(
                        get_tpl_file('widget_log_transfer.tpl', get_class($this->this_main)),
                        array_merge(
                            array(
                                'count_log' => $items['success'],
                                'log_list' => $items['log'],
                                'status' => [
                                    0 => get_lang('market.lang')['created'],
                                    1 => get_lang('market.lang')['accepted'],
                                    2 => get_lang('market.lang')['rejected_refunded'],
                                    3 => get_lang('market.lang')['rejected_not_refunded']
                                ],
                            ),
                            get_lang('market.lang')
                        )
                    );


                } else{
                    header('Location: '.set_url('/sign-in', false), TRUE, 301);
                    die;
                }


            }

        } else {
            return error_404_html(200, 'Oops.. You just found an error page..', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'], '/panel/market');
        }

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
            return error_404_html(get_lang('market.lang')['warning'], get_lang('market.lang')['section_disabled'], get_lang('market.lang')['section_disabled_desc']);

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

        return error_404_html(get_lang('market.lang')['warning'], get_lang('market.lang')['section_disabled'], get_lang('market.lang')['section_disabled_desc']);

    }

    public function widget_withdrawal_item(){

        $name_id = intval(get_instance()->url->segment(4));

        $api = new LineageApi();
        $vars = array('id' => $name_id);
        $response = $api->transfer_log($vars);

        if ($response['ok'])
        {
            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');
                else
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');

            } else {
                if (isset($response["response"]->success)) {
                    return get_instance()->fenom->fetch(
                        get_tpl_file('widget_withdrawal_item.tpl', get_class($this->this_main)),
                        array_merge(
                            array(
                                'log_list' => (array)$response['response']->log,
                                'status' => [
                                    0 => get_lang('market.lang')['created'],
                                    1 => get_lang('market.lang')['accepted'],
                                    2 => get_lang('market.lang')['rejected_refunded'],
                                    3 => get_lang('market.lang')['rejected_not_refunded']
                                ],
                            ),
                            get_lang('market.lang')
                        )
                    );
                }
                else
                {
                    header('Location: '.set_url('/sign-in', false), TRUE, 301);
                    die;
                }
            }
        }
        else
        {
            return error_404_html(200, 'Oops.. You just found an error page..', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'], '/panel/market');
        }
    }


    public function widget_my_sell(){
        $result = $this->this_main->db->prepare("SELECT
                                                    si.`id`, 
                                                    si.`shop_id`,
                                                    s.`type`,
                                                    s.`data_create`,
                                                    s.`section`,
                                                    si.`char_info`,
                                                    si.`char_inventory`,
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
                                                    WHERE s.sid = :sid AND s.`mid` = :mid;");
        $result->bindValue(":sid", $this->sid);
        $result->bindValue(":mid", get_instance()->session->session["master_account"]['mid']);
        $result->execute();

        $data = $result->fetchAll();

        foreach ($data as &$item)
        {
            if ($item['char_info'] != "0")
            {
                $item['char_info'] = json_decode($item['char_info'], true);
                $item['char_inventory'] = json_decode($item['char_inventory'], true);
            }
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_my_sell.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    "data" => $data,
                    "sid" => $this->sid,
                ),
                get_lang('market.lang')
            )
        );
    }

    public function widget_history(){

        if (!get_instance()->session->isLogin()){
            header('Location: '.set_url('/sign-in', false), TRUE, 301);
            die;
        }

        $api = new LineageApi();
        $vars = array('temp');
        $response = $api->history($vars);

        if ($response['ok']) {

            if (isset($response['error'])) {
                if (isset($response["response"]->input))
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');
                else
                    return error_404_html(200, 'Oops.. You just found an error page..', $response['error'], '/panel/market');

            } else {


                if (isset($response["response"]->success)) {
                    $items = json_encode($response["response"]);
                    $items = json_decode($items, true);


                    //$items['success']  - тут кол во магазинов
                    //$items['history']  - тут все магазины и в них вложены предметы

                    return get_instance()->fenom->fetch(
                        get_tpl_file('widget_history.tpl', get_class($this->this_main)),
                        array_merge(
                            array(
                                'count_shop' => $items['success'],
                                'history_list' => $items['history'],
                                'item_status' => [
                                    0 => get_lang('market.lang')['item_status_selling'],
                                    1 => get_lang('market.lang')['item_status_sold'],
                                    2 => get_lang('market.lang')['item_status_refunded'],
                                    3 => get_lang('market.lang')['item_status_error'],
                                ],
                                'shop_status' => [
                                    -1 => get_lang('market.lang')['shop_status_error'],
                                    0 => get_lang('market.lang')['shop_status_modaration'],
                                    1 => get_lang('market.lang')['shop_status_rejected_refunded'],
                                    2 => get_lang('market.lang')['shop_status_rejected_not_refunded'],
                                    3 => get_lang('market.lang')['shop_status_removed_by_player'],
                                    4 => get_lang('market.lang')['shop_status_selling'],
                                    5 => get_lang('market.lang')['shop_status_sold'],
                                ],
                                'shop_type' => [
                                    1 => get_lang('market.lang')['widget_sell_sell_type_1'],
                                    2 => get_lang('market.lang')['widget_sell_sell_type_2'],
                                    3 => get_lang('market.lang')['widget_sell_sell_type_3'],
                                ],
                            ),
                            get_lang('market.lang')
                        )
                    );


                } else{
                    header('Location: '.set_url('/sign-in', false), TRUE, 301);
                    die;
                }


            }

        } else {
            return error_404_html(200, 'Oops.. You just found an error page..', 'Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'], '/panel/market');
        }

    }

    public function widget_donations(){



        if($this->market['balance'] !== false)
            return error_404_html();

        get_instance()->seo->addTeg('head', 'rangeslider_css', 'link', array('rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css'));
        get_instance()->seo->addTeg('footer', 'rangeslider', 'script', array('src' => VIEWPATH.'/panel/assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js'));


        return get_instance()->fenom->fetch(
            get_tpl_file('widget_donations.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'payment_list' => $this->payment_list,
                    get_lang('course.lang')

                ),
                get_lang('widget_donate.lang')
            )

        );

    }

    //AJAX


    public function ajax_checkout(){

        if($this->market['balance'] !== false)
            return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger();

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {

            //Проверка сервера
            if (!isset($_REQUEST['sum']) OR empty($_REQUEST['sum']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_sum'])->danger();
            else
                $vars["sum"] = $_REQUEST['sum'];


            //Проверка сервера
            if (!isset($_REQUEST['payment_method']) OR empty($_REQUEST['payment_method']))
                return get_instance()->ajaxmsg->notify(get_lang('widget_donate.lang')['donate_ajax_empty_payment_method'])->danger();
            else
                $vars["payment_method"] = $_REQUEST['payment_method'];

            if (isset($this->advertising['gawpid']) AND !empty($this->advertising['gawpid'])){
                if (isset($_COOKIE['_ga']) AND !empty($_COOKIE['_ga']))
                    $vars["_ga"] = $_COOKIE['_ga'];

                $vars["gaid"] = $this->advertising['gawpid'];
            }
            if (isset($this->advertising['ymid']) AND !empty($this->advertising['ymid'])) {
                if (isset($_COOKIE['_ym_uid']) AND !empty($_COOKIE['_ym_uid']))
                    $vars["_ym"] = $_COOKIE['_ym_uid'];

                $vars["ymid"] = $this->advertising['ymid'];
            }


            //Ставим флаг создания простого платежа
            $vars["type"] = 4;

            $response = $api->checkout($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();
                } else {
                    if (isset($response["response"]->redirect)) {

                        if (isset($response["response"]->post) AND !empty($response["response"]->post) > 0)
                            $send = get_instance()->ajaxmsg->post($response["response"]->post)->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();
                        else
                            $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success, (string)$response["response"]->redirect)->success();

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
                    $enc = '+'.$item['i_e'];

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
            return get_lang('market.lang')['no_items'];
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
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_section'])->danger();
            else
                $vars["section"] = $_POST['section'];

            if (!isset($_POST['type']) OR empty($_POST['type']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_type'])->danger();
            else
                $vars["type"] = intval($_POST['type']);

            if (!isset($_POST['i']) OR empty($_POST['i']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_i'])->danger();
            else
                $vars["i"] = $_POST['i'];

            if (!isset($_POST['terms']) OR empty($_POST['terms']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_terms'])->danger();
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


            if (!isset($_POST['withdrawal_type']) OR empty($_POST['withdrawal_type']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_withdrawal_type'])->danger();
            else
                $vars["withdrawal_type"] = $_POST['withdrawal_type'];

            if ($_POST['withdrawal_type'] == 'withdrawal_bank') {

                if (!isset($_POST['delivery_method']) or empty($_POST['delivery_method']))
                    return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_delivery_method'])->danger();
                else
                    $vars["delivery_method"] = $_POST['delivery_method'];

                if (!isset($_POST['wallet']) or empty($_POST['wallet']))
                    return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_wallet'])->danger();
                else
                    $vars["wallet"] = $_POST['wallet'];
            }

            if (!isset($_POST['withdrawal_sum']) OR empty($_POST['withdrawal_sum']))
                return get_instance()->ajaxmsg->notify(get_lang('market.lang')['ajax_empty_sum'])->danger();
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


                        if (isset($response["response"]->data->user_data)) {
                            $data = json_encode($response["response"]->data);
                            $data = json_decode($data, true);
                            get_instance()->session->updateSessionDB($data);
                        }

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

    public function ajax_buy_shop_popup(){

        if (get_instance()->session->isLogin()) {


            if (!isset($_POST['id']) OR empty($_POST['id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $id = intval($_POST['id']);

            $item = $this->sql_get_item_shop($id);

            if (!isset($item['id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();//предмет не найден он был ранее продан или снят с продажи

            $items_all = array();

            if ($item['type'] == "3"){ //если товар персонаж
                $item['char_info'] = json_decode($item['char_info'], true);
                $item['char_inventory'] = array_values(json_decode($item['char_inventory'], true));


            }else if ($item['type'] == "1") {//проверка на оптовый магазин

                //удалить дубль предмета
                $items_all = $this->sql_get_item_shop(false, $item['shop_id']);

            }

            $title = "Покупка " . $item['name'];

            $package_price = 0;

            if ($items_all != null)
            {
                foreach ($items_all as $value)
                {
                    $package_price += $value['price'];
                }
            }
            else
            {
                $package_price = $item['price'];
            }

            $package_price = number_format($package_price, 2, '.', '');

            $cfg = $this->check_price($item["item_id"], 'array');

            $content = get_instance()->fenom->fetch(
                get_tpl_file('ajax_buy_shop.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'char_list' => get_instance()->session->getGameChars(),
                        'item' => $item,
                        'items_all' => $items_all,
                        'item_id' => $id,
                        'package_price' => $package_price,
                        'sid' => $this->sid,
                        'att' => $this->att,
                        'step' => ($cfg['step'] == null ? 1 : $cfg['step']),
                    ),
                    get_lang('market.lang')
                )
            );

            $footer = '<div class="row justify-content-between">
                    <span class="pull-left" style="line-height: 30px;">' . get_lang('market.lang')['pay_amount'] . '<span id="price-final" data-initial="' . $package_price . '">' . $package_price . '</span></span>
                    <button type="submit" class="btn btn-alt-primary pull-right submit-form"><i class="si si-action-redo mr-5"></i> ' . get_lang('market.lang')['buy'] .'</button>
                   </div>';

            return get_instance()->ajaxmsg->popup($title, $content, $footer)->send();



        }else
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

    }

    public function ajax_show_inventory(){

        if (get_instance()->session->isLogin()) {

            if (!isset($_POST['id']) OR empty($_POST['id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $id = intval($_POST['id']);


            $title = "Инвентарь";

            $result = $this->this_main->db->query("SELECT `char_inventory` FROM `mw_market_shop_items`
                                                    WHERE shop_id = {$id} LIMIT 1;")->fetch(\PDO::FETCH_ASSOC);

            if (!isset($result['char_inventory']) OR empty($result['char_inventory']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();//Персонаж у которого был запрошен инвентарь был продан или снят с продажи



            $inv = array_values(json_decode($result['char_inventory'], true));

            $content = get_instance()->fenom->fetch(
                get_tpl_file('ajax_show_inventory.tpl', get_class($this->this_main)),
                array_merge(
                    array(
                        'inventory' => ($inv == null ? "Пусто" : $inv),
                    ),
                    get_lang('bonus_cod.lang')
                )
            );

            $footer = '';

            return get_instance()->ajaxmsg->popup($title, $content, $footer)->send();


        }else
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();
    }

    public function ajax_buy_shop(){




        if (get_instance()->session->isLogin()) {
            $vars = array();

            if (!isset($_POST['account_name']) OR empty($_POST['account_name']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars['account'] = $_POST['account_name'];

            if (isset($_POST['char_name']))
                $vars['character'] = $_POST['char_name'];

            if (!isset($_POST['id']) OR empty($_POST['id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars['id'] = intval($_POST['id']);

            if (isset($_POST['count']))
                $vars['count'] = intval($_POST['count']);

            if (check_pin("pins_market_buy_shop")) {
                if (!isset($_POST['pin']) OR empty($_POST['pin']))
                    return get_instance()->ajaxmsg->notify(get_lang('widget_reset_pin.lang')['ajax_empty_pin'])->danger();
                else
                    $vars["pin"] = $_POST['pin'];
            }



            $api = new LineageApi();
            $response = $api->market_buy($vars);

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

            return $send;




        }else
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();
    }

    public function ajax_stop_selling(){
        if (get_instance()->session->isLogin()) {
            $vars = array();

            if (!isset($_POST['id']) OR empty($_POST['id']))
                return get_instance()->ajaxmsg->notify(get_lang('shop.lang')['ajax_empty_shop_id'])->danger();
            else
                $vars['id'] = intval($_POST['id']);


            $api = new LineageApi();
            $response = $api->market_sell_delete($vars);

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

            return $send;

        }else
            return get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();
    }

    public function ajax_refresh_info(){


        $vars = array('temp');

        if (get_instance()->session->isLogin()) {


            $api = new LineageApi();
            $response = $api->refresh_info($vars);

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

                        $send = get_instance()->ajaxmsg->notify((string)$response["response"]->success)->html($this->widget_user_bar(), '#w_user_info')->success();

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


    //SQL

    private function sql_get_item_shop($item_id = false, $shop_id = false){

        if ($item_id !== false){
            $where = 'si.`id`';
            $id = $item_id;
        }else{
            $where = 'si.`shop_id`';
            $id = $shop_id;
        }

        $query = $this->this_main->db->prepare("SELECT
                                                    si.`id`, 
                                                    si.`shop_id`,
                                                    s.`type`,
                                                    s.`data_create`,
                                                    si.`char_info`,
                                                    si.`char_inventory`,
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
                                                    WHERE {$where}=:id;");

        $query->bindValue(':id', $id);
        $query->execute();
        if ($item_id !== false)
            return $query->fetch(\PDO::FETCH_ASSOC);
        else
            return $query->fetchAll(\PDO::FETCH_ASSOC);

    }





}