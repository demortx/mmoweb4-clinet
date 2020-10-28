<?php
/**
 * Created by PhpStorm.
 * User: x88xa
 * Date: 13.10.2018
 * Time: 16:55
 */


class User
{
    public $session_id;
    public $session = array(
        'session_data' => array(
            'session_end' => '',
            'session_id' => '',
            'ip' => '',
        ),
        'master_account' => array(
            'email' => '',
            'phone' => '',
            'shield' => '',
            'affiliate' => '',
            'data_create' => '',
            'last_login' => '',
            'last_ip' => '',
            'email_valid' => '',
            'lang' => '',

            'status' => '',
            "select_sid" => '',
            "platform" => '',
        ),
        'user_data' => array(
            'logs' => '',
            'balance' => '',
        ),

    );

    public $isLogin = NULL;
    /* @var $db \PDO */
    public $db = false;
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function connection_db(){
        if($this->db === false){
            try {
                $this->db = get_instance()->db();
            }catch (\Exception $e){
                echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
                exit;
            }
        }
    }


    public function rebootSession(){
        $this->isLogin = null;
        $this->isLogin();

    }

    /**
     * @return bool|null
     */
    public function isLogin(){

        if($this->isLogin === null)
        {
            if( $id = get_cookie('id_mw') ){

                if($id !== false) {

                    $this->connection_db();

                    $STH = $this->db->prepare('SELECT `data`, `ip` FROM mw_session WHERE session_id = :session_id AND session_end > NOW();');
                    $STH->bindValue(':session_id', $id);
                    $STH->execute();

                    if($STH->rowCount()) {

                        $this->setSessionId($id);

                        $data = $STH->fetch(PDO::FETCH_ASSOC);
                        $data['data'] = json_decode($data['data'], true);

                        $this->setSession($data['data']);


                        if ($data['ip'] == get_ip())
                            return $this->isLogin = true;

                    }else{
                        $this->isLogin = false;
                        delete_cookie('id_mw', '.');
                        delete_cookie('id_mw', '');
                    }
                }else{
                    $this->isLogin = false;
                    delete_cookie('id_mw', '.');
                    delete_cookie('id_mw', '');
                }
            }else
                $this->isLogin = false;
        }else
            return $this->isLogin;

    }

    /**
     * @return array
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {

        $this->session_id = $session_id;
    }

    /**
     * @param mixed $session_id
     * @param mixed $session_end
     */
    public function setSessionIdCookie($session_id, $session_end)
    {
        set_cookie('id_mw', $session_id, strtotime($session_end), '.');
        $this->session_id = $session_id;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->session["master_account"]["platform"];
    }

