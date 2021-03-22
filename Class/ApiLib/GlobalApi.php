<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 01.04.2019
 * Time: 19:33
 */

namespace ApiLib;


class GlobalApi extends \Api
{

    public function __construct($url = false, $key = false)
    {
        parent::__construct($url, $key);
    }

    public function signup($vars)
    {

        if ($vars['type'] == 'email') {
            $response = $this->init()->addParam('signup_email', $vars)->post('v1/Globals/user/sign-up-email')->response();

        } elseif ($vars['type'] == 'phone') {

            $response = $this->init()->addParam('signup_phone', $vars)->post('v1/Globals/user/sign-up-phone')->response();

        } elseif ($vars['type'] == 'code') {

            $response = $this->init()->addParam('signup_code', $vars)->post('v1/Globals/user/sign-up-code')->response();

        } elseif ($vars['type'] == 'sms') {

            $response = $this->init()->addParam('signup_sms', $vars)->post('v1/Globals/user/sign-up-sms')->response();

        } else
            return false;


        return $response;
    }

    public function reminder($vars)
    {

        if ($vars['type'] == 'email') {
            $response = $this->init()->addParam('reminder_email', $vars)->post('v1/Globals/user/reminder-email')->response();

        } elseif ($vars['type'] == 'phone') {

            $response = $this->init()->addParam('reminder_phone', $vars)->post('v1/Globals/user/reminder-phone')->response();

        } elseif ($vars['type'] == 'code') {

            $response = $this->init()->addParam('reminder_code', $vars)->post('v1/Globals/user/reminder-code')->response();

        } elseif ($vars['type'] == 'sms') {

            $response = $this->init()->addParam('reminder_sms', $vars)->post('v1/Globals/user/reminder-sms')->response();

        } else
            return false;

        //var_dump($response);
        return $response;
    }

    public function signin($vars)
    {

        if ($vars['type'] == 'signin') {

            $response = $this->init()->addParam('signin', $vars)->post('v1/Globals/user/log-in')->response();

        } elseif ($vars['type'] == 'signin_social') {

            $response = $this->init()->addParam('signin_social', $vars)->post('v1/Globals/user/log-in-social')->response();

        } elseif ($vars['type'] == 'signin_ig_login') {

            $response = $this->init()->addParam('signin_ig_login', $vars)->post('v1/Globals/user/log-ig-login')->response();

        } else
            return false;


        return $response;
    }

    //ОПЕРАЦИИ С АККАУНТОМ

    public function create_game_account($vars){

        $response = $this->init()->addParam('create_game_account', $vars)->post('v1/Globals/user/create-game-account')->response();
        return $response;

    }

    public function refresh_accounts($vars)
    {
        $response = $this->init()->addParam('refresh_accounts', $vars)->get('v1/Globals/user/refresh-accounts')->response();
        return $response;
    }

    public function hide_account($vars)
    {
        $response = $this->init()->addParam('hide_account', $vars)->post('v1/Globals/user/hide-account')->response();
        return $response;
    }

    public function show_account($vars)
    {
        $response = $this->init()->addParam('show_account', $vars)->post('v1/Globals/user/show-account')->response();
        return $response;
    }
    //НАСТРОЙКИ ПРОФИЛЯ



    public function change_password_account($vars)
    {
        $response = $this->init()->addParam('change_password_account', $vars)->post('v1/Globals/settings/change-password-account')->response();
        return $response;
    }

    public function forgot_password_account($vars)
    {
        $response = $this->init()->addParam('forgot_password_account', $vars)->post('v1/Globals/settings/forgot-password-account')->response();
        return $response;
    }

    public function server_change($vars)
    {
        $response = $this->init()->addParam('server_change', $vars)->post('v1/Globals/settings/server-change')->response();
        return $response;
    }

    public function social_bind($vars)
    {

        $response = $this->init()->addParam('ulogin', $vars)->post('v1/Globals/settings/ulogin')->response();

        return $response;
    }

    public function social_delete($vars)
    {

        $response = $this->init()->addParam('ulogin', $vars)->delete('v1/Globals/settings/ulogin')->response();

        return $response;
    }

    public function recovery_pin($vars)
    {

        $response = $this->init()->addParam('recovery_pin', $vars)->get('v1/Globals/settings/recovery-pin')->response();

        return $response;
    }

    public function pin_system($vars)
    {

        $response = $this->init()->addParam('pin_system', $vars)->get('v1/Globals/settings/pin-system')->response();

        return $response;
    }

    public function change_pwd_ma($vars)
    {

        $response = $this->init()->addParam('change_pwd_ma', $vars)->post('v1/Globals/settings/change-pwd-ma')->response();

        return $response;
    }

    public function confirm_email_send_code($vars)
    {

        $response = $this->init()->addParam('confirm_email_send_code', $vars)->post('v1/Globals/settings/confirm-email-send-code')->response();

        return $response;
    }

    public function confirm_email($vars)
    {

        $response = $this->init()->addParam('confirm_email', $vars)->post('v1/Globals/settings/confirm-email')->response();

        return $response;
    }

    public function bind_telegram($vars)
    {

        $response = $this->init()->addParam('bind_telegram', $vars)->post('v1/Globals/settings/bind-telegram')->response();

        return $response;
    }

