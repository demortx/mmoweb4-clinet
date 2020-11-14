<?php
/**
 * Created by PhpStorm.
 * User: Goha
 * Date: 26.08.2016
 * Time: 2:06
 */
/********************************
 * Dev and Code by Demort
 * Email : demortx@gmail.com
 * Date: 18.03.2020
 ********************************/
header("Content-type: application/json; charset=utf-8");

//error_reporting(E_ALL & ~E_NOTICE  & ~E_USER_NOTICE);
ini_set('display_errors', 0);

class api {

    public $api_key = 'dsfgvt5g3c5te';
    public $deny;
    public $allow;
    public $count = 10;
    public $prefix;
    public $dbcoll = 'UTF8';


    public function db() {
        include_once '/library/config.php';
        try {
            return new PDO(
                "mysql:host=".$config['db']['host'].";dbname=".$config['db']['dbname'].";charset=".$this->dbcoll,
                $config['db']['username'],
                $config['db']['password']
            );
        }
        catch(PDOException $e) {
            die(json_encode(array('error'=>'connect_db')));
        }
    }


    public function lastPost(){

        if(isset($GLOBALS["_POST"]["count"]))
            $this->count = intval($GLOBALS["_POST"]["count"]);

        if(isset($GLOBALS["_POST"]["allow"]))
            $this->allow = $GLOBALS["_POST"]["allow"];

        if(isset($GLOBALS["_POST"]["deny"]))
            $this->deny = $GLOBALS["_POST"]["deny"];


        if (empty($this->deny)){
            $this->deny = "";
        }else{
            $pos = strripos($this->deny, ',');
            if ($pos === false) {
                $this->deny = intval($this->deny);
            }else{
                $this->deny = explode( ',', $this->deny );
                foreach($this->deny as $id){
                    $temp_deny[] = intval($id);
                }
                $this->deny = implode( ',', $temp_deny );
            }
            $this->deny = " topics.node_id NOT IN (".$this->deny.") AND ";
        }

        if (empty($this->allow)){
            $this->allow = "";
        }else{
            $pos = strripos($this->allow, ',');
            if ($pos === false) {
                $this->allow = intval($this->allow);
            }else{
                $this->allow = explode( ',', $this->allow );
                foreach($this->allow as $id){
                    $temp_allow[] = intval($id);
                }
                $this->allow = implode( ',', $temp_allow );
            }
            $this->allow = " topics.node_id IN (".$this->allow.") AND ";
        }

        $db = $this->db();

        $fsql = "SELECT
                        topics.thread_id as tid,
                        topics.title,
                        topics.last_post_date as last_post,
                        topics.last_post_user_id as last_poster_id,
                        topics.last_post_username as last_poster_name,
                        posts.message as post,
                        topics.node_id
                        FROM ".$this->prefix."thread as topics
                        LEFT JOIN ".$this->prefix."post as posts ON topics.first_post_id = posts.post_id
                        WHERE ".$this->deny." ".$this->allow." topics.discussion_state = 'visible'
                        ORDER BY topics.last_post_date DESC
                        LIMIT ".$this->count;

        $posts = $db->query($fsql);
        $json = array();
        if($posts->rowCount()){
            $json['post'] = $posts->fetchAll(PDO::FETCH_ASSOC);
            $json["error"] = 0;

        }else
            $json["error"] = 'not_thread';

        $db = NULL;
        return $json;

    }

}


if($_POST) {
    $api = new api();

    # Compares the key
    if ($api->api_key == $_POST['api_key']) {

        switch($_POST['method']){

            case "last_post":
                $json = $api->lastPost();
                break;

            default:
                $json = array('error' => 'not_found_method');
        }

        echo json_encode($json);

    }else
        echo json_encode(array('error' => 'api_key'));
}