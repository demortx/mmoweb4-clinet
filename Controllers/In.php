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

    public function prefix_list(){

        if($this->config['cabinet']['registration_login_prefix']) {
            if(isset($_SESSION['prefix_list']))
                unset($_SESSION['prefix_list']);

            $i = 0;
            while ($i < $this->config['cabinet']['registration_login_prefix_count']) {
                $i++;
                $_SESSION['prefix_list'][] = prefix();
            }
            foreach ($_SESSION['prefix_list'] as $px) {
                $send[] = array('name' => $px, 'value' => $px);
            }

            echo $this->ajaxmsg->set_select('.prefix_select', $send)->send();
        }

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

    public function promo_game(){

        if (!isset($_POST['id']) AND empty($_POST['id']))
            exit($this->ajaxmsg->notify('Empty ID promo')->post('error_id')->danger());

        if (!isset($this->config['promo_game'][(int)$_POST['id']]) AND !is_array($this->config['promo_game'][(int)$_POST['id']]))
            exit($this->ajaxmsg->notify('There are no promo settings')->post('not_settings')->danger());

        if (isset($_POST['start'])){
            $_SESSION['promo_game'] = array(
                'id' => $_POST['id'],
                'items' => array(),
                'status' => 'start'
            );
            exit($this->ajaxmsg->notify('Game data cleared')->post('start')->success());
        }

        if(isset($_POST['give'])){

            if (!isset($_SESSION['promo_game']['items']))
                exit($this->ajaxmsg->notify('You need to start the game')->post('need_start')->danger());

            if ($this->config['promo_game'][(int)$_POST['id']]['max'] <= (count($_SESSION['promo_game']['items']) + 1))
                exit($this->ajaxmsg->notify('You won max number of items: '.$this->config['promo_game'][(int)$_POST['id']]['max'])->post('max_win')->danger());


            $items = $this->get_random_item((int)$_POST['id'], 1, (count($_SESSION['promo_game']['items']) + 1));
            if (count($items) > 0){
                foreach ($items as $id => $item){
                    $_SESSION['promo_bonus'][] = $id;
                }

                if ($this->config['promo_game'][(int)$_POST['id']]['max'] <= (count($_SESSION['promo_game']['items']) + 1)){
                    $_SESSION['promo_game']['status'] = 'finish';
                    $finish = true;
                }else{
                    $_SESSION['promo_game']['status'] = 'wait';
                    $finish = false;
                }


                exit($this->ajaxmsg->notify('Your prize')->post(['items' => $items, 'next' => $finish])->success());
            }

        }


    }

    private function get_random_item($id, $count = 1, $group = 0)
    {

        $i = 0;
        $item_delivery = array();
        while ($i < $count) {

            $chance = mt_rand(1, 1000) / 10;
            $chance_sum = 0;

            foreach ($this->config['promo_game'][$id]['items'] as $iid => $item) {

                if (isset($item['gr'])) {
                    if ($item['gr'] != $group)
                        continue;
                }

                $chance_sum += floatval($item["chance"]);
                if ($chance <= $chance_sum) {
                    $item_delivery[$iid] = $item;
                    break;
                }
            }


            $i++;
        }

        return $item_delivery;


    }

}