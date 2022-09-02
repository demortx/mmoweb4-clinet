<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class PatchNotes
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
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Настройки патчноутов',
                'en' => 'Patch notes settings',
            ),
            'author' => 'mmoweb',
            'version' => '0.1'
        );
    }

    public function onLoad(){
        return false;
    }
    public function onMenu(){
        return array(
            array(
                'url' => set_url(ADMIN_URL.'/patchnotes'),
                'icon' => 'fa fa-3x fa-list',
                'title' => get_lang('admin.lang')['btn_title_PatchNotes'],
                'desc' => get_lang('admin.lang')['btn_desc_PatchNotes'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'patchnotes'
        );
    }
    public function onRender($s1, $s2){
        //$this->install();
        if ($s1 == 'patchnotes'){


            if (empty($s2)){
                return $this->patchnotes_list();
            }elseif ($s2 == 'add'){
                return $this->patchnotes_add();
            }elseif ($s2 == 'edit'){
                return $this->patchnotes_edit();
            }elseif ($s2 == 'delete'){
                $this->patchnotes_delete();
            }


            if ($s2 == 'section'){
                return $this->section_list();
            }elseif ($s2 == 'section_add'){
                return $this->section_add();
            }elseif ($s2 == 'section_edit'){
                return $this->section_edit();
            }elseif ($s2 == 'section_delete'){
               $this->section_delete();
            }


            if ($s2 == 'content'){
                return $this->content_list();
            }elseif ($s2 == 'content_add'){
                return $this->content_add();
            }elseif ($s2 == 'content_edit'){
                return $this->content_edit();
            }elseif ($s2 == 'content_delete'){
                $this->content_delete();
            }

            if ($s2 == 'delete_cache'){
                $this->delete_cache();
            }

            return $this->patchnotes_list();

        }

    }


    public function patchnotes_list(){

        $patchnotes = $this->db->query('SELECT * FROM mw_patchnotes ORDER BY `date` DESC;')->fetchAll(\PDO::FETCH_ASSOC);

        return $this->fenom->fetch("panel:admin/PatchNotes/patchnotes_list.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'patchnotes' => $patchnotes,
                ),
                get_lang('admin.lang')
            )
        );

    }
    public function patchnotes_add(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $STH = $this->db->prepare('INSERT INTO `mw_patchnotes` (`name`, `date`, `publish`, `img`)
                                            VALUES (:name, :date, :publish, :img);');
            $STH->bindValue(':name', json_encode($_POST['name']));
            $STH->bindValue(':date', empty($_POST['date']) ? date("Y-m-d"): $_POST['date']);
            $STH->bindValue(':publish', (int)$_POST['publish']);
            $STH->bindValue(':img', $_POST['img']);
            $STH->execute();
            $id = $this->db->lastInsertId();
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_create_success'])->location(ADMIN_URL.'/patchnotes')->success();
            exit;
        }

        return $this->fenom->fetch("panel:admin/PatchNotes/patchnotes_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'type' => 'add',
                ),
                get_lang('admin.lang')
            )
        );

    }
    public function patchnotes_edit(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['patchnotes'])){
                $id = intval($_POST['patchnotes']);
                $patchnotes = $this->db->query('SELECT * FROM `mw_patchnotes` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
                if ($patchnotes){
                    $STH = $this->db->prepare('UPDATE `mw_patchnotes` SET `name`=:name, `publish`=:publish, `date` = :date, `img` = :img WHERE id=:id;');
                    $STH->bindValue(':name', json_encode($_POST['name']));
                    $STH->bindValue(':date', empty($_POST['date']) ? date("Y-m-d"): $_POST['date']);
                    $STH->bindValue(':publish', (int)$_POST['publish']);
                    $STH->bindValue(':img', $_POST['img']);
                    $STH->bindValue(':id', (int) $id);
                    $STH->execute();

                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_edit_success'])->success();
                }else
                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            exit;

        }

        if (isset($_GET['patchnotes'])){
            $id = intval($_GET['patchnotes']);
            $patchnote = $this->db->query('SELECT * FROM `mw_patchnotes` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            $patchnote['name'] = json_decode($patchnote['name'], true);

            return $this->fenom->fetch("panel:admin/PatchNotes/patchnotes_add.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'type' => 'edit',
                        'content_param' => $patchnote,
                    ),
                    get_lang('admin.lang')
                )
            );
        }
    }
    public function patchnotes_delete(){
        if (isset($_GET['patchnotes'])){
            $id = intval($_GET['patchnotes']);
            $this->db->query('DELETE FROM `mw_patchnotes` WHERE id='.$id.';');
            $this->db->query('DELETE FROM `mw_patchnotes_section` WHERE patchnotes_id='.$id.';');
        }
    }


    public function section_list(){
        if (isset($_GET['patchnotes'])) {
            $id = intval($_GET['patchnotes']);
            $section = $this->db->query('SELECT * FROM mw_patchnotes_section WHERE patchnotes_id = '.$id.'  ORDER BY `sort` ASC;')->fetchAll(\PDO::FETCH_ASSOC);
            return $this->fenom->fetch("panel:admin/PatchNotes/section_list.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'sections' => $section,
                    ),
                    get_lang('admin.lang')
                )
            );
        }
    }
    public function section_add(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $STH = $this->db->prepare('INSERT INTO `mw_patchnotes_section` (`name`, `publish`, `sort`, `patchnotes_id`)
                                            VALUES (:name, :publish, :sort, :patchnotes_id);');
            $STH->bindValue(':name', json_encode($_POST['name']));
            $STH->bindValue(':publish', (int)$_POST['publish']);
            $STH->bindValue(':sort', (int)$_POST['sort']);
            $STH->bindValue(':patchnotes_id', (int)$_POST['patchnotes']);
            $STH->execute();
            $id = $this->db->lastInsertId();
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_create_success'])->location(ADMIN_URL.'/patchnotes/section?patchnotes='.(int)$_POST['patchnotes'])->success();
            exit;
        }

        return $this->fenom->fetch("panel:admin/PatchNotes/section_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'type' => 'section_add'
                ),
                get_lang('admin.lang')
            )
        );
    }
    public function section_edit(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['section'])){
                $id = intval($_POST['section']);
                $section = $this->db->query('SELECT * FROM `mw_patchnotes_section` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
                if ($section){
                    $STH = $this->db->prepare('UPDATE `mw_patchnotes_section` SET `name`=:name, `publish`=:publish, `sort` = :sort WHERE id=:id;');
                    $STH->bindValue(':name', json_encode($_POST['name']));
                    $STH->bindValue(':publish', (int)$_POST['publish']);
                    $STH->bindValue(':sort', (int)$_POST['sort']);
                    $STH->bindValue(':id', (int) $id);
                    $STH->execute();

                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_edit_success'])->success();
                }else
                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            exit;

        }

        if (isset($_GET['section'])){
            $id = intval($_GET['section']);
            $section = $this->db->query('SELECT * FROM `mw_patchnotes_section` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            $section['name'] = json_decode($section['name'], true);

            return $this->fenom->fetch("panel:admin/PatchNotes/section_add.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'type' => 'section_edit',
                        'content_param' => $section,
                    ),
                    get_lang('admin.lang')
                )
            );
        }
    }
    public function section_delete(){
        if (isset($_GET['section'])){
            $id = intval($_GET['section']);
            $this->db->query('DELETE FROM `mw_patchnotes_section` WHERE id='.$id.';');
            $this->db->query('DELETE FROM `mw_patchnotes_content` WHERE section_id='.$id.';');
        }
    }


    public function content_list(){
        if (isset($_GET['section'])) {
            $id = intval($_GET['section']);
            $contents = $this->db->query('SELECT * FROM mw_patchnotes_content WHERE section_id = '.$id.'  ORDER BY `sort` ASC;')->fetchAll(\PDO::FETCH_ASSOC);
            $section = $this->db->query('SELECT * FROM `mw_patchnotes_section` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            $section['name'] = json_decode($section['name'], true);
            return $this->fenom->fetch("panel:admin/PatchNotes/content_list.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'contents' => $contents,
                        'section' => $section,
                    ),
                    get_lang('admin.lang')
                )
            );
        }
    }

    public function content_add(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $STH = $this->db->prepare('INSERT INTO `mw_patchnotes_content` (`name`, `content`,`date`, `publish`, `sort`, `section_id`)
                                            VALUES (:name, :content, :date, :publish, :sort, :section_id);');
            $STH->bindValue(':name', json_encode($_POST['name']));
            $STH->bindValue(':content', json_encode($_POST['html']));
            $STH->bindValue(':date', empty($_POST['date']) ? date("Y-m-d"): $_POST['date']);
            $STH->bindValue(':publish', (int)$_POST['publish']);
            $STH->bindValue(':sort', (int)$_POST['sort']);
            $STH->bindValue(':section_id', (int)$_POST['section']);
            $STH->execute();
            $section = $this->db->query('SELECT * FROM `mw_patchnotes_section` WHERE id='.(int)$_POST['section'].' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            //$id = $this->db->lastInsertId();
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_create_success'])->location(ADMIN_URL.'/patchnotes/content?section='.(int)$_POST['section'].'&patchnotes='.$section['patchnotes_id'])->success();
            exit;
        }

        return $this->fenom->fetch("panel:admin/PatchNotes/content_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'type' => 'content_add'
                ),
                get_lang('admin.lang')
            )
        );
    }
    public function content_edit(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['content'])){
                $id = intval($_POST['content']);
                $section = $this->db->query('SELECT * FROM `mw_patchnotes_content` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
                if ($section){
                    $STH = $this->db->prepare('UPDATE `mw_patchnotes_content` SET `name`=:name, `content`=:content, `date`=:date, `publish`=:publish, `sort` = :sort WHERE id=:id;');
                    $STH->bindValue(':name', json_encode($_POST['name']));
                    $STH->bindValue(':content', json_encode($_POST['html']));
                    $STH->bindValue(':date', empty($_POST['date']) ? date("Y-m-d"): $_POST['date']);
                    $STH->bindValue(':publish', (int)$_POST['publish']);
                    $STH->bindValue(':sort', (int)$_POST['sort']);
                    $STH->bindValue(':id', (int) $id);
                    $STH->execute();

                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_edit_success'])->success();
                }else
                    echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            }else
                echo $this->ajaxmsg->notify(get_lang('admin.lang')['IBlock_ajax_not_id'])->danger();
            exit;

        }

        if (isset($_GET['content'])){
            $id = intval($_GET['content']);
            $content = $this->db->query('SELECT * FROM `mw_patchnotes_content` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);
            $content['name'] = json_decode($content['name'], true);
            $content['content'] = json_decode($content['content'], true);

            return $this->fenom->fetch("panel:admin/PatchNotes/content_add.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'type' => 'content_edit',
                        'content_param' => $content,
                    ),
                    get_lang('admin.lang')
                )
            );
        }
    }
    public function content_delete(){
        if (isset($_GET['content'])){
            $id = intval($_GET['content']);
            $this->db->query('DELETE FROM `mw_patchnotes_content` WHERE id='.$id.';');
        }
    }


    public function delete_cache(){

        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'patchnotes_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }


    }

    public function install(){
        $this->db->query("
                                DROP TABLE IF EXISTS `mw_patchnotes`;
                                CREATE TABLE `mw_patchnotes` (
                                  `id` int(11) NOT NULL,
                                  `name` mediumtext NOT NULL,
                                  `date` datetime NOT NULL,
                                  `publish` int(1) NOT NULL DEFAULT '1',
                                  `img` varchar(255) NOT NULL DEFAULT ''
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_patchnotes`
                                  ADD PRIMARY KEY (`id`);
                                
                                ALTER TABLE `mw_patchnotes`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                                  
                                  
                                  
                                DROP TABLE IF EXISTS `mw_patchnotes_section`;
                                CREATE TABLE `mw_patchnotes_section` (
                                  `id` int(11) NOT NULL,
                                  `name` mediumtext NOT NULL,
                                  `publish` int(1) NOT NULL DEFAULT '1',
                                  `sort` int(5) NOT NULL,
                                  `patchnotes_id` int(11) NOT NULL
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_patchnotes_section`
                                  ADD PRIMARY KEY (`id`),
                                   ADD KEY `publish` (`publish`),
                                   ADD KEY `patchnotes_id` (`patchnotes_id`),
                                  ADD KEY `sort` (`sort`);
                                  
                                ALTER TABLE `mw_patchnotes_section`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                                  
                                  
                                DROP TABLE IF EXISTS `mw_patchnotes_content`;
                                CREATE TABLE `mw_patchnotes_content` (
                                  `id` int(11) NOT NULL,
                                  `name` mediumtext NOT NULL,
                                  `content` mediumtext NOT NULL,
                                  `date` datetime NOT NULL,
                                  `publish` int(1) NOT NULL DEFAULT '1',
                                   `sort` int(5) NOT NULL,
                                   `section_id` int(11) NOT NULL
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                
                                ALTER TABLE `mw_patchnotes_content`
                                  ADD PRIMARY KEY (`id`),
                                  ADD KEY `publish` (`publish`),
                                  ADD KEY `section_id` (`section_id`),
                                   ADD KEY `sort` (`sort`);
                                
                                ALTER TABLE `mw_patchnotes_content`
                                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }


}