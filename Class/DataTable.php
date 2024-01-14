<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
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

}