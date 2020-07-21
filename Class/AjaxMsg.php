<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
 * Date: 23.12.2015
 ********************************/
if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}



class AjaxMsg
{

    public $response = array();

    public function eval_js($js){
        if(!empty($js)){
            if(!empty($this->response["eval"]))
                $this->response["eval"] .= $js;
            else
                $this->response["eval"] = $js;
        }



        return $this;
    }

    public function location($location = '/' , $time_sleep = 2000){

        if(!empty($location)) {
            $this->response["location"] = set_url($location, true);
            $this->response["time_sleep"] = $time_sleep;
        }
        return $this;

    }

    public function text($title ,$text){
        $this->response["text"] = $text;
        $this->response["title"] = $title;
        return $this;
    }

    public function input_error($input_error = null){
        if(!empty($input_error) AND (is_array($input_error) OR is_object($input_error))){
            foreach ((array)$input_error as $name => $text){

                if(strripos((string)$name, '.') !== false){
                    $temp = explode('.' , $name);
                    $name = '';
                    foreach ($temp as $segment){
                        if(empty($name))
                            $name .= $segment;
                        else
                            $name .= "[".$segment."]";
                    }
                }
                $this->response["input"][(string)$name] = (string)$text;
            }
        }

        return $this;
    }

    public function post($data){
        $this->response["post"] = $data;
        return $this;
    }

    public function notify($text, $url = null, $icon = null , $status = null , $time_show = 2000){
        if(!empty($text)){
            $this->response["text"] = (string) $text;

            if($icon != null)
                $this->response["icon"] = $icon;
            if($url != null) {
                $this->response["location"] = set_url($url);
                $this->response["time_sleep"] = $time_show;
            }
            if($status != null)
                $this->response["status"] = $status;
            if($time_show != null)
                $this->response["time_show"] = $time_show;

        }
        return $this;
    }

    public function set_select($select_el, $select_set){
        $this->response["select_el"] = $select_el;
        $this->response["select_set"] = $select_set;
        return $this;
    }

    public function popup_close($id = "modal-ajax"){
        if(!empty($id)){
            if(!empty($this->response["eval"]))
                $this->response["eval"] .= "jQuery('#{$id}').modal('hide');";
            else
                $this->response["eval"] = "jQuery('#{$id}').modal('hide');";
        }
        return $this;
    }
    /*
     * modal-sm
     * modal-lg
     * modal-xl
     */
    public function popup($title, $content_html, $footer = '', $size = ''){
        $this->response["title"] = $title;
        $this->response["content"] = $content_html;
        $this->response["footer"] = $footer;
        $this->response["size"] = $size;

        $this->response["popup"] = true;
        return $this;
    }

    public function html($html , $html_div = null){
        if(!empty($html)){
            $this->response["html"] = (string)$html;

            if($html_div != null)
                $this->response["html_div"] = (string)$html_div;
        }
        return $this;
    }

    public function callback($callback_name , $data = null){
        if(!empty($callback_name)){
            $this->response["callback"] = $callback_name;

            if($data != null)
                $this->response["data"] = $data;
        }
        return json_encode($this->response);
    }

    public function success(){
        $this->response["status"] = 'success';
        return json_encode($this->response);
    }

    public function warning(){
        $this->response["status"] = 'warning';
        return json_encode($this->response);
    }

    public function info(){
        $this->response["status"] = 'info';
        return json_encode($this->response);
    }

    public function danger(){
        $this->response["status"] = 'danger';
        return json_encode($this->response);
    }
    public function error(){
        $this->response["status"] = 'error';
        return json_encode($this->response);
    }

    public function send(){
        return json_encode($this->response);
    }

}