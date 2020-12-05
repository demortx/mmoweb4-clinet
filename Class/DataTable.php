<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 17.01.2020
 * Time: 11:46
 */


class DataTable
{

    private $db;
    /** @var \Fenom $fenom */
    private $fenom;
    private $request;

    private $module_form;
    private $method;
    private $class;
    private $post = array();
    private $form_add = array();
    private $btn_add = array();
    private $DataTable = array();
    private $search_filter = array();
    private $db_inquiry;
    private $select;
    private $primary_key;

    /**
     * DataTable constructor.
     * @param string $module_form
     * @param string $method
     */
    public function __construct($module_form = 'Modules\\\Global\\\DataTable\\\DataTable', $method = 'ajax_test')
    {

        $this->module_form = $module_form;
        $this->method = $method;


        $this->fenom = get_instance()->fenom;
        $this->request = $_POST;
    }

    /**
     * @param array $post
     */
    public function addPost(array $post){
        $this->post = $post;
    }

    /**
     * @param array $DataTable
     * @return $this
     */
    public function loudColumn(array $DataTable){

        $this->DataTable = $DataTable;

        return $this;
    }

    /**
     * @param array $search_filter
     * @return $this
     */
    public function loudSearchFilter(array $search_filter){

        $this->search_filter = $search_filter;

        return $this;
    }

    /**
     * @param $db_inquiry
     * @param string $select
     * @param string $primary_key
     * @return $this
     */
    public function loudDatabase($db_inquiry, $select = '', $primary_key = 'id'){
        $this->db_inquiry = $db_inquiry;
        $this->select = $select;
        $this->primary_key = $primary_key;

        return $this;
    }

    /**
     * @param $class
     */
    public function set_class($class){
        $this->class = $class;
    }

    /**
     * @param array $btn
     */
    public function add_btn(array $btn){
        $this->btn_add = $btn;
    }

    /**
     * @param array $btn
     */
    public function add_form(array $form){
        $this->form_add = $form;
    }

    /**
     * @return mixed
     */
    public function renderTemplate(){

        return $this->fenom->fetch("panel:libraries/DataTable.tpl",
            array(
                'DataTable'=> $this->DataTable,
                'module_form'=> $this->module_form,
                'ajax_module'=> $this->method,
                'ajax_post'=> $this->post,
                'class'=> $this->class,
                'btn_add'=> $this->btn_add,
                'form_add'=> $this->form_add,
            ));

    }

    /**
     * @return false|string
     */
    public function ajaxResult()
    {


        $columns = $this->request['columns'];
        $draw = $this->request['draw'];
        $start = $this->request['start'];
        $length = $this->request['length'];
        $order = $this->request['order'];
        $search = $this->request['search'];

        //Подставляем запрос

        $result = $this->db_inquiry;
        $result = $result()->select($this->select);
        if (!empty($search['value']) and count($this->search_filter)) {
            $first = true;
            $result = $result->groupStart();
            foreach ($this->search_filter as $column) {

                if ($first) {
                    $result = $result->like($column, trim($search['value']));
                    $first = false;
                } else
                    $result = $result->orLike($column, trim($search['value']));

            }
            $result = $result->groupEnd();
        }

        //обработка сортировки
        $order_ = true;
        if (isset($order) && count($order)) {
            foreach ($order as $order_val) {
                $key = $columns[$order_val['column']]['name'];
                if (isset($this->DataTable[$key])) {
                    if ($columns[$order_val['column']]['orderable'] == 'true') {
                        $dir = $order_val['dir'] === 'asc' ? 'ASC' : 'DESC';
                        $result = $result->orderBy($key, $dir);
                        $order_ = false;
                    }
                }
            }
        }

        if (!empty($this->primary_key) AND $order_){
            $result = $result->orderBy($this->primary_key, 'DESC');
        }



        //Обработка пагинации
        if (isset($start) && $length != -1) {
            $result = $result->get($length, $start);
        }

        $result = $result->getResultArray();

        $out = array();

        foreach ($result as $value) {
            $row = array();
            foreach ($this->DataTable as $name_colum => $data) {
                if (isset($data['formatter'])) {
                    $row[$data['position']] = $data['formatter']((isset($value[$name_colum]) ? $value[$name_colum] : NULL), $value);
                } else {
                    $row[$data['position']] = $value[$name_colum];
                }
            }
            $out[] = $row;
        }
        $result = $out;
        unset($out, $row);

        // Data set length after filtering
        //Получение всех записей с учетом выборки  //Подставляем запрос

        $recordsFiltered = $this->db_inquiry;

        $recordsFiltered = $recordsFiltered()->select('COUNT(' . $this->primary_key . ') as count_log');
        if (!empty($search['value']) and count($this->search_filter)) {
            $first = true;
            $recordsFiltered = $recordsFiltered->groupStart();
            foreach ($this->search_filter as $column) {
                if ($first) {
                    $recordsFiltered = $recordsFiltered->like($column, trim($search['value']));
                    $first = false;
                } else
                    $recordsFiltered = $recordsFiltered->orLike($column, trim($search['value']));
            }
            $recordsFiltered = $recordsFiltered->groupEnd();
        }
        $recordsFiltered = $recordsFiltered
            ->get()
            ->getRowArray()['count_log'];


        //Получение всех записей //Подставляем запрос
        $recordsTotal = $this->db_inquiry;
        $recordsTotal = $recordsTotal()->select('COUNT(' . $this->primary_key . ') as count_log')->get()->getRowArray()['count_log'];

        return json_encode(array(
            "draw" => isset ($draw) ? intval($draw) : 0,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $result
        ));


    }



}