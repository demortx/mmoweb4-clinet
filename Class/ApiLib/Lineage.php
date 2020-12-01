<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 01.04.2019
 * Time: 19:32
 */

namespace ApiLib;


class Lineage extends \Api
{



    //Получение списка предметов персонажа
    public function character_items($vars){
        $response = $this->init()->addParam('items', $vars)->get('v1/Lineage2/character/items')->response();

        return $response;
    }

    //MARKET
    public function market_get($vars){
        $response = $this->init()->addParam('market', $vars)->get('v1/Lineage2/market/get')->response();

        return $response;
    }
    public function market_sell($vars){
        $response = $this->init()->addParam('market', $vars)->post('v1/Lineage2/market/sell')->response();

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

}