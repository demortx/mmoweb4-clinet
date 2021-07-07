<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 24.09.2019
 * Time: 17:18
 */


namespace Support;


use ApiLib\GlobalApi;

class func
{

    public $this_main = false;
    //Language/support.lang.php
    public $category = array(
        //0 => 'Выберите категорию',
        1 => 'Общие вопросы',
        2 => 'Сайт, Форум, ЛК',
        3 => 'Ошибки клиента',
        4 => 'Ошибки игры',
        5 => 'Блокировка аккаунта/персонажа',
        6 => 'Пропажа предметов',
        7 => 'Жалоба на бота',
        8 => 'Проблемы с пополнением пожертвованиями',
        9 => 'Прочее',

    );
    public $payment_list = array(
        'freekassa',
        'g2a',
        'unitpay',
        'payu',
        'paypal',
        'payop',
        'paymentwall',
        'pagseguro',
        'nextpay',
        'paygol',
        'alikassa',
        'enot',
        'ipay',
        'paysafecard',
        'ips_payment',
        'digiseller',
        'qiwi',
    );
    //Список тикетов
    public $tickets = array(
            'awaiting_user' => array(),      //Ожидает ответа от пользователя
            'awaiting_admin' => array(),  //Ожидает ответа от администратора
            'closed' => array(),    //Закрыт
        );
    public function __construct($this_main)
    {
        /**@var $this_main \Modules\Plugins\Support\Support*/
        $this->this_main = $this_main;

        if (isset(get_instance()->config['payment_system']['sorting_pay']))
            $this->payment_list = get_instance()->config['payment_system']['sorting_pay'];
    }

