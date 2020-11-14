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


    public $api_key = 'sdfre5gtbd44';
    public $deny;
    public $allow;
    public $count = 10;
    public $prefix = 'xf_';
    public $dbcoll = 'UTF8';


    public function db() {
        include_once './src/config.php';
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

        if(isset($_POST["count"]))
            $this->count = intval($_POST["count"]);

        if(isset($_POST["allow"]))
            $this->allow = $_POST["allow"];

        if(isset($_POST["deny"]))
            $this->deny = $_POST["deny"];


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
                        topics.post_date as date_post,
                        topics.user_id as poster_id,
                        topics.username as poster_name,
                        topics.last_post_date as last_post,
                        topics.last_post_user_id as last_poster_id,
                        topics.last_post_username as last_poster_name,
                        posts.message as post,
                        us.avatar_date as avatar,
                        topics.node_id
                        FROM ".$this->prefix."thread as topics
                        LEFT JOIN ".$this->prefix."post as posts ON topics.first_post_id = posts.post_id
                        LEFT JOIN ".$this->prefix."user as us ON us.user_id = topics.last_post_user_id
                        WHERE ".$this->deny. " " .$this->allow." topics.discussion_state = 'visible'
                        ORDER BY topics.last_post_date DESC
                        LIMIT ".$this->count;


        $posts = $db->query($fsql);

        if($posts->rowCount()){
            $posts = $posts->fetchAll(PDO::FETCH_ASSOC);
            foreach($posts as &$post){
                $post['post'] = api_func::replaceBBCode($post['post']);
            }

            $json['post'] = $posts;
            $json["error"] = 0;

        }else
            $json["error"] = 'not_thread';


        $db = NULL;


        return $json;

    }

}

class api_func{

    public static function replaceBBCode($text_post) {
        $str_search = array(
            "#\[B\](.+?)\[\/B\]#is",
            "#\[I\](.+?)\[\/I\]#is",
            "#\[U\](.+?)\[\/U\]#is",
            "#\[ATTACH(.+?)\](.+?)\[\/ATTACH\]#is",
            "#\[CODE\](.+?)\[\/CODE\]#is",
            "#\[CODE=(.+?)\\](.+?)\[\/CODE\]#is",
            "#\[CENTER\](.+?)\[\/CENTER\]#is",
            "#\[LEFT\](.+?)\[\/LEFT\]#is",
            "#\[RIGHT\](.+?)\[\/RIGHT\]#is",
            "#\[QUOTE\](.+?)\[\/QUOTE\]#is",
            "#\[URL=(.+?)\](.+?)\[\/URL\]#is",
            "#\[URL\](.+?)\[\/URL\]#is",
            "#\[IMG\](.+?)\[\/IMG\]#is",
            "#\[SIZE=(.+?)\](.+?)\[\/SIZE\]#is",
            "#\[COLOR=(.+?)\](.+?)\[\/COLOR\]#is",
            "#\[LIST\](.+?)\[\/LIST\]#is",
            "#\[LIST=\"1\"](.+?)\[\/LIST\]#is",
            "#\[LIST=1](.+?)\[\/LIST\]#is",
            "#\[\*\](.+?)\\n#",
            "#\[INDENT\]\[\/INDENT\]#",
            "#\[INDENT\](.+?)\[\/INDENT\]#is",
            "#\[ICODE\](.+?)\[\/ICODE\]#is",
            "#\[ISPOILER\](.+?)\[\/ISPOILER\]#is",
            "#\[TABLE\](.+?)\[\/TABLE\]#is",
            "#\[TR\](.+?)\[\/TR\]#is",
            "#\[TD\](.+?)\[\/TD\]#is",
            "#\\\n#is",

        );
        $str_replace = array(
            "<b>\\1</b>",
            "<i>\\1</i>",
            "<span style='text-decoration:underline'>\\1</span>",
            "ATTACH",
            "<pre class='code'>\\1</pre>",
            "<pre class='code \\1'>\\2</pre>",
            "<center>\\1</center>",
            "<div style='text-align:left;'>\\1</div>",
            "<div style='text-align:right;'>\\1</div>",
            "<table width = '95%'><tr><td>Цитата</td></tr><tr><td class='quote'>\\1</td></tr></table>",
            "<a href='\\1'>\\2</a>",
            "<a href='\\1'>\\1</a>",
            "<img src='\\1' alt = 'Изображение' />",
            "<span style='font-size:\\1%'>\\2</span>",
            "<span style='color:\\1'>\\2</span>",
            "<ul>\\1</ul>",
            "<ol>\\1</ol>",
            "<ol>\\1</ol>",
            "<li>\\1</li>",
            "",
            "<blockquote>\\1</blockquote>",
            "<pre class='code icode'>\\1</pre>",
            "<div class='ispoiler'>\\1</div>",
            "<table style='width: 100%'><tbody>\\1</tbody></table>",
            "<tr>\\1</tr>",
            "<td>\\1</td>",
            "<br/>",
        );
        return preg_replace($str_search, $str_replace, $text_post);
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