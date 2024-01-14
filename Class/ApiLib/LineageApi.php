<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 01.04.2019
 * Time: 19:32
 */

namespace ApiLib;


class LineageApi extends \Api
{

    public function __construct($url = false, $key = false)
    {
        parent::__construct($url, $key);
    }

    //Получение списка предметов персонажа
    public function character_items($vars){
        $response = $this->init()->addParam('items', $vars)->get('v1/Lineage2/character/items')->response();

        return $response;
    }

    //MARKET
    public function market_get($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/get')->response();

        return $response;
    }
    public function market_sell($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/sell')->response();

        return $response;
    }
    public function market_character($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/sell-character')->response();

        return $response;
    }
    public function market_sell_delete($vars){
        $response = $this->init()->addParam('market', $vars)->delete('v1/Lineage2/market/sell')->response();

        return $response;
    }
    public function market_buy($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/buy')->response();

        return $response;
    }
    public function market_transfer($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/transfer')->response();

        return $response;
    }
    public function market_withdraw($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/withdraw')->response();

        return $response;
    }
    public function refresh_info($vars){
        $response = $this->init()->addParam('market', $vars)->get('v1/Lineage2/market/info')->response();

        return $response;
    }
    public function history($vars){
        $response = $this->init()->addParam('market', $vars)->get('v1/Lineage2/market/history')->response();

        return $response;
    }
    public function transfer_log($vars){
        $response = $this->init()->addParam('market', $vars)->get('v1/Lineage2/market/transfer')->response();

        return $response;
    }
    public function stat_log($vars){
        $response = $this->init()->addParam('market', $vars)->get('v1/Lineage2/market/stat')->response();

        return $response;
    }

    //УПРАВЛЕНИЕ ПЕРСОНАЖЕМ
    public function teleport_char($vars){
        $response = $this->init()->addParam('teleport', $vars)->post('v1/Lineage2/character/teleport')->response();

        return $response;
    }
    public function reset_hwid_char($vars){
        $response = $this->init()->addParam('reset_hwid', $vars)->post('v1/Lineage2/character/reset-hwid')->response();

        return $response;
    }
    public function reset_pin_char($vars){
        $response = $this->init()->addParam('reset_pin', $vars)->post('v1/Lineage2/character/reset-pin')->response();

        return $response;
    }
    //УПРАВЛЕНИЕ АККАУНТОМ
    public function reset_pin_account($vars){
        $response = $this->init()->addParam('reset_pin', $vars)->post('v1/Lineage2/account/reset-pin')->response();

        return $response;
    }
    public function reset_hwid_account($vars){
        $response = $this->init()->addParam('reset_hwid', $vars)->post('v1/Lineage2/account/reset-hwid')->response();

        return $response;
    }


}