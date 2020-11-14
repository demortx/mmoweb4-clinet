<?php

/********************************
 * Dev and Code by Demort
 * Email : demortx@gmail.com
 * Date: 18.03.2020
 ********************************/
header("Content-type: application/json; charset=utf-8");
//error_reporting(E_ALL & ~E_NOTICE  & ~E_USER_NOTICE);
ini_set('display_errors', 0);

class api {

    public $api_key = 'sedfcw4rx234e12';
    public $deny;
    public $allow;
    public $count = 10;
    public $prefix;
    public $dbcoll = 'UTF8';


    public function db() {
        include_once 'conf_global.php';
        $this->prefix = $INFO['sql_tbl_prefix'];
		$INFO['sql_driver'] = 'mysql';
        try {
            return new PDO(
                $INFO['sql_driver'].":host=".$INFO['sql_host'].";dbname=".$INFO['sql_database'].";charset=".$this->dbcoll,
                $INFO['sql_user'],
                $INFO['sql_pass']
            );
        }
        catch(PDOException $e) {
            die(json_encode(array('error'=>'connect_db')));
        }
    }


    public function lastPost(){

        if(isset($_POST["count"]))
            $this->count = intval($_POST["count"]);

        if(isset($_POST["allow"]))
            $this->allow = $_POST["allow"];

        if(isset($_POST["deny"]))
            $this->deny = $_POST["deny"];


        if (empty($this->deny))
        { $this->deny = ""; }
        else
        {

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

            $this->deny = " forum_id NOT IN (".$this->deny.") AND ";
        }

        if (empty($this->allow))
        { $this->allow = ""; }
        else
        {

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

            $this->allow = " forum_id IN (".$this->allow.") AND ";
        }

        $db = $this->db();


        $fsql = "SELECT
                        topics.tid,
                        topics.title,
                        topics.last_post,
                        topics.last_poster_id,
                        topics.last_poster_name,
                        posts.post,
						members.pp_main_photo as avatar 
                        FROM ".$this->prefix."forums_topics as topics
                        LEFT JOIN ".$this->prefix."forums_posts as posts ON topics.topic_firstpost = posts.pid
                        LEFT JOIN ".$this->prefix."core_members as members ON topics.last_poster_id = members.member_id
					    WHERE ".$this->deny." ".$this->allow." approved = '1'
					    ORDER BY last_post DESC
                        LIMIT ".$this->count ;

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