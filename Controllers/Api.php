<?php
/**
 * Created by PhpStorm.
 * User: x88xa
 * Date: 13.10.2018
 * Time: 17:57
 */

class Api extends Controller
{

    public function __construct(){
        parent::__construct();
    }

    public function gateway(){

        //header("Content-Type: text/xml");
        header('Content-Type: application/xml; charset=utf-8');
        if(!isset($_POST['hash'])) {
            echo (new \Curl\XMLFormatter())->format(array("error" => "Not Hash","code" => 0));
            exit;
        }
        $HASH = $_POST['hash'];
        unset($_POST['hash']);

        ksort($_POST);
        $signature = hash_hmac('sha256', json_encode($_POST), API_KEY);

        if($HASH !== $signature){
            exit( (new \Curl\XMLFormatter())->format(array("error" => "Signature", 'code' => 1 , 'hash' => $HASH)));

        }
    }

    public function update_session(){

        @ignore_user_abort(true);
        header('Connection: close');
        @ob_end_flush();
        @ob_flush();
        @flush();
        if(@session_id()){
            @session_write_close();
        }
        $this->gateway();

        if (isset($_POST['session_id'])){
            $db = get_instance()->db();
            $STH = $db->prepare('SELECT `data`, `ip` FROM mw_session WHERE session_id = :session_id AND session_end > NOW();');
            $STH->bindValue(':session_id', $_POST['session_id']);
            $STH->execute();
            if($STH->rowCount()) {
                $data = $STH->fetch(PDO::FETCH_ASSOC);
                $session = json_decode($data['data'], true);
                if (is_array($session) AND count($session)>0) {
                    if (isset($session['master_account']) AND isset($_POST['master_account']))
                        $session['master_account'] = array_merge($session['master_account'], $_POST['master_account']);

                    if (isset($session['vote']) AND isset($_POST['vote']))
                        $session['vote'] = $_POST['vote'];

                    if (isset($session['user_data']) AND isset($_POST['user_data'])) {
                        $session['user_data'] = array_merge($session['user_data'], $_POST['user_data']);
                    }

                    $STH = $db->prepare('UPDATE `mw_session` SET `data`= :data WHERE session_id = :session_id;');
                    $STH->execute(
                        array(
                            ':data' => json_encode($session),
                            ':session_id' => $_POST['session_id'],
                        )
                    );
                }
            }
        }
    }

    public function index(){
        header('Content-Type: application/xml; charset=utf-8');
        exit( (new \Curl\XMLFormatter())->format(array("error" => "Signature", 'code' => 1)));
    }

    public function connection_check(){
        global $TEMP;
        $this->gateway();
        $send = array( 'status' => 'success', );

        $send['config'] = is_writable(ROOT_DIR . '/Library/config.php');
        if (!$send['config'])
            $send['status'] = 'error';

        $send['shop'] = is_writable(ROOT_DIR . '/Library/shop.php');
        if (!$send['shop'])
            $send['status'] = 'error';

        try {
            $db = get_instance()->db();
            $db->query('SELECT 1')->fetch();
            $send['db'] = 1;
        }catch (\Exception $e){
            $send['db'] = $e->getMessage();
            $send['status'] = 'error';
        }

        echo (new \Curl\XMLFormatter())->format($send);

    }

    public function config(){
        $this->gateway();

        $POST = array_merge($this->config,$_POST);

        if(SaveProjectConfig($POST)) {
            echo (new \Curl\XMLFormatter())->format(array("title" => "Update success! config","text" => "Successfully updated the project settings!", "status" => "success"));
        }else
            echo (new \Curl\XMLFormatter())->format(array("title" => "Update Error! config","text" => "Error! Failed to update configuration!", "status" => "error"));

    }

    public function shop(){
        $this->gateway();

        if(SaveShopConfig($_POST)) {
            echo (new \Curl\XMLFormatter())->format(array("title" => "Update success! config","text" => "Successfully updated the project settings!", "status" => "success"));
        }else
            echo (new \Curl\XMLFormatter())->format(array("title" => "Update Error! config","text" => "Error! Failed to update configuration!", "status" => "error"));

    }

    public function item(){
        header('Content-Type: application/json');
        if (!WEB_ITEM_DB){
            exit(json_encode(array("error" => "Item DB disable", 'code' => 0 )));
        }

        header('Access-Control-Allow-Origin: '.ACAO_DB_GETAWAY);

        if (!isset($_GET['sid']) OR !is_numeric($_GET['sid']))
            exit(json_encode(array("error" => "Empty sid", 'code' => 1 )));


        if (!isset($_GET['id']) OR empty($_GET['id']))
            exit(json_encode(array("error" => "Empty id", 'code' => 2 )));

        if (is_numeric($_GET['id'])){
            $item = set_item((int) $_GET['id'], (int) $_GET['sid'], true);
            $json[] = array(
                'id' => (int) $item['item_id'],
                'name' => $item['name'],
                'add_name' => $item['add_name'],
                'description' => $item['description'],
                'icon' => set_url($item['icon'], true, false),
            );
        }else{
            $ids = explode(',',$_GET['id']);
            if(is_array($ids) AND count($ids) > 0){
                foreach ($ids as $id) {
                    $item = set_item((int) $id, (int) $_GET['sid'], true);
                    $json[] = array(
                        'id' => (int) $item['item_id'],
                        'name' => $item['name'],
                        'add_name' => $item['add_name'],
                        'description' => $item['description'],
                        'icon' => set_url($item['icon'], true, false),
                    );

                }

            }else
                exit(json_encode(array("error" => "Error item id. Format: 1,2,3", 'code' => 3 )));
        }

        echo json_encode($json);
    }

    public function send_email(){
        $this->gateway();

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=".mb_strtolower($_POST["charset"])." \r\n";
        $headers .= "From: {$_POST["name"]} <{$_POST["mail"]}>\r\n";
        $headers .= "Reply-To: {$_POST["mail"]}\r\n";
        $headers .= "Return-Path: {$_POST["mail"]}\r\n";
        $headers .= "X-Mailer: MmoWeb4\r\n";
        $headers .= "Content-Language: en\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";


        if(mail( $_POST['send']['email'], $_POST['send']['subject'], $_POST['send']['body'], $headers ))
            $send = array( "status" => "success");
        else
            $send = array( "status" => "error");

        echo (new \Curl\XMLFormatter())->format($send);
    }

    public function cron(){

    }


}