    /**
     * @return int
     */
    public function getSid()
    {
        return (int) $this->session["master_account"]["select_sid"];
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {

        $this->session = $session;
    }

    /**
     * @param mixed $session
     */
    public function setSessionDB($session)
    {
        $this->connection_db();

        $session = $this->parsData($session);

        set_platform($session['master_account']['platform']);
        set_sid($session['master_account']['select_sid']);



        $STH = $this->db->prepare('INSERT INTO `mw_session`(`session_id`,`data`,`ip`,`session_end`) VALUES (:session_id,:data,:ip,:session_end);');
        $STH->execute(
            array(
                ':session_id' => $session['session_data']['session_id'] ,
                ':data' => json_encode($session) ,
                ':session_end' => $session['session_data']['session_end'],
                ':ip' => $session['session_data']['ip']
            )
        );

        $this->session = $session;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateSessionDB($data){

        $this->connection_db();

        $data = $this->parsData($data);

        if (isset($data["master_account"]["select_sid"]) AND $this->getSid() != $data["master_account"]["select_sid"]){
            set_sid($data['master_account']['select_sid']);
        }

        if (isset($data["master_account"]["platform"]) AND $this->getPlatform() != $data["master_account"]["platform"]){
            set_platform($data['master_account']['platform']);
        }

        $data = json_decode(json_encode($data),true);

        if (isset($data['master_account']))
            $this->session['master_account'] = array_merge($this->session['master_account'], $data['master_account']);

        if (isset($data['user_data']))
            $this->session['user_data'] = array_merge($this->session['user_data'], $data['user_data']);


        if (isset($data['vote']))
            $this->session['vote'] = $data['vote'];


        //Триггер на очистку истекших сессия
        $this->clearSession();


        $STH = $this->db->prepare('UPDATE `mw_session` SET `data`= :data WHERE session_id = :session_id;');
        $STH->execute(
            array(
                ':data' => json_encode($this->session) ,
                ':session_id' => $this->getSessionId() ,
            )
        );
        return true;

    }

    /**
     * @return int
     */
    public function checkShield(){

        if ($this->session['master_account']['shield'] == 1)
            return 1;
        else
            return 0;

    }

    /**
     * @return string
     */
    public function getName(){

        if (is_array($this->session['master_account']['email']))
            return $this->session['master_account']['phone'];
        else
            return $this->session['master_account']['email'];

    }

    /**
     * @return bool|string
     */
    public function getPhone(){

        if (is_array($this->session['master_account']['phone']))
            return false;
        else
            return $this->session['master_account']['phone'];

    }

    /**
     * @return bool|string
     */
    public function getEmail(){

        if (is_array($this->session['master_account']['email']))
            return false;
        else
            return $this->session['master_account']['email'];

    }

    /**
     * @param bool $account_name
     * @param bool $full
     * @return array
     */
    public function getGameAccount($account_name = false, $full = false){
        $accounts = array();

        if (isset($this->session['user_data']["account"]) AND is_array($this->session['user_data']["account"])){
            if ($account_name === false){
                foreach ($this->session['user_data']["account"]  as $account => $char_list) {

                    if ($full)
                        $accounts[$account] = $char_list["info"];
                    else
                        $accounts[] = $account;

                }
            }else{
                if (isset($this->session['user_data']["account"][$account_name]) AND is_array($this->session['user_data']["account"][$account_name])) {
                    if (isset($this->session['user_data']["account"][$account_name]["info"]) AND is_array($this->session['user_data']["account"][$account_name]["info"])) {
                        $accounts[$account_name] = $this->session['user_data']["account"][$account_name]["info"];
                    }
                }
            }

        }
        return $accounts;
    }

    /**
     * @param bool $account_name
     * @param bool $full
     * @return array
     */
    public function getGameChars($account_name = false, $full = false){
        $chars = array();

        if (isset($this->session['user_data']["account"]) AND is_array($this->session['user_data']["account"])){
            if ($account_name === false){
                foreach ($this->session['user_data']["account"]  as $account => $char_list) {
                    $chars[$account] = array();
                    if (isset($char_list["char_list"]) AND is_array($char_list["char_list"])){
                        foreach ($char_list["char_list"] as $char){
                            if ($full)
                                $chars[$account][$char['id']] = $char;
                            else
                                $chars[$account][$char['id']] = $char['name'];
                        }
                    }
                }
            }else{
                if (isset($this->session['user_data']["account"][$account_name]) AND is_array($this->session['user_data']["account"][$account_name])) {
                    if (isset($this->session['user_data']["account"][$account_name]["char_list"]) AND is_array($this->session['user_data']["account"][$account_name]["char_list"])) {
                        foreach ($this->session['user_data']["account"][$account_name]["char_list"] as $char) {
                            if ($full)
                                $chars[$char['id']] = $char;
                            else
                                $chars[$char['id']] = $char['name'];
                        }
                    }
                }
            }

        }
        return $chars;
    }

    /**
     * @param string $type
     * @return int|string
     */
    public function getDiscount($type = 'game_valute'){

        if(isset($this->config['discount'][get_sid()])){

            if(isset($this->config['discount'][get_sid()][$type]) AND $this->config['discount'][get_sid()][$type]){
                return $this->session['user_data']['discount'];
            }else
                return 0;

        }elseif(isset($this->config['discount']['project'])){

            if(isset($this->config['discount']['project'][$type]) AND $this->config['discount']['project'][$type]){
                return $this->session['user_data']['discount'];
            }else
                return 0;

        }else{
            return 0;
        }

    }


    /**
     * @param $data
     * @return mixed
     */
    private function parsData($data){


        if (isset($data['user_data']["account"]) AND is_array($data['user_data']["account"])){
            $temp = array();

            foreach ($data['user_data']["account"] as $login => $account_info) {
                if (preg_match("/item\d/", $login)) {
                    $login = substr($login, 4);
                }

                $temp[$login] = $account_info;
            }
            $data['user_data']["account"] = $temp;
        }



        return $data;
    }

    /**
     * Очистка сессиий
     */
    private function clearSession(){

        if (get_cache('clear_session') == false){
            $this->db->query('DELETE FROM mw_session WHERE session_end < NOW();');
            set_cache('clear_session', 'true', CACHE_CLEAR_SESSION);
        }
    }
}