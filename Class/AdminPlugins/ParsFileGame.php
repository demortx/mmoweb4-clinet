<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;


use ParserItem;
use PDO;

class ParsFileGame
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;


    public $sid;
    public $platform;
    public $action = array(
        'index',
        'open',
        'delete',
        'parser',
        'install',
        'icon',
    );

    public $files = array(
        'lineage2' => array(
            'itemname-e.txt',
            'armorgrp.txt',
            'etcitemgrp.txt',
            'weapongrp.txt',
        ),
        'boi' => array(
            'itemname-e.txt',
        ),


    );
    public function __construct(&$fenom, &$ajaxmsg, &$config)
    {
        $this->fenom = $fenom;
        $this->ajaxmsg = $ajaxmsg;
        $this->config = $config;
        try {
            $this->db = get_instance()->db();
        }catch (\Exception $e){
            echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
            exit;
        }


        $table = $this->db->query("SHOW TABLES LIKE 'mw_item_db'")->fetch(\PDO::FETCH_ASSOC);
        if ($table === false){
            $this->install();
        }
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Парсер игровых файлов',
                'en' => 'Game file parser',
            ),
            'author' => 'Demort',
            'version' => '0.2'
        );
    }

    public function onLoad(){
        return false;
    }
    public function onMenu(){
        return array(
            array(
                'url' => set_url(ADMIN_URL.'/files'),
                'icon' => 'fa fa-3x fa-cube',

                'title' => get_lang('admin.lang')['btn_title_ParsFileGame'],
                'desc' => get_lang('admin.lang')['btn_desc_ParsFileGame'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'files'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'files')
            return $this->files_pars_tpl($s2);

    }


    //Парсер файлов
    public function files_pars_tpl($s2){
        $this->action = array(
            'index',
            'open',
            'delete',
            'parser',
            'install',
            'icon',
        );
        if (isset($_GET['sid'])){
            $this->sid = intval($_GET['sid']);
            foreach ($this->config['project']['server_info'] as $platform => $server_list) {
                foreach ($server_list as $sid => $server) {
                    if ($this->sid == $sid){
                        $this->platform = $platform;
                    }
                }
            }
        }

        if ($s2) {
            if (in_array($s2, $this->action))
                $action = $s2;
        }

        if (!isset($action))
            $action = empty($this->sid) ? 'index' : 'open';


        return $this->fenom->fetch("panel:admin/ParsFileGame/admin.tpl",
            array_merge(
                array(
                    'block_content' => $this->$action(),
                    'config' => $this->config
                ),
                get_lang('admin.lang')
            )
        );
    }



    public function index(){
        return '<h3 class="block-title pb-20">'.get_lang('admin.lang')['ParsFileGame_select_game_srv'].'</h3>';
    }

    public function open(){

        $query = $this->db->prepare('SELECT COUNT(id) as item FROM `mw_item_db` WHERE `sid` = :sid;');
        $query->bindValue(':sid', $this->sid);
        $query->execute();
        $items = $query->fetch(PDO::FETCH_ASSOC);


        $query = $this->db->prepare("SELECT COUNT(id) as item FROM `mw_item_db` WHERE `sid` = :sid AND icon='';");
        $query->bindValue(':sid', $this->sid);
        $query->execute();
        $no_icon = $query->fetch(PDO::FETCH_ASSOC);




        $files_check = array();
        //Проверка наличие файлов
        foreach ($this->files[$this->platform] as $file){
            $files_check[$file] = file_exists(ROOT_DIR.'/Files/'.$this->sid.'/'.$file) ? true : ROOT_DIR.'/Files/'.$this->sid.'/'.$file;
        }



        return $this->fenom->fetch("panel:admin/ParsFileGame/open.tpl",
            array_merge(
                array(
                    'select_sid' => $this->sid,
                    'count_item' => $items['item'],
                    'no_icon' => $no_icon['item'],
                    'files_check' => $files_check,
                    'select_platform' => $this->platform,
                    'config' => $this->config
                ),
                get_lang('admin.lang')
            )
        );

    }

    public function delete(){
        $query = $this->db->prepare('DELETE FROM `mw_item_db` WHERE `sid` = :sid;');
        $query->bindValue(':sid', $this->sid);
        $query->execute();


        return get_lang('admin.lang')['ParsFileGame_delete_db'];
    }

    public function parser(){

        if (isset($_POST['type'])){
            $parser = new ParserItem($this->platform, $_POST['type']);
            $files = array();
            //Проверка наличие файлов
            foreach ($this->files[$this->platform] as $file){
                $files[$file] = ROOT_DIR.'/Files/'.$this->sid.'/'.$file;
            }
            $items = $parser->loadFiles($files)->parsStart();
            if (is_array($items)){
                unset($parser);
                $this->db->beginTransaction();
                $i = 0;
                foreach ($items as $id => $item){
                    $i++;
                    $this->db->prepare("INSERT INTO mw_item_db(`item_id`,`name`,`add_name`,`description`,`icon`,`icon_panel`,`grade`,`stackable`,`sid`) VALUES(:item_id, :name, :add_name, :description, :icon, :icon_panel, :grade, :stackable, :sid);")
                        ->execute(
                            array(
                                ':item_id' => $id,
                                ':name' => $item['name'],
                                ':add_name' => $item['add_name'],
                                ':description' => $item['description'],
                                ':icon' => $item['icon'],
                                ':icon_panel' => $item['icon_panel'],
                                ':grade' => $item['grade'],
                                ':stackable' => $item['stackable'],
                                ':sid' => $this->sid
                            ));

                    if ($i >= 1000){
                        $this->db->commit();
                        $i = 0;
                        $this->db->beginTransaction();
                    }
                }
                $this->db->commit();

                echo $this->ajaxmsg->notify(get_lang('signin.admin.lang')['parser_ajax_success'])->eval_js('document.location.reload(true);')->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('signin.admin.lang')['parser_ajax_error_files'])->danger();


        }else{
            echo $this->ajaxmsg->notify(get_lang('signin.admin.lang')['parser_ajax_error'])->danger();
        }
        exit;

    }

    public function icon(){

        $query = $this->db->prepare("SELECT * FROM `mw_item_db` WHERE `sid` = :sid AND icon='';");
        $query->bindValue(':sid', $this->sid);
        $query->execute();
        $no_icon = $query->fetchAll(PDO::FETCH_ASSOC);


        return $this->fenom->fetch("panel:admin/ParsFileGame/no_icon.tpl",
            array_merge(
                array(
                    'select_sid' => $this->sid,
                    'no_icon' => $no_icon,
                    'select_platform' => $this->platform,
                    'config' => $this->config
                ),
                get_lang('admin.lang')
            )
        );

    }

    public function install(){
        $this->db->query("
                                DROP TABLE IF EXISTS `mw_item_db`;
                                CREATE TABLE `mw_item_db` (
                                  `id` int(11) NOT NULL,
                                  `item_id` bigint(20) NOT NULL,
                                  `name` varchar(250) DEFAULT NULL,
                                  `add_name` varchar(250) DEFAULT NULL,
                                  `description` varchar(1200) DEFAULT NULL,
                                  `icon` varchar(100) DEFAULT NULL,
                                  `icon_panel` varchar(100) DEFAULT NULL,
                                  `grade` varchar(3) DEFAULT NULL,
                                  `stackable` int(1) NOT NULL DEFAULT '0',
                                  `sid` int(11) NOT NULL DEFAULT '0'
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_item_db`
                                  ADD PRIMARY KEY (`id`),
                                  ADD KEY `item_id` (`item_id`),
                                  ADD KEY `sid` (`sid`);
                                
                                ALTER TABLE `mw_item_db`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }
    //Парсер файлов конец

}