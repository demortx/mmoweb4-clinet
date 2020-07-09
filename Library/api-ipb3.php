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

    public $api_key = 'dsf43gfn';
    public $deny;
    public $allow;
    public $count;
    public $prefix;
    public $dbcoll;

    public function db() {
        include_once 'conf_global.php';
        $this->prefix = $INFO['sql_tbl_prefix'];
        $this->dbcoll = $INFO['sql_charset'];
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

            if (empty($this->deny))
            { $this->allow = " forum_id IN (".$this->allow.") AND "; }
            else
            { $this->allow = " AND forum_id IN (".$this->allow.") AND "; }
        }

        $db = $this->db();

		$fsql = "
						SELECT
						tops.tid,
						tops.title,
						tops.last_post,
						tops.last_poster_id,
						tops.last_poster_name,
						pos.post,
						pp.pp_thumb_photo as avatar,
						foru.name as section_name,
						foru.id as section_id
						FROM ".$this->prefix."topics as tops
						LEFT JOIN ".$this->prefix."posts as pos ON tops.topic_firstpost = pos.pid
						LEFT JOIN ".$this->prefix."profile_portal as pp ON pp.pp_member_id = tops.last_poster_id
						LEFT JOIN ".$this->prefix."forums as foru ON foru.id = tops.forum_id
						WHERE ".$this->deny." ".$this->allow." tops.approved = '1'
						ORDER BY tops.last_post DESC
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