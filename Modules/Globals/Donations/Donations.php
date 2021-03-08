<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 16.10.2019
 * Time: 17:12
 */

namespace Modules\Globals\Donations;
use Modules\MainModulesClass;

class Donations extends MainModulesClass
{

    public function __construct()
    {
        $this->mDir = dirname(__FILE__);

        include_once $this->mDir."/func.php";
        $this->func = new \Donations\func( $this );

    }

    public function onLoad()
    {

        //Digiseller.ru
        if (isset($_GET['uniquecode']) AND isset(get_instance()->config['payment_system']['digiseller']) AND get_instance()->config['payment_system']['digiseller']){
            if (!empty($_GET['uniquecode']) AND strlen($_GET['uniquecode']) == 16){
                $curl = new \Curl\Curl(API_URL);
                $curl->setTimeout(100);
                $curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');
                $curl->get(API_URL.'v1/Payment/ipn/digiseller', $_GET);
            }
        }

        return false;
    }

    public function info()
    {
        return array(
            "author" => "Demort",
            "game" => "Global",
            "version" => "1.0",
            "description" => array(
                'ru' => 'Виджет баланса',
                'en' => 'Balance Widget',
            ),
            "url" => "https://forum.mmoweb.ru/",
            "created" => "16.10.2019",
            "lastUpdated" => "16.10.2019",
            "class" => __CLASS__,

        );
    }

    public function onRequest(){
        return $this->func->widget_donations_no_auth();
    }

    public function onAjax()
    {

        return array(
            'checkout' => function () { return $this->func->ajax_checkout(); },
            'checkout_no_auth' => function () { return $this->func->ajax_checkout_no_auth(); },
            'ajax_refresh_balance' => function () { return $this->func->ajax_refresh_balance(); },


        );

    }

    public function renderWindow()
    {

        $content = array(

            '/panel/donations' => array(
                //'header' => get_lang($this->lang)['title'] . ' <small>' . get_lang($this->lang)['title_small'] . '</small>',
                'row justify-content-center' => array(
                    0 =>
                        array(
                            'class' => 'col-lg-8 col-md-12 col-xs-12',
                            'level' => 1,
                            'widget_donations' => function() { return $this->func->widget_donations();},
                        ),

                ),
            ),

        );

        return $content;
        //return isset($content[$uri]) ? $content[$uri] : false;
    }

}