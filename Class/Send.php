<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
 * Date: 06.10.2015
 ********************************/

class Send {

    private $curl;
    public $url;
    public $key;
    public $debug;
    public $core;
    public $sid_send;
    public $gzcompress = false;

    public function __construct($api_url = null,$api_key = null){
        global $work;

        $this->gzcompress = $work['gzcompress'];

        $this->url = $api_url.'api';
        $this->key = $api_key;
        $this->debug = DEBUG;
        $this->curl = new \Curl\Curl($this->url);

        $lang = isset($GLOBALS['_POST']['lang']) ? $GLOBALS['_POST']['lang'] : select_lang();
        $this->curl->setCookie('lang', $lang);


        //$this->curl->setOpt(CURLOPT_COOKIEJAR, ROOT_DIR.'/cache/cookie.txt');
        //$this->curl->setOpt(CURLOPT_COOKIEFILE, ROOT_DIR.'/cache/cookie.txt');

        $this->core = &get_instance();
    }

    public function sendServer($Params,$test = false , $msg_time_out = 'echo' , $timeout = true){

        
        if( !$this->core->session->getSpam() AND $timeout) {
            if($msg_time_out == 'echo') {
                echo $this->core->ajaxmsg->text("Server timeout 2 seconds")->warning();
                exit;
            }elseif($msg_time_out == 'return')
                return array("type"=>"msg","text"=>"Server timeout 2 seconds","status"=>"warning","time"=>2500);
        }

        $Params['gzc'] = $this->gzcompress;
        $Params['ip'] = ip_address();
        $Params['lang'] = select_lang();
        $Params['pid'] = $this->core->config["global"]["project_id"];
        $Params['secret_key'] = $this->core->config["global"]["secret_key"];
        $Params['user'] = $this->getBrowser();

        if( $this->core->session->isLogin() ) {
            $Params['session'] = $this->core->session->get("session_id");
            $Params['sid'] = select_server();
        }else {
            foreach(get_instance()->config["server"] as $sid => $data){
                if($sid != 0) {
                    $this->sid_send = $sid;
                    break;
                }
            }
            $Params['sid'] = $this->sid_send;
        }
        ksort($Params);

        # Формируем параметры и создаем секретный ключ
        $Params = array_merge(array("api_key" => hash("sha512", multi_implode("|", $Params) . "|" . $this->key)), $Params);

        $Params = array("POST" => json_encode($Params));


        #logs
        if($this->debug) {

            $newfile = false;
            $fwriteLog = '';

            if ( ! file_exists("debug/curl_debug_pack_" . date("m.d.y") . ".php")) {
                $newfile = TRUE;
            }

            $F = fopen("debug/curl_debug_pack_" . date("m.d.y") . ".php", "a+");

            if($newfile){
                $fwriteLog .= "<?php defined('ROOT_DIR') OR exit('No direct script access allowed'); ?>\n\n";
            }

            $fwriteLog .= "SEND --" . json_encode($Params) . "\r\n";
            $time = startTime();
        }



        http_build_query($Params);
        $this->core->session->addSpam();
        $this->curl->post($this->url, $Params);

        if($this->debug) {
            $fwriteLog .= "REPLY --" . $this->curl->response . "\r\n";
            $fwriteLog .= stopTime($time) ." | Date - ".date("H:i:s")." | Size - ".strlen($this->curl->response)."\r\n";
        }

        if ($this->curl->error) {
            if ($this->debug) {
                $fwriteLog .= 'Error: ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\r\n";
                $fwriteLog .= "--------Error-------\r\n";
                fwrite($F, $fwriteLog);
                fclose($F);
            }
            return false;
        } else {

            if ($this->gzcompress)
                $POST = json_decode(@gzuncompress($this->curl->response), true);
            else
                $POST = json_decode($this->curl->response, true);

            # SAVE POST: api_key & clear api_key global post
            $api_key = $POST["api_key"];
            unset($POST["api_key"]);

            # Sorting global post

            @ksort($POST);

            $real_api_key = hash("sha512", multi_implode("|", $POST) . "|" . $this->key);

            if ($test) {
                return $POST;
            } else {

                # Compares the key

                if (true/*$real_api_key === $api_key*/) {
                    if ($this->debug) {
                        $fwriteLog .= "--------Success-----\r\n";
                        fwrite($F, $fwriteLog);
                        fclose($F);
                    }


                    #Удаление сессии
                    if (isset($POST['end_session'])) {
                        set_cookie('id_mw', null, -1);

                    }#Отлавливаем обновление сессии
                    else if (isset($POST['send_data'])) {
                        $this->core->session->update($POST['send_data']);
                    }

                    return $POST;
                } else {
                    if ($this->debug) {
                        $fwriteLog .= "Error: KEY!!!\r\n";
                        $fwriteLog .= "--------Error-------\r\n";
                        fwrite($F, $fwriteLog);
                        fclose($F);
                    }
                    return false;
                }
            }

        }



    }

