<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 05.03.2019
 * Time: 19:38
 */

namespace Modules\Lineage2\Market;
use ApiLib\LineageApi;
use Modules\MainModulesClass;

class Market extends MainModulesClass
{
    private $integrity_time = 600;
    public $market = array();
    public $sid;
    public $db = false;

    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        $this->market = &get_instance()->market;
        $this->sid = get_instance()->sid;

        if (isset($this->market[$this->sid]))
            $this->market = $this->market[$this->sid];
        else
            $this->market = false;





        include_once $this->mDir."/func.php";
        $this->func = new \Market\func( $this );

        if (get_instance()->session->isLogin() AND $this->market !== false)
            $this->integrity_check();
    }

    public function init_db(){
        try {
            if ($this->db === false)
                $this->db = get_instance()->db();
        }catch (\Exception $e){
            echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
            exit;
        }
    }

    public function status(){

        if ($this->market === false)
            return false;
        else
        {
            if (isset($this->market['status']) AND $this->market['status'])
                return true;
            else
                return false;
        }
    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Lineage2",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Биржа',
                'en' => 'Market',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "14.09.2020",
            "lastUpdated" => "14.09.2020",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {

        if ($this->status() == false)
            return array();

        return array(
            'ajax_get_market_list' => function () { return $this->func->ajax_get_market_list(); },
            'ajax_loud_inventory' => function () { return $this->func->ajax_loud_inventory(); },
            'ajax_sell_item' => function () { return $this->func->ajax_sell_item(); },
            'ajax_withdrawal' => function () { return $this->func->ajax_withdrawal(); },
            'ajax_sell_character' => function () { return $this->func->ajax_sell_character(); },
            'ajax_buy_shop_popup' => function () { return $this->func->ajax_buy_shop_popup(); },
            'ajax_buy_shop' => function () { return $this->func->ajax_buy_shop(); },
            'ajax_show_inventory' => function () { return $this->func->ajax_show_inventory(); },
            'ajax_stop_selling' => function () { return $this->func->ajax_stop_selling(); },
            'ajax_refresh_info' => function () { return $this->func->ajax_refresh_info(); },
            'checkout' => function () { return $this->func->ajax_checkout(); },

        );

    }

    public function renderWindow()
    {

        if ($this->status() == false) {
            return array(
                '/panel/market' => array(
                    'header' => get_lang('market.lang')['market_title'],
                    'row' => array(
                        array(
                            'class' => 'col-12 col-md-12',
                            'level' => 1,
                            'widget_market_disable' => function () {
                                return $this->func->widget_market_disable();
                            },
                        ),


                    ),
                ),
            );

        }


        $content = array(
            '/panel/market' => array(
                'header' => get_lang('market.lang')['market_title'],
                'row' => array(
                    array(
                        'class' => 'col-12 col-md-3',
                        'level' => 1,
                        'widget_categories_vertical' => function() { return $this->func->widget_categories_vertical();},
                    ),
                    array(
                        'class' => 'col-12 col-md-9',

                        'level' => 2,
                        'row gutters-tiny' => array(
                            array(
                                'class' => 'col-12 col-md-8',
                                'level' => 1,
                                'widget_total_stats' => function() { return $this->func->widget_total_stats();},
                            ),
                            array(
                                'class' => 'col-12 col-md-4',
                                'level' => 2,
                                'widget_user_bar' => function() { return $this->func->widget_user_bar();},
                            ),

                            array(
                                'class' => 'col-12 col-md-12',
                                'level' => 3,
                                'widget_new_item' => function() { return $this->func->widget_new_item();},
                            ),

                        ),
                    ),


                ),
            ),
            '/panel/market/(armor|weapon|jewelry|consumables|coin|character|etc)' => array(
                'header' => get_lang('market.lang')['market_title'],
                'row' => array(
                    array(
                        'class' => 'col-12 col-md-3',
                        'level' => 1,
                        'widget_categories_vertical' => function() { return $this->func->widget_categories_vertical();},
                    ),
                    array(
                        'class' => 'col-12 col-md-9',

                        'level' => 2,
                        'row gutters-tiny' => array(
                            array(
                                'class' => 'col-md-12',
                                'level' => 1,
                                'widget_list_market' => function() { return $this->func->widget_list_market();},
                            ),
                        ),
                    ),


                ),
            ),

            '/panel/market/withdrawal' => array(
                'header' => get_lang('market.lang')['withdrawal_title'],

                'row' => array(
                    array(
                        'class' => 'col-lg-6 offset-lg-3',
                        'level' => 1,
                        'widget_withdrawal' => function() { return $this->func->widget_withdrawal();},
                    ),
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 2,
                        'widget_log_transfer' => function() { return $this->func->widget_log_transfer();},
                    ),

                ),



            ),

            '/panel/market/withdrawal/\d+' => array(
                'header' => get_lang('market.lang')['withdrawal_title'],

                'row' => array(
                    array(
                        'class' => 'col-lg-6 offset-lg-3',
                        'level' => 1,
                        'widget_withdrawal_item' => function() { return $this->func->widget_withdrawal_item();},
                    ),


                ),



            ),

            '/panel/market/sell' => array(
                'header' => get_lang('market.lang')['sell_title'],

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_sell();},
                    ),

                ),


            ),

            '/panel/market/sell-character' => array(
                'header' => get_lang('market.lang')['sell_character_title'],

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_sell_character();},
                    ),

                ),


            ),

            '/panel/market/my-sell' => array(
                'header' => get_lang('market.lang')['my_sell_title'],

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_my_sell();},
                    ),

                ),


            ),

            '/panel/market/history' => array(
                'header' => get_lang('market.lang')['history_title'],

                'row' => array(
                    array(
                        'class' => 'col-12 col-md-12',
                        'level' => 1,
                        'widget_sell' => function() { return $this->func->widget_history();},
                    ),

                ),


            ),
            '/panel/market/donations' => array(
                //'header' => get_lang('market.lang')['history_title'],

                'row justify-content-center' => array(
                    array(
                        'class' => 'col-lg-8 col-md-12 col-xs-12',
                        'level' => 1,
                        'widget_donations' => function() { return $this->func->widget_donations();},
                    ),

                ),


            ),



        );

        return $content;

    }

    /** записываем информацию о магазине
     * @param $data
     */
    public function update_shop($data){
        $this->init_db();
        if (isset($data['shop']) AND isset($data['item_shop'])){
            $this->delete_shop(['shop_id' => $data['shop']['id']]);

            if (isset($data['shop']['id']) AND is_numeric($data['shop']['id']) AND is_array($data['item_shop']) AND count($data['item_shop'])){

                //добовляем шоп
                $STH = $this->db->prepare('INSERT INTO `mw_market_shop` 
                                                       (`id`, `mid`, `section`, `type`, `count`, `data_create`, `sid`) 
                                                VALUES (:id, :mid, :section, :type, :count, :data_create, :sid);');
                $STH->bindValue(':id', $data['shop']['id']);
                $STH->bindValue(':mid', $data['shop']['mid']);
                $STH->bindValue(':section', $data['shop']['section']);
                $STH->bindValue(':type', $data['shop']['type']);
                $STH->bindValue(':count', $data['shop']['count']);
                $STH->bindValue(':data_create', $data['shop']['data_create']);
                $STH->bindValue(':sid', $data['shop']['sid']);
                if(!$STH->execute())
                    return false;

                foreach ($data['item_shop'] as $shop_item) {
                    $STH = $this->db->prepare('INSERT INTO `mw_market_shop_items` 
                                                                (`id`, `shop_id`, `char_info`, `char_inventory`, `price`, `item_id`, `count`, `enc`, `aug_1`, `aug_2`, `a_att_type`, `a_att_value`, `d_att_0`, `d_att_1`, `d_att_2`, `d_att_3`, `d_att_4`, `d_att_5`) 
                                                        VALUES  (:id, :shop_id, :char_info, :char_inventory, :price, :item_id, :count, :enc, :aug_1, :aug_2, :a_att_type, :a_att_value, :d_att_0, :d_att_1, :d_att_2, :d_att_3, :d_att_4, :d_att_5);');
                    $STH->bindValue(':id', $shop_item['id']);
                    $STH->bindValue(':shop_id', $shop_item['shop_id']);
                    $STH->bindValue(':char_info', $shop_item['char_info']);
                    $STH->bindValue(':char_inventory', $shop_item['char_inventory']);
                    $STH->bindValue(':price', $shop_item['price']);
                    $STH->bindValue(':item_id', $shop_item['item_id']);
                    $STH->bindValue(':count', $shop_item['count']);
                    $STH->bindValue(':enc', $shop_item['enc']);
                    $STH->bindValue(':aug_1', $shop_item['aug_1']);
                    $STH->bindValue(':aug_2', $shop_item['aug_2']);
                    $STH->bindValue(':a_att_type', $shop_item['a_att_type']);
                    $STH->bindValue(':a_att_value', $shop_item['a_att_value']);
                    $STH->bindValue(':d_att_0', $shop_item['d_att_0']);
                    $STH->bindValue(':d_att_1', $shop_item['d_att_1']);
                    $STH->bindValue(':d_att_2', $shop_item['d_att_2']);
                    $STH->bindValue(':d_att_3', $shop_item['d_att_3']);
                    $STH->bindValue(':d_att_4', $shop_item['d_att_4']);
                    $STH->bindValue(':d_att_5', $shop_item['d_att_5']);
                    if(!$STH->execute())
                        return false;
                }
                return true;
            }
        }elseif(isset($data['shop_id'])){
            $this->delete_shop(['shop_id' => $data['shop_id']]);
        }
        return false;
    }


    public function delete_shop($data){
        $this->init_db();
        if (isset($data['shop_id']) AND is_numeric($data['shop_id'])){
            $id = intval($data['shop_id']);
            $STH = $this->db->prepare('DELETE FROM mw_market_shop WHERE id=:id;');
            $STH->bindValue(':id', $id);
            $STH->execute();

            $STH = $this->db->prepare('DELETE FROM mw_market_shop_items WHERE shop_id=:shop_id;');
            $STH->bindValue(':shop_id', $id);
            return $STH->execute();
        }
        return false;
    }


    private function integrity_check(){
        $this->init_db();
        $check = get_cache('integrity_check_market', true);
        if ($check == false) {
            set_cache('integrity_check_market', 1, $this->integrity_time);
            $vars['items'] = array();

            $shop_list_temp = $this->db->query('SELECT id, shop_id FROM mw_market_shop_items;')->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($shop_list_temp as $item) {
                $vars['items'][$item['shop_id']][] = $item['id'];
            }

            if (count($vars['items']) < 1)
                $vars['items'] = 0;

            $api = new LineageApi();

            $response = $api->market_get($vars);
            if ($response['ok']) {
                if (!isset($response['error'])) {
                    if (isset($response["response"]->success) AND isset($response["response"]->market)) {
                        $data = json_decode(json_encode($response["response"]->market), true);
                        if (is_array($data)) {
                            foreach ($data as $item) {
                                $this->delete_shop(['shop_id' => $item['shop_id']]);
                                if (isset($item['update']))
                                    $this->update_shop($item['update']);
                            }
                        }
                    }
                }
            }
        }
    }

    public function install(){
        $this->init_db();
        $this->db->query("CREATE TABLE `mw_market_shop` (
  `id` int(11) NOT NULL COMMENT 'ID Магазина',
  `mid` int(11) NOT NULL COMMENT 'ID мастер аккаунта',
  `section` varchar(15) NOT NULL COMMENT 'Раздел лавки',
  `type` tinyint(1) NOT NULL COMMENT 'Тип магазина 1 - оптом, \r\n2 - розница,\r\n3 - продажа персонажа',
  `count` int(2) NOT NULL COMMENT 'Кол-во предметов в магазине',
  `data_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
  `sid` int(11) NOT NULL COMMENT 'ID сервера'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mw_market_shop_items` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL COMMENT 'Ид магазина',
  `char_info` text NOT NULL COMMENT 'Информация о персонаже',
  `char_inventory` mediumtext NOT NULL COMMENT 'Информация об инвентаре персонажа',
  `price` decimal(12,6) NOT NULL COMMENT 'Цена за товар или еденицу товара',
  `item_id` int(11) NOT NULL COMMENT 'ид предмета',
  `count` int(11) NOT NULL COMMENT 'количество предметов',
  `enc` int(11) NOT NULL DEFAULT '0' COMMENT 'Улучшение предмета',
  `aug_1` int(11) NOT NULL DEFAULT '0' COMMENT 'Аугоментация предмета',
  `aug_2` int(11) NOT NULL DEFAULT '0' COMMENT 'Аугоментация предмета',
  `a_att_type` int(11) NOT NULL DEFAULT '-2' COMMENT 'Тип атрибута',
  `a_att_value` int(11) NOT NULL DEFAULT '0' COMMENT 'Значение атрибута',
  `d_att_0` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
  `d_att_1` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
  `d_att_2` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
  `d_att_3` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
  `d_att_4` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия',
  `d_att_5` int(11) NOT NULL DEFAULT '0' COMMENT 'стихия'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mw_market_shop`
  ADD KEY (`id`),
  ADD KEY `sid` (`sid`),
  ADD KEY `mid` (`mid`);

ALTER TABLE `mw_market_shop_items`
  ADD KEY (`id`),
  ADD KEY `shop_id` (`shop_id`);


ALTER TABLE `mw_market_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Магазина';

ALTER TABLE `mw_market_shop_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;");
    }
}