    public function bind_email_send_code($vars)
    {

        $response = $this->init()->addParam('bind_email_send_code', $vars)->post('v1/Globals/settings/bind-email-send-code')->response();

        return $response;
    }

    public function bind_email($vars)
    {

        $response = $this->init()->addParam('bind_email', $vars)->post('v1/Globals/settings/bind-email')->response();

        return $response;
    }

    public function bind_phone_send_code($vars)
    {

        $response = $this->init()->addParam('bind_phone_send_code', $vars)->post('v1/Globals/settings/bind-phone-send-code')->response();

        return $response;
    }

    public function bind_phone($vars)
    {

        $response = $this->init()->addParam('bind_phone', $vars)->post('v1/Globals/settings/bind-phone')->response();

        return $response;
    }

    public function delete_bind_phone($vars)
    {

        $response = $this->init()->addParam('delete_phone', $vars)->delete('v1/Globals/settings/delete-phone')->response();

        return $response;
    }

    //УПРАВЛЕНИЕ МА

    public function manager_change($vars)
    {
        $response = $this->init()->addParam('manager_ma', $vars)->get('v1/Plugins/manager/change')->response();
        return $response;
    }
    public function manager_add($vars)
    {
        $response = $this->init()->addParam('manager_ma', $vars)->post('v1/Plugins/manager/add')->response();
        return $response;
    }
    public function manager_confirm($vars)
    {
        $response = $this->init()->addParam('manager_ma', $vars)->post('v1/Plugins/manager/confirm')->response();
        return $response;
    }
    public function manager_delete($vars)
    {
        $response = $this->init()->addParam('manager_ma', $vars)->delete('v1/Plugins/manager/delete')->response();
        return $response;
    }

    //БАЛАНС

    public function invoice($vars){

        $response = $this->init()->addParam('invoice', $vars)->get('v1/Globals/payment/invoice')->response();
        return $response;
    }

    public function checkout($vars){

        $response = $this->init()->addParam('checkout', $vars)->post('v1/Globals/payment/checkout')->response();

        return $response;

    }

    public function refresh_balance($vars){

        $response = $this->init()->addParam('refresh_balance', $vars)->get('v1/Globals/payment/refresh-balance')->response();

        return $response;
    }

    public function buy_in_game_currency($vars){

        $response = $this->init()->addParam('buy_in_game_currency', $vars)->post('v1/Globals/payment/buy-in-game-currency')->response();

        return $response;
    }

    //СКЛАД

    public function give_item_warehouse($vars){

        $response = $this->init()->addParam('item', $vars)->get('v1/Globals/warehouse/item')->response();

        return $response;
    }

    //SUPPORT

    public function get_all_tickets($vars){
        $response = $this->init()->addParam('all', $vars)->get('v1/Plugins/support/all')->response();

        return $response;
    }

    public function get_ticket($vars){
        $response = $this->init()->addParam('ticket', $vars)->get('v1/Plugins/support/ticket')->response();

        return $response;
    }

    public function create_ticket($vars){
        $response = $this->init()->addParam('create', $vars)->post('v1/Plugins/support/create')->response();

        return $response;
    }

    public function answer_ticket($vars){
        $response = $this->init()->addParam('answer', $vars)->post('v1/Plugins/support/answer')->response();

        return $response;
    }

    //СТАТИСТИКА


    public function get_online($vars){
        $response = $this->init()->addParam('online', $vars)->get('v1/Globals/statistic/online', false)->response();

        return $response;
    }

    public function get_online_history($vars){
        $response = $this->init()->addParam('online', $vars)->get('v1/Globals/statistic/online_history', false)->response();

        return $response;
    }

    public function get_rating($vars){
        $response = $this->init()->addParam('rating', $vars)->get('v1/Globals/statistic/rating')->response();

        return $response;
    }

    //SHOP
    public function buy_shop($vars){
        $response = $this->init()->addParam('buy_shop', $vars)->post('v1/Plugins/shop/buy')->response();

        return $response;
    }
    public function buy_service($vars){
        $response = $this->init()->addParam('buy_service', $vars)->post('v1/Plugins/service/buy')->response();

        return $response;
    }
    //BONUS COD
    public function get_bonus_cod($vars){
        $response = $this->init()->addParam('bonus_cod', $vars)->get('v1/Plugins/bonus-cod/get')->response();

        return $response;
    }
    //VOTE
    public function send_vote($vars){
        $response = $this->init()->addParam('cast', $vars)->post('v1/Globals/vote/cast')->response();

        return $response;
    }
    //Launcher
    public function in_game($vars){
        $response = $this->init()->addParam('in_game', $vars)->get('v1/Globals/user/in-game')->response();

        return $response;
    }

    //Lucky Wheel

    public function lucky_wheel_buy($vars){
        $response = $this->init()->addParam('lucky_wheel', $vars)->post('v1/Plugins/lucky-wheel/buy')->response();

        return $response;
    }


    public function lucky_wheel_history($vars){
        $response = $this->init()->addParam('lucky_wheel', $vars)->get('v1/Plugins/lucky-wheel/history')->response();

        return $response;
    }

    //Cases

    public function cases_buy($vars){
        $response = $this->init()->addParam('cases', $vars)->post('v1/Plugins/cases/buy')->response();

        return $response;
    }


    public function cases_history($vars){
        $response = $this->init()->addParam('cases', $vars)->get('v1/Plugins/cases/history')->response();

        return $response;
    }

}