    public function widget_ticket_index(){

        get_instance()->seo->addTeg('head', 'bpdt_css', 'link', array('rel' => 'stylesheet', 'href' => VIEWPATH.'/panel/assets/js/plugins/bootstrap-dynamic-tabs/bootstrap-dynamic-tabs.css'));
        get_instance()->seo->addTeg('footer', 'bpdt_js', 'script', array('src' => VIEWPATH.'/panel/assets/js/plugins/bootstrap-dynamic-tabs/bootstrap-dynamic-tabs.js'));

        return get_instance()->fenom->fetch(
            get_tpl_file('widget_ticket_index.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'content_ticket_list' => $this->fragment_ticket_list(),
                    'char_list' => get_instance()->session->getGameChars(),
                    'new_ticket_form' => $this->new_ticket_form(0, false)

                ),
                get_lang('support.lang')
            )

        );


    }

    /* AJAX */

    public function ajax_get_all_ticket(){

        $api = new GlobalApi();
        $vars = array('temp');

        if (get_instance()->session->isLogin()) {

            $response = $api->get_all_tickets($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data)) {


                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);
                        get_instance()->session->rebootSession();


                        $send = get_instance()->ajaxmsg->html($this->fragment_ticket_list(), '#ticket-list-all')->notify((string)$response["response"]->success)->success();

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();

                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_open_ticket(){

        $api = new GlobalApi();
        $vars = array();

        if (get_instance()->session->isLogin()) {


            //Проверка сервера
            if (!isset($_REQUEST['tid']) OR empty($_REQUEST['tid']))
                return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_tid'])->danger();
            else
                $vars['tid'] = intval($_REQUEST['tid']);



            $response = $api->get_ticket($vars);


            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->ticket)) {

                        $data = json_encode($response["response"]->ticket);
                        $data = json_decode($data, true);
                        /*->notify((string)$response["response"]->success)*/
                        $send = get_instance()->ajaxmsg->callback('window.openTicket',$data);

                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;


    }

    public function ajax_change_ticket_type(){
        if (get_instance()->session->isLogin()) {

            //Проверка сервера
            if (!isset($_REQUEST['category']))
                return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_category'])->danger();
            else
                $category = intval($_REQUEST['category']);

            $send = get_instance()->ajaxmsg->html($this->new_ticket_form($category, true), '#content-new-ticket')->success();
        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();

        return $send;

    }

    public function attachments(){


        // initialize FileUploader
        $FileUploader = new \FileUploader('files', array(
            'limit' => LIMIT_FILES,
            'maxSize' => null,
            'fileMaxSize' => MAX_SIZE,
            'extensions' => ['jpg', 'gif', 'png',],
            'required' => false,
            'uploadDir' => ROOT_DIR.'/Files/support/',
            'title' => ['auto', 12],
            'replace' => true,
            'editor' => array(
                'maxWidth' => null,
                'maxHeight' => null,
                'crop' => false,
                'quality' => 70
            ),
            'listInput' => true,
            'files' => null
        ));

        // call to upload the files
        $data = $FileUploader->upload();


        if ($data['hasWarnings'] == false AND $data['isSuccess'] == false)
            return null;
        elseif($data['hasWarnings'] == true)
            return array('error' => implode("<br>", $data['warnings']));
        elseif($data['isSuccess'] == true){
            $files = array();
            foreach ($data['files'] as $f){
                if ($f['uploaded'])
                    $files[] = $f['file'];
            }
            return $files;
        }else
            return null;

    }

    public function ajax_create_ticket(){
        $api = new GlobalApi();
        $vars = array();


        if (!isset($_REQUEST['category']) OR empty($_REQUEST['category']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_category'])->danger();
        else
            $vars['category'] = $_REQUEST['category'];

        if (!isset($_REQUEST['details']) OR empty($_REQUEST['details']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_details'])->danger();
        else
            $vars['details'] = $_REQUEST['details'];

        if (!isset($_REQUEST['title']) OR empty($_REQUEST['title']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_title'])->danger();
        else
            $vars['title'] = $_REQUEST['title'];

        if (!isset($_REQUEST['message']) OR empty($_REQUEST['message']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_message'])->danger();
        else
            $vars['message'] = $_REQUEST['message'];

        $attachments = $this->attachments();
        if (!empty($attachments)){
            if (isset($attachments['error']))
                return get_instance()->ajaxmsg->notify($attachments['error'])->danger();
            else
                $vars['attachments'] = $attachments;
        }


        if (get_instance()->session->isLogin()) {

            $response = $api->create_ticket($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);
                        get_instance()->session->rebootSession();

                        //tid
                        $ticket = json_encode($response["response"]->ticket);
                        $ticket = json_decode($ticket, true);

                        $send = get_instance()->ajaxmsg->html($this->fragment_ticket_list(), '#ticket-list-all')->notify((string)$response["response"]->success)->callback('window.openTicket',$ticket);
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;

    }

    public function ajax_send_msg(){
        $api = new GlobalApi();
        $vars = array();

        if (!isset($_REQUEST['ticket_id']) OR empty($_REQUEST['ticket_id']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_tid'])->danger();
        else
            $vars['tid'] = intval($_REQUEST['ticket_id']);

        if (!isset($_REQUEST['message']) OR empty($_REQUEST['message']))
            return get_instance()->ajaxmsg->notify(get_lang('support.lang')['support_ajax_empty_message'])->danger();
        else
            $vars['message'] = $_REQUEST['message'];

        $attachments = $this->attachments();
        if (!empty($attachments)){
            if (isset($attachments['error']))
                return get_instance()->ajaxmsg->notify($attachments['error'])->danger();
            else
                $vars['attachments'] = $attachments;
        }


        if (get_instance()->session->isLogin()) {

            $response = $api->answer_ticket($vars);

            if ($response['ok']) {

                if (isset($response['error'])) {
                    if (isset($response["response"]->input))
                        $send = get_instance()->ajaxmsg->notify($response['error'])->input_error($response["response"]->input)->danger();
                    else
                        $send = get_instance()->ajaxmsg->notify($response['error'])->danger();

                } else {

                    if (isset($response["response"]->data->user_data)) {

                        $data = json_encode($response["response"]->data);
                        $data = json_decode($data, true);
                        get_instance()->session->updateSessionDB($data);
                        get_instance()->session->rebootSession();

                        $message = array(
                            'tid' => $vars['tid'],
                            'text' => $vars['message'],
                            'attachments' => isset($vars['attachments']) ? $vars['attachments'] : null,
                            'date_create' => date("Y-m-d H:i:s"),
                        );

                        $send = get_instance()->ajaxmsg->html($this->fragment_ticket_list(), '#ticket-list-all')/*->notify((string)$response["response"]->success)*/->callback('window.sendTicket',$message);
                    } else
                        $send = get_instance()->ajaxmsg->notify(get_lang('signin.lang')['signin_ajax_login_error'])->danger();
                }

            } else {
                $send = get_instance()->ajaxmsg->notify('Error: ' . $response['http_error'] . '<br>Code: ' . $response['http_code'])->danger();
            }

        }else
            $send = get_instance()->ajaxmsg->notify(get_lang('api.lang')['session_lost'])->location('sign-in')->danger();


        return $send;
    }

    public function fragment_ticket_list(){

        if (isset(get_instance()->session->getSession()["user_data"]["support"]["ticket_list"])){

            $ticket_list = get_instance()->session->getSession()["user_data"]["support"]["ticket_list"];
            if (is_array($ticket_list) AND count($ticket_list) > 0){
                //0-создан, 1-есть ответственный, 2-получен ответ, 3-ожидает ответа, 4- отменён, 5-закрыт
                foreach ($ticket_list as $ticket) {

                    if (in_array($ticket['status'], array(2))){
                        $this->tickets['awaiting_user'][] = $ticket;
                    }elseif (in_array($ticket['status'], array(0,1,3))){
                        $this->tickets['awaiting_admin'][] = $ticket;
                    }elseif (in_array($ticket['status'], array(4,5))){
                        $this->tickets['closed'][] = $ticket;
                    }
                }
            }
        }

        return get_instance()->fenom->fetch(
            get_tpl_file('fragment_ticket_list.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'tickets' => $this->tickets
                ),
                get_lang('support.lang')
            )
        );
    }

    public function new_ticket_form($type = 1, $ajax = false){

        switch ($type){
            case 6:
                $template = 'template_ticket_6.tpl';
                $param = array();
                break;
            case 7:
                $template = 'template_ticket_7.tpl';
                $param = array();
                break;
            case 8:
                $template = 'template_ticket_8.tpl';
                $param = array(
                    'payment_system' => get_instance()->config['payment_system'],
                    'payment_list' => $this->payment_list
                );
                break;
            default:
                $template = 'template_ticket_0.tpl';
                $param = array();
        }


        return get_instance()->fenom->fetch(
            get_tpl_file('new_ticket_form.tpl', get_class($this->this_main)),
            array_merge(
                array(
                    'ajax' => $ajax,
                    'category_select' => $type,
                    'template_ticket' => get_instance()->fenom->fetch(get_tpl_file($template, get_class($this->this_main)),array_merge($param,get_lang('support.lang'))),
                ),
                get_lang('support.lang')
            )
        );
    }

}