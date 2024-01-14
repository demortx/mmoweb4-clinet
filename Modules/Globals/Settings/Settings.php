<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 29.09.2019
 * Time: 21:00
 */

namespace Modules\Globals\Settings;
use Modules\MainModulesClass;

class Settings extends MainModulesClass
{
    public function __construct()
    {

        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Settings\func( $this );

    }

    public function info()
    {
        return array(
            "author" => "mmoweb",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Виджет настроек мастер аккаунта',
                'en' => 'Wizard account settings widget',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "29.09.2019",
            "lastUpdated" => "29.09.2019",
            "class" => __CLASS__,

        );
    }

    public function onAjax()
    {
        //Потверждение почты, привязка почты
        //Привязка мобильного телефона

        return array(
            'server_change' => function () { return $this->func->ajax_server_change(); },
            'social_bind' => function () { return $this->func->ajax_social_bind(); },
            'social_delete' => function () { return $this->func->ajax_social_delete(); },
            'recovery_pin' => function () { return $this->func->ajax_recovery_pin(); },
            'pin_system' => function () { return $this->func->ajax_pin_system(); },
            'change_pwd_ma' => function () { return $this->func->ajax_change_pwd_ma(); },
            'confirm_email_send_code' => function () { return $this->func->ajax_confirm_email_send_code(); },
            'confirm_email' => function () { return $this->func->ajax_confirm_email(); },
            'bind_telegram' => function () { return $this->func->ajax_bind_telegram(); },
            'bind_email_send_code' => function () { return $this->func->ajax_bind_email_send_code(); },
            'bind_email' => function () { return $this->func->ajax_bind_email(); },
            'bind_phone_send_code' => function () { return $this->func->ajax_bind_phone_send_code(); },
            'bind_phone' => function () { return $this->func->ajax_bind_phone(); },
            'delete_bind_phone' => function () { return $this->func->ajax_delete_bind_phone(); },

            'change_password_account_open' => function () { return $this->func->ajax_change_password_account_open(); },
            'change_password_account' => function () { return $this->func->ajax_change_password_account(); },

            'forgot_password_account_open' => function () { return $this->func->ajax_forgot_password_account_open(); },
            'forgot_password_account' => function () { return $this->func->ajax_forgot_password_account(); },

            'manager_change' => function () { return $this->func->ajax_manager_change(); },
            'manager_delete' => function () { return $this->func->ajax_manager_delete(); },
            'manager_add' => function () { return $this->func->ajax_manager_add(); },
            'manager_confirm' => function () { return $this->func->ajax_manager_confirm(); },

        );

    }

    public function renderWindow()
    {

        $content = array(

            '/panel/settings' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row' => array(
                    0 =>
                        array(
                            'class' => 'col-12',
                            'level' => 1,
                            'widget_settings' => function() { return $this->func->widget_settings();},
                        ),
                ),
            ),

        );

        return $content;
        //return isset($content[$uri]) ? $content[$uri] : false;
    }
}