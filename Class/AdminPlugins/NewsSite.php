<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 14.03.2020
 * Time: 23:31
 */

namespace AdminPlugins;
use PDO;

class NewsSite
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

        $table = $this->db->query("SHOW TABLES LIKE 'mw_news'")->fetch(\PDO::FETCH_ASSOC);
        if ($table === false){
            $this->install();
        }
    }

    static function info(){
        return array(
            'name' => array(
                'ru' => 'Новости для сайта',
                'en' => 'News for the site',
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
                'url' => set_url(ADMIN_URL.'/news'),
                'icon' => 'fa fa-3x fa-newspaper-o',
                'title' => get_lang('admin.lang')['btn_title_NewsSite'],
                'desc' => get_lang('admin.lang')['btn_desc_NewsSite'],
            ),

        );
    }
    public function onUrl(){
        return array(
            'news'
        );
    }
    public function onRender($s1, $s2){

        if ($s1 == 'news'){

            if($s2 == 'add'){
                return $this->addNews();
            }elseif($s2 == 'add_save'){
                return $this->addNewsSave();
            }elseif($s2 == 'edit'){
                return $this->openNewsEdit();
            }elseif($s2 == 'edit_save'){
                return $this->openNewsEditSave();
            }else {

                if($s2 == 'delete')
                    $this->deleteNews();

                if($s2 == 'delete_cache')
                    $this->deleteCacheNews();

                return $this->news_list();
            }
        }

    }


    public function news_list(){
        $news_list = $this->db->query('SELECT * FROM `mw_news` ORDER BY fixed DESC, publish,`date` DESC;')->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($news_list as &$news) {
            $news['json'] = json_decode($news['json'], true);
            $news['json'] = get_lang($news['json']);
        }



        return $this->fenom->fetch("panel:admin/NewsSite/news_list.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                    'news_list' => $news_list,
                ),
                get_lang('admin.lang')
            )
        );
    }

    public function addNews(){
        return $this->fenom->fetch("panel:admin/NewsSite/news_add.tpl",
            array_merge(
                array(
                    'language_list' => $this->config["site"]["language_list"],
                ),
                get_lang('admin.lang')
            )
        );
    }


    public function addNewsSave(){

        $STH = $this->db->prepare('INSERT INTO `mw_news` (`json`, `date`, `author`, `publish`, `fixed`)
                                            VALUES (:json, :date, :author, :publish, :fixed);');

        $STH->bindValue(':json', json_encode($_POST['news']));
        $STH->bindValue(':date', (isset($_POST['date']) AND !empty($_POST['date'])) ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s"));
        $STH->bindValue(':author', (isset($_POST['author']) AND !empty($_POST['author'])) ? $_POST['author'] : 'Admin');
        $STH->bindValue(':publish', (int) $_POST['publish']);
        $STH->bindValue(':fixed', (int) $_POST['fixed']);
        $STH->execute();
        $id = $this->db->lastInsertId();

        echo $this->ajaxmsg->notify(get_lang('admin.lang')['NewsSite_ajax_add_news'])->location(ADMIN_URL.'/news/edit?news='.$id)->success();
        exit;

    }

    public function openNewsEdit(){
        if (isset($_GET['news'])){
            $id = intval($_GET['news']);

            $news = $this->db->query('SELECT * FROM `mw_news` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            $news['json'] = json_decode($news['json'], true);
            $news['date'] = date("Y-m-d\TH:i:s", strtotime($news['date']));


            return $this->fenom->fetch("panel:admin/NewsSite/news_edit.tpl",
                array_merge(
                    array(
                        'language_list' => $this->config["site"]["language_list"],
                        'news_param' => $news,
                        'news_select' => $id
                    ),
                    get_lang('admin.lang')
                )
            );
        }

        return error_404_html();
    }

    public function openNewsEditSave(){

        if (isset($_GET['news'])){
            $id = intval($_GET['news']);

            $news = $this->db->query('SELECT * FROM `mw_news` WHERE id='.$id.' LIMIT 1;')->fetch(\PDO::FETCH_ASSOC);

            if ($news){
                $STH = $this->db->prepare('UPDATE `mw_news` SET `json` = :json, `date` = :date, `author` = :author, `publish` = :publish, `fixed` = :fixed WHERE id=:id;');

                $STH->bindValue(':json', json_encode($_POST['news']));
                $STH->bindValue(':date', (isset($_POST['date']) AND !empty($_POST['date'])) ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s"));
                $STH->bindValue(':author', (isset($_POST['author']) AND !empty($_POST['author'])) ? $_POST['author'] : 'Admin');
                $STH->bindValue(':publish', (int) $_POST['publish']);
                $STH->bindValue(':fixed', (int) $_POST['fixed']);
                $STH->bindValue(':id', (int) $id);
                $STH->execute();

                echo $this->ajaxmsg->notify(get_lang('admin.lang')['NewsSite_ajax_edit_news'])->success();
            }else
                echo $this->ajaxmsg->notify('Не передан ид новости')->danger();


        }else
            echo $this->ajaxmsg->notify(get_lang('admin.lang')['NewsSite_ajax_not_id'])->danger();


        exit;
    }

    public function deleteNews(){
        if (isset($_GET['news'])){
            $id = intval($_GET['news']);
            $this->db->query('DELETE FROM `mw_news` WHERE id='.$id.';')->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function deleteCacheNews(){

        $cache = scandir(ROOT_DIR.CACHEPATH);
        foreach ($cache as $file) {
            if($file != "." && $file != ".."){
                if (strripos($file, 'news_') !== false){
                    unlink(ROOT_DIR.CACHEPATH.'/'.$file);
                }
            }
        }


    }

    public function install(){
        $this->db->query("
                                DROP TABLE IF EXISTS `mw_news`;
                                CREATE TABLE `mw_news` (
  `id` int(11) NOT NULL,
  `json` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(100) NOT NULL,
  `publish` int(1) NOT NULL DEFAULT '1',
  `fixed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mw_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publish` (`publish`),
  ADD KEY `fixed` (`fixed`);

ALTER TABLE `mw_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
    }

}