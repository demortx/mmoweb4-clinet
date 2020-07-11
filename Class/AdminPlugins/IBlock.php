<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class IBlock
{
    /* @var \Fenom $fenom */
    public $fenom;
    /* @var \AjaxMsg $ajaxmsg */
    public $ajaxmsg;
    public $config;
    /* @var \PDO $db */
    public $db;


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

        $table = $this->db->query("SHOW TABLES LIKE 'mw_iblock'")->fetch(\PDO::FETCH_ASSOC);
        if ($table === false){
            $this->install();
        }
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Настройки инфо блоков',
                'en' => 'Info Block Settings',
            ),
            'author' => 'Demort',
            'version' => '0.1'
        );
    }

    public function onLoad(){
        return false;
    }
    public function onMenu(){
        return array(
            array(
                'url' => set_url(ADMIN_URL.'/iblock'),
                'icon' => 'fa fa-3x fa-list-ul',
                'title' => get_lang('admin.lang')['btn_title_IBlock'],
                'desc' => get_lang('admin.lang')['btn_desc_IBlock'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'iblock'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'iblock'){


            if($s2 == 'add'){
                return $this->addIBlock();
            }elseif($s2 == 'add_save'){
                return $this->addIBlockSave();
            }elseif($s2 == 'edit'){
                return $this->openIBlockEdit();
            }elseif($s2 == 'edit_save'){
                return $this->openIBlockEditSave();
            }elseif($s2 == 'content'){
                return $this->contentList();
            }elseif($s2 == 'content_add'){
                return $this->addContent();
            }elseif($s2 == 'content_save'){
                return $this->addContentSave();
            }elseif($s2 == 'content_edit'){
                return $this->ContentEdit();
            }elseif($s2 == 'content_edit_save'){
                return $this->addContentEditSave();
            }else {

                if ($s2 == 'content_delete') {
                    $this->deleteContent();
                    return $this->contentList();
                }

                if ($s2 == 'delete')
                    $this->deleteIBlock();

                if ($s2 == 'delete_cache')
                    $this->deleteCacheIBlock();
            }



            return $this->index();
        }

    }

    public function index(){

        $iblock = $this->db->query('SELECT * FROM mw_iblock;')->fetchAll(\PDO::FETCH_ASSOC);
        return $this->fenom->fetch("panel:admin/IBlock/index.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'iblock_list' => $iblock,
                ),
                get_lang('admin.lang')
            )
        );
    }
    //Рендер шаблона добовление
    public function addIBlock(){
        return $this->fenom->fetch("panel:admin/IBlock/iblock_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                ),
                get_lang('admin.lang')
            )
        );
    }
    //POST сохранение
    public function addIBlockSave(){
        $STH = $this->db->prepare('INSERT INTO `mw_iblock` (`name`, `tpl`, `ikey`, `publish`)
                                            VALUES (:name, :tpl, :ikey, :publish);');
        $STH->bindValue(':name', trim($_POST['name']));
        $STH->bindValue(':tpl', trim($_POST['tpl']));
        $STH->bindValue(':ikey', trim($_POST['ikey']));
        $STH->bindValue(':publish', (int) $_POST['publish']);
        $STH->execute();
        $id = $this->db->lastInsertId();
        echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_create_success'])->location(ADMIN_URL.'/iblock/edit?iblock='.$id)->success();
        exit;
    }
    //Рендер шаблона редактирование
    public function openIBlockEdit(){
        if (isset($_GET['iblock'])){
            $id = intval($_GET['iblock']);
            $iblock = $this->db->query('SELECT * FROM `mw_iblock` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            return $this->fenom->fetch("panel:admin/IBlock/iblock_edit.tpl",
                array_merge(
                    array(
                        'iblock_param' => $iblock,
                        'iblock_select' => $id
                    ),
                    get_lang('admin.lang')
                )
            );
        }
        return error_404_html();
    }
    //POST редактирования
    public function openIBlockEditSave(){
        if (isset($_GET['iblock'])){
            $id = intval($_GET['iblock']);
            $iblock = $this->db->query('SELECT * FROM `mw_iblock` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            if ($iblock){
                $STH = $this->db->prepare('UPDATE `mw_iblock` SET `name`=:name, `tpl`=:tpl, `publish`=:publish WHERE id=:id;');
                $STH->bindValue(':name', trim($_POST['name']));
                $STH->bindValue(':tpl', trim($_POST['tpl']));
                $STH->bindValue(':publish', (int) $_POST['publish']);
                $STH->bindValue(':id', (int) $id);
                $STH->execute();

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_edit_success'])->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
        }else
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
        exit;
    }

    public function deleteIBlock(){
        if (isset($_GET['iblock'])){
            $id = intval($_GET['iblock']);
            $iblock = $this->db->query('SELECT * FROM `mw_iblock` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            $this->db->query('DELETE FROM `mw_iblock` WHERE id='.$id.';');
            $this->db->query('DELETE FROM `mw_iblock_content` WHERE ikey='.$this->db->quote($iblock['ikey']).';');
        }
    }


    public function deleteCacheIBlock(){

        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'iblock_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }


    }

    public function contentList(){
        if (isset($_GET['iblock'])){
            $id = intval($_GET['iblock']);

            $content = $this->db->query('
                        SELECT c.* 
                        FROM `mw_iblock_content` AS c
                        LEFT JOIN  `mw_iblock` AS b ON b.ikey=c.ikey
                        WHERE b.id='.$id.';')->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($content as $idc => &$item) {

                $item['json'] = json_decode($item['json'], true);
                $item['json'] = get_lang($item['json']);
                if (count($item['json'])) {
                    $item['img'] = isset($item['json']['img']) ? $item['json']['img'] : '#';
                    $item['title'] = isset($item['json']['title']) ? $item['json']['title'] : 'Новость повреждена';
                    $item['body'] = isset($item['json']['body']) ? $item['json']['body'] : 'Новость повреждена';
                    $item['url'] = isset($item['json']['url']) ? set_url($item['json']['url']) : '';
                    unset($item['json']);
                }else
                    unset($content[$idc]);
            }

            //json,publish


            return $this->fenom->fetch("panel:admin/IBlock/content_list.tpl",
                array_merge(
                    array(
                        'content_list' => $content,
                        'iblock_select' => $id
                    ),
                    get_lang('admin.lang')
                )
            );
        }
        return error_404_html();
    }

    public function addContent(){

        if (isset($_GET['iblock'])){
            $id = intval($_GET['iblock']);

            return $this->fenom->fetch("panel:admin/IBlock/content_add.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'iblock_select' => $id
                    ),
                    get_lang('admin.lang')
                )
            );
        }
        return error_404_html();


    }

    public function addContentSave(){
        if (isset($_GET['iblock'])) {
            $id = intval($_GET['iblock']);

            $iblock = $this->db->query('SELECT * FROM mw_iblock WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            if (is_array($iblock)) {

                $STH = $this->db->prepare('INSERT INTO `mw_iblock_content` (`ikey`,`json`, `date`, `publish`)
                                            VALUES (:ikey, :json, :date, :publish);');
                $STH->bindValue(':ikey', $iblock['ikey']);
                $STH->bindValue(':json', json_encode($_POST['content']));
                $STH->bindValue(':date', (isset($_POST['date']) AND !empty($_POST['date'])) ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s"));
                $STH->bindValue(':publish', (int)$_POST['publish']);
                $STH->execute();
                $cid = $this->db->lastInsertId();

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_content_add_success'])->location(ADMIN_URL.'/iblock/content_edit?iblock=' . $id . '&content=' . $cid)->success();
                exit;
            }
        }
        return error_404_html();
    }

    public function ContentEdit(){
        if (isset($_GET['content'])){
            $id = intval($_GET['iblock']);
            $cid = intval($_GET['content']);

            $content = $this->db->query('SELECT * FROM `mw_iblock_content` WHERE id='.$cid.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            $content['json'] = json_decode($content['json'], true);
            $content['date'] = date("Y-m-d\TH:i:s", strtotime($content['date']));


            return $this->fenom->fetch("panel:admin/IBlock/content_edit.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'content_param' => $content,
                        'content_select' => $cid,
                        'iblock_select' => $id
                    ),
                    get_lang('admin.lang')
                )
            );
        }

        return error_404_html();
    }

    public function addContentEditSave(){
        if (isset($_GET['content'])){
            $id = intval($_GET['content']);

            $content = $this->db->query('SELECT * FROM `mw_iblock_content` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            if ($content){
                $STH = $this->db->prepare('UPDATE `mw_iblock_content` SET `json` = :json, `date` = :date, `publish` = :publish WHERE id=:id;');

                $STH->bindValue(':json', json_encode($_POST['content']));
                $STH->bindValue(':date', (isset($_POST['date']) AND !empty($_POST['date'])) ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s"));
                $STH->bindValue(':publish', (int) $_POST['publish']);
                $STH->bindValue(':id', (int) $id);
                $STH->execute();

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_content_edit_success'])->success();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id_content'])->danger();

        }else
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id_content'])->danger();

        exit;
    }





    public function deleteContent(){
        if (isset($_GET['content'])){
            $id = intval($_GET['content']);
            $this->db->query('DELETE FROM `mw_iblock_content` WHERE id='.$id.';');
        }
    }

    public function install(){
        $this->db->query("
                                DROP TABLE IF EXISTS `mw_iblock`;
                                CREATE TABLE `mw_iblock` (
                                  `id` int(11) NOT NULL,
                                  `name` varchar(100) NOT NULL,
                                  `tpl` varchar(100) NOT NULL,
                                  `ikey` varchar(100) NOT NULL,
                                  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `publish` int(1) NOT NULL DEFAULT '1'
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_iblock`
                                  ADD PRIMARY KEY (`id`),
                                  ADD KEY `publish` (`publish`),
                                  ADD KEY `ikey` (`ikey`);
                                
                                ALTER TABLE `mw_iblock` ADD UNIQUE(`ikey`);
                                
                                ALTER TABLE `mw_iblock`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                                  
                                DROP TABLE IF EXISTS `mw_iblock_content`;
                                CREATE TABLE `mw_iblock_content` (
                                  `id` int(11) NOT NULL,
                                  `ikey` varchar(100) NOT NULL,
                                  `json` mediumtext NOT NULL,
                                  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `publish` int(1) NOT NULL DEFAULT '1'
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_iblock_content`
                                  ADD PRIMARY KEY (`id`),
                                  ADD KEY `publish` (`publish`),
                                  ADD KEY `ikey` (`ikey`);
                                
                                ALTER TABLE `mw_iblock_content`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }


}