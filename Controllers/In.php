<?php
/********************************
 * Dev and Code by Demort
 * email : demortx@mail.ru
 * Date: 06.10.2015
 ********************************/
if (!defined('ROOT_DIR')) {
    exit ("Error, wrong way to file.<a href=\"/\">Go to main</a>.");
}


class In extends Controller
{

    public function index()
    {

        $send = 'Not found action!';
        $module_form = isset($GLOBALS['_POST']['module_form']) ? $GLOBALS['_POST']['module_form'] : false;
        $module = isset($GLOBALS['_POST']['module']) ? $GLOBALS['_POST']['module'] : false;
        if ($module_form AND $module) {

            if (isset($this->ajax_data[$module_form])) {

                if (isset($this->ajax_data[$module_form][$module])) {

                    if ($send = $this->ajax_data[$module_form][$module]())

                        if (empty($send))
                            $send = $this->ajaxmsg->notify('This module does not accept requests. (array)' . $module_form)->danger();

                } else
                    $send = $this->ajaxmsg->notify('Method - ' . $module . ' not found module - ' . $module_form)->danger();
            } else
                $send = $this->ajaxmsg->notify('Module not found - ' . $module_form)->danger();


        } else
            $send = $this->ajaxmsg->notify('The module name is not passed')->danger();

        echo $send;

    }

    public function captchaImg(){

        $libCap = new \Captcha();
        $libCap->prime();
        $libCap->draw(110, 32);

    }

    public function txt(){

        $type = isset($_GET['type']) ? $_GET['type'] : '';

        if(file_exists( ROOT_DIR . VIEWPATH. "/panel/txt/".select_lang()."/$type.tpl")){

            $this->fenom->setOptions(~Fenom::AUTO_STRIP);
            $txt =  $this->fenom->fetch("panel:/txt/".select_lang()."/$type.tpl",array_merge(
                $this->config['project'],
                $_GET
            ));

        }else{
            show_404();
            exit;
        }

        if(isset($_GET['email']))
            $name_txt = $_GET['email'];
        elseif(isset($_GET['phone']))
            $name_txt = $_GET['phone'];
        elseif(isset($_GET['login']))
            $name_txt = $_GET['login'];
        else
            $name_txt = 'file';

        if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
            Header('Content-Type: application/force-download');
        else
            Header('Content-Type: application/octet-stream');
        Header('Accept-Ranges: bytes');
        Header('Content-Length: '.strlen($txt));
        Header("Content-Disposition: attachment; filename=\"".$this->config['project']['name']." - ".$name_txt.".txt\"");
        echo $txt;


    }

}