    public function send_curl( $url, $Params , $debug = false ){

        $curl = new \Curl\Curl($url);


        if( !$this->core->session->getSpam()) {
            echo $this->core->ajaxmsg->text("Server timeout 2 seconds")->warning();
            exit;
        }

        if( $this->core->session->isLogin() )
            $Params = array_merge(array("ip" => ip_address() , "lang" => select_lang() , "session" => $this->core->session->get( "session_id" ) , 'sid' => select_server() , 'secret_key' => $this->core->config["global"]["secret_key"]), $Params);
        else
            $Params = array_merge(array("ip" => ip_address() , "lang" => select_lang(), 'secret_key' => $this->core->config["global"]["secret_key"] ), $Params);

        ksort($Params);

        # Формируем параметры и создаем секретный ключ
        $Params = array_merge(array("api_key" => hash("sha512", multi_implode("|", $Params) . "|" . $this->key)), $Params);
        //$Params = array("POST" => json_encode($Params));

        $this->core->session->addSpam();
        $curl->post($url, $Params);

        if ($curl->error) {
            if($debug) {
                echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\r\n";
            }
            return false;
        }
        else {

            return $curl->response;

        }

    }

    public function showSever($Params)
    {

        ksort($Params);

        # Формируем параметры и создаем секретный ключ
        $Params = array_merge(array("api_key" => hash("sha512", multi_implode("|", $Params) . "|" . $this->key)), $Params);



        echo json_encode($Params);
    }

    //Getting Browser
    public function getBrowser()
    {
        $u_agent  = $_SERVER['HTTP_USER_AGENT'];
        $bname    = 'Unknown';
        $platform = 'Unknown';
        $version  = "";

        //Getting Platform (OS)
        //Linux
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
            //Mac OS
        } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
            $platform = 'Mac OS';
            if (preg_match('/macintosh|mac os x/i', $u_agent)) {
                $platform .= ' X';
            } elseif (preg_match('/mac_powerpc/i', $u_agent)) {
                $platform .= ' 9';
            }
        }
        //Windows
        elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
            $platform = 'Windows';
            if (preg_match('/NT 10/i', $u_agent)) {
                $platform .= ' 10';
            } elseif (preg_match('/NT 6.3/i', $u_agent)) {
                $platform .= ' 8.1';
            } elseif (preg_match('/NT 6.2/i', $u_agent)) {
                $platform .= ' 8';
            } elseif (preg_match('/NT 6.1/i', $u_agent)) {
                $platform .= ' 7';
            } elseif (preg_match('/NT 6.0/i', $u_agent)) {
                $platform .= ' Vista';
            } elseif (preg_match('/NT 5.2/i', $u_agent)) {
                $platform .= ' Server 2003/XP';
            } elseif (preg_match('/NT 5.1/i', $u_agent)) {
                $platform .= ' XP';
            } elseif (preg_match('/XP/i', $u_agent)) {
                $platform .= ' XP';
            } elseif (preg_match('/ME/i', $u_agent)) {
                $platform .= ' ME';
            } elseif (preg_match('/NT 5.0/i', $u_agent)) {
                $platform .= ' 2000';
            } elseif (preg_match('/win98/i', $u_agent)) {
                $platform .= ' 98';
            } elseif (preg_match('/win95/i', $u_agent)) {
                $platform .= ' 95';
            } elseif (preg_match('/win16/i', $u_agent)) {
                $platform .= ' 3.11';
            }
            if (preg_match('/WOW64/i', $u_agent) || preg_match('/x64/i', $u_agent)) {
                $platform .= ' (x64)';
            } else {
                $platform .= ' (x86)';
            }
        }
        //Ubuntu
        elseif (preg_match('/ubuntu/i', $u_agent)) {
            $platform = 'Ubuntu';
        }
        //BlackBerry
        elseif (preg_match('/blackberry/i', $u_agent)) {
            $platform = 'BlackBerry';
        }
        //Mobile
        elseif (preg_match('/webos/i', $u_agent)) {
            $platform = 'Mobile';
        }
        //iPhone
        elseif (preg_match('/iphone/i', $u_agent)) {
            $platform = 'iPhone OS';
        }
        //iPod
        elseif (preg_match('/ipod/i', $u_agent)) {
            $platform = 'iPod OS';
        }
        //iPad
        elseif (preg_match('/ipad/i', $u_agent)) {
            $platform = 'iPad OS';
        }
        //Android
        elseif (preg_match('/android/i', $u_agent)) {
            $platform = 'Android';
            if (preg_match('/Android 5.1/i', $u_agent)) {
                $platform .= ' 5.1';
            } elseif (preg_match('/Android 5.0/i', $u_agent)) {
                $platform .= ' 5.0';
            } elseif (preg_match('/Android 4.4/i', $u_agent)) {
                $platform .= ' 4.4';
            } elseif (preg_match('/Android 4.3/i', $u_agent)) {
                $platform .= ' 4.3';
            } elseif (preg_match('/Android 4.2/i', $u_agent)) {
                $platform .= ' 4.2';
            } elseif (preg_match('/Android 4.1/i', $u_agent)) {
                $platform .= ' 4.1';
            } elseif (preg_match('/Android 4.0/i', $u_agent)) {
                $platform .= ' 4.0';
            } elseif (preg_match('/Android 3.2/i', $u_agent)) {
                $platform .= ' 3.2';
            } elseif (preg_match('/Android 3.1/i', $u_agent)) {
                $platform .= ' 3.1';
            } elseif (preg_match('/Android 3.0/i', $u_agent)) {
                $platform .= ' 3.0';
            } elseif (preg_match('/Android 2.3/i', $u_agent)) {
                $platform .= ' 2.3';
            } elseif (preg_match('/Android 2.2/i', $u_agent)) {
                $platform .= ' 2.2';
            } elseif (preg_match('/Android 2.1/i', $u_agent)) {
                $platform .= ' 2.1';
            } elseif (preg_match('/Android 2.0/i', $u_agent)) {
                $platform .= ' 2.0';
            } elseif (preg_match('/Android 1.6/i', $u_agent)) {
                $platform .= ' 1.6';
            } elseif (preg_match('/Android 1.5/i', $u_agent)) {
                $platform .= ' 1.5';
            } elseif (preg_match('/Android 1.0/i', $u_agent)) {
                $platform .= ' 1.0';
            }
        }

        // Getting Browser Name and Version
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub    = "MSIE";
        } elseif (preg_match('/Trident/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub    = "Trident";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Microsoft Edge';
            $ub    = "Edge";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub    = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub    = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub    = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub    = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub    = "Netscape";
        } elseif (preg_match('/Maxthon/i', $u_agent)) {
            $bname = 'Maxthon';
            $ub    = "Maxthon";
        } elseif (preg_match('/Konqueror/i', $u_agent)) {
            $bname = 'Konqueror';
            $ub    = "Konqueror";
        } elseif (preg_match('/mobile/i', $u_agent)) {
            $bname = 'Mobile Browser';
            $ub    = "Mobile Browser";
        } elseif (preg_match('/seamonkey/i', $u_agent)) {
            $bname = 'Mozilla SeaMonkey';
            $ub    = "Seamonkey";
        } elseif (preg_match('/navigator/i', $u_agent)) {
            $bname = 'Navigator';
            $ub    = "Navigator";
        } elseif (preg_match('/mosaic/i', $u_agent)) {
            $bname = 'Mosaic';
            $ub    = "Mosaic";
        } elseif (preg_match('/lynx/i', $u_agent)) {
            $bname = 'Lynx';
            $ub    = "Lynx";
        } elseif (preg_match('/amaya/i', $u_agent)) {
            $bname = 'Amaya';
            $ub    = "Amaya";
        } elseif (preg_match('/omniweb/i', $u_agent)) {
            $bname = 'OmniWeb';
            $ub    = "Omniweb";
        } elseif (preg_match('/avant/i', $u_agent)) {
            $bname = 'Avant';
            $ub    = "Avant";
        } elseif (preg_match('/camino/i', $u_agent)) {
            $bname = 'Camino';
            $ub    = "Camino";
        } elseif (preg_match('/flock/i', $u_agent)) {
            $bname = 'Flock';
            $ub    = "Flock";
        } elseif (preg_match('/aol/i', $u_agent)) {
            $bname = 'Aol';
            $ub    = "Aol";
        }

        //Getting Browser Version
        $known   = array(
            'Version',
            $ub,
            'other'
        );
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // No matches, just continue
        }

        $i = count($matches['browser']);
        if ($i != 1) {
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            //'userAgent' => $u_agent,
            'name' => $bname,
            'platform' => $platform,
            //'version' => $version,
            //'pattern' => $pattern
        );
    }


}