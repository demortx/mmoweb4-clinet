<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 03.12.2019
 * Time: 21:53
 */

class ParserItem
{

    public $platform;
    public $type;
    public $files_list;

    public function __construct($platform, $type)
    {
        $this->platform = $platform;
        $this->type = $type;

    }

    public function loadFiles($files_list){

        switch ($this->platform){

            case 'lineage2':

                $this->files_list = $files_list;
                break;

        }

        return $this;
    }

    public function parsStart(){

        switch ($this->platform){

            case 'lineage2':

                return $this->lineage2();
                break;

        }
    }

    public function lineage2(){

        $items = array();

        if ($this->type == 'L2FileEdit'){

            foreach ($this->files_list as $file_name => $dir) {

                if ($file_name == 'itemdata.txt')
                    continue;


                $temp = $this->L2FileEdit($dir, 'id');

                foreach ($temp as $item_id=>$item) {

                    if ($file_name == 'itemname-e.txt'){

                        $items[$item_id]['name'] = $item['name'];
                        $items[$item_id]['add_name'] = $item['add_name'];
                        $items[$item_id]['description'] = filter_var(str_replace(array('u,', '\\0'), "", $item['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $items[$item_id]['icon'] = '';
                        $items[$item_id]['icon_panel'] = '';
                        $items[$item_id]['grade'] = '';
                        $items[$item_id]['type'] = '';
                        $items[$item_id]['stackable'] = 0;

                    }else{
                        if(!isset($items[$item_id]))continue;


                        if (isset($item["crystal_type"])){
                            $item["crystal_type"] = str_replace(array("[", "]"), "", $item["crystal_type"]);
                            $items[$item_id]['grade'] = $item["crystal_type"] == 'crystal_free' ? '' : $item["crystal_type"];
                        }

                        if (isset($item["consume_type"])){
                            $item["consume_type"] = str_replace(array("[", "]"), "", $item["consume_type"]);
                            switch($item["consume_type"]){
                                case"consume_type_normal":    $items[$item_id]['stackable'] = 0; break;
                                case"consume_type_stackable": $items[$item_id]['stackable'] = 1; break;
                                case"consume_type_asset":     $items[$item_id]['stackable'] = 1; break;
                            }
                        }

                        if(!empty(trim($item['icon[4]']))){
                            $items[$item_id]['icon'] = explode(".", trim($item['icon[4]']));
                            $items[$item_id]['icon'] = array_pop($items[$item_id]['icon']);
                        }else{
                            $items[$item_id]['icon'] = explode(".", $item['icon[0]']);
                            $items[$item_id]['icon'] = array_pop($items[$item_id]['icon']);
                        }


                    }
                }
                unset($temp);
            }


        }elseif ($this->type == 'L2ClientDat'){

            foreach ($this->files_list as $file_name => $dir) {

                if ($file_name == 'itemdata.txt')
                    continue;

                if ($file_name == 'itemname-e.txt') {
                    $temp = $this->L2ClientDat($dir, 2, 1, -1, -1, array('name', 'additionalname', 'description'));
                }else
                    $temp = $this->L2ClientDat($dir, 2, 1, -1, -1, array('icon', 'icon_panel', 'crystal_type', 'consume_type'));

                foreach ($temp as $item_id=>$item) {

                    if ($file_name == 'itemname-e.txt'){

                        $item['additionalname'] = $this->trim($item['additionalname']);
                        if ($item['additionalname'] == 'None'){
                            $item['additionalname'] = '';
                        }

                        $items[$item_id]['name'] = $this->trim($item['name']);
                        $items[$item_id]['add_name'] = $item['additionalname'];
                        $items[$item_id]['description'] = filter_var($this->trim($item['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $items[$item_id]['icon'] = '';
                        $items[$item_id]['icon_panel'] = '';
                        $items[$item_id]['grade'] = '';
                        $items[$item_id]['type'] = '';
                        $items[$item_id]['stackable'] = 0;

                    }else{
                        if(!isset($items[$item_id]))continue;


                        if (isset($item["crystal_type"])){
                            $item["crystal_type"] = str_replace(array("[", "]"), "", $item["crystal_type"]);
                            $items[$item_id]['grade'] = $item["crystal_type"] == 'crystal_free' ? '' : $item["crystal_type"];
                        }

                        if (isset($item["consume_type"])){
                            $item["consume_type"] = str_replace(array("[", "]"), "", $item["consume_type"]);
                            switch($item["consume_type"]){
                                case"consume_type_normal":    $items[$item_id]['stackable'] = 0; break;
                                case"consume_type_stackable": $items[$item_id]['stackable'] = 1; break;
                                case"consume_type_asset":     $items[$item_id]['stackable'] = 1; break;
                            }
                        }



                        if (isset($item["icon_panel"]) AND !empty($item["icon_panel"])) {
                            $item["icon_panel"] = trim($item['icon_panel']);
                            $item["icon_panel"] = str_replace(array("[", "]", "{", "}"), "", $item["icon_panel"]);
                            $item["icon_panel"] = explode(";", $item["icon_panel"]);
                            $items[$item_id]['icon_panel'] = strtolower($item["icon_panel"][0]);
                        }

                        if (isset($item["icon"]) AND !empty($item["icon"])) {
                            $item["icon"] = explode("]", $this->trim($item["icon"], 2));
                            $item["icon"] = explode(".", $item["icon"][0]);
                            $items[$item_id]['icon'] = strtolower($item["icon"][count($item["icon"]) - 1]);
                        }
                    }

                }
                unset($temp);

            }



        }

        //парсим PTS itemdata.txt нужна только для маркета
        if (count($items) > 0) {
            foreach ($this->files_list as $file_name => $dir) {

                if ($file_name == 'itemdata.txt' AND file_exists($dir)) {
                    $items_server = $this->getServerFile($dir);
                    foreach ($items_server as $id => $it){
                        if (isset($items[$id])){
                            $items[$id]['grade'] = $it['grade'];
                            $items[$id]['stackable'] = $it['stackable'];
                            $items[$id]['type'] = $it['gtype'];
                        }
                    }
                    //$items
                }
            }
        }


        return $items;




    }



    ///L2FileEdit START
    public function L2FileEdit($file,$index='id'){


        if(!file_exists( $file))
            exit('not fount file ' . $file);


        @$file = fopen($file, "r");

        $header = explode("\t", trim(fgets($file, 8000)));
        if ($index == NULL) {
            $index = $header[0];
        }
        $index = explode(",", $index);
        $res = array();
        while (!feof($file)) {



            $str = explode("\t", trim(fgets($file, 8000)));


            if (count($str) < 2) continue;
            $resStr = array();
            foreach ($header as $col => $val) {
                if (!isset($str[$col]))
                    continue;
                $resStr[$val] = $str[$col];
                $prefix = substr($str[$col], 0, 2);
                if ($prefix === "a,") {
                    if (strlen($resStr[$val]) > 2) {
                        $resStr[$val] = substr($str[$col], 2, strlen($resStr[$val]) - 4);
                    } else {
                        $resStr[$val] = substr($str[$col], 2);
                    }
                }
                $resStr[$val] = str_replace("…", "...", $resStr[$val]);
            }
            $strIndex = array();
            foreach ($index as $col => $val) {
                $strIndex[] = $resStr[$val];
            }
            $res[implode("_", $strIndex)] = $resStr;




        }
        fclose($file);
        return $res;

    }
    ///L2FileEdit END
    ///
    ///L2ClientDat START
    /**
        Описание:  класс для загрузки клиентских файлов Lineage 2, раскодированных при помощи L2ClientDat
        Автор: Gaikotsu
        Изменил: Demort
    */
    public function L2ClientDat($fName, $type, $idx1 = -1, $idx2 = -1, $idx3 = -1, $field = false){

        $arr = array();
        $i = 0;
        $fHandler = fopen($fName, 'r');
        $str = fgets($fHandler, 8000);

        if ($type == 2)
        {

            $temp = array_slice(explode("\t", trim($str)), 1, -1);
            $keys = array();

            foreach ($temp as $t)
                $keys[] = $this->getKey($t);
        }

        do
        {
            if ($str === false)
                return $arr;

            if (trim($str) != "")
            {
                $temp = explode("\t", trim($str));
                $id1 = ($idx1 > 0 AND isset($temp[$idx1])) ? $this->getValue($temp[$idx1]) : null;
                $id2 = ($idx2 > 0 AND isset($temp[$idx2])) ? $this->getValue($temp[$idx2]) : null;
                $id3 = ($idx3 > 0 AND isset($temp[$idx3])) ? $this->getValue($temp[$idx3]) : null;

                if ($type != 0)
                    $temp = array_slice($temp, 1, -1);

                if ($type == 2)
                {
                    $temp2 = array();

                    for ($j = 0; $j < count($temp); $j++){
                        if (is_array($field)){
                            if (in_array($keys[$j], $field))
                                $temp2[$keys[$j]] = $this->getValue($temp[$j]);
                        }else{
                            $temp2[$keys[$j]] = $this->getValue($temp[$j]);
                        }


                    }


                    $temp = $temp2;
                }

                if ($idx1 == -1)
                {
                    $arr[$i] = $temp;
                    $i++;
                }
                else
                {
                    if ($idx2 > -1)
                    {
                        if ($idx3 > -1)
                            $arr["{$id1}_{$id2}_{$id3}"] = $temp;
                        else
                            $arr["{$id1}_{$id2}"] = $temp;
                    }
                    else
                        $arr["{$id1}"] = $temp;
                }
            }

            $str = fgets($fHandler, 8000);
        }
        while (true);

        return $arr;

    }

    public function trim($str, $count = 1)
    {
        return strlen($str) > $count * 2 ? trim(substr($str, $count, - $count)) : "";
    }

    public function getKey($str)
    {
        return strpos($str, "=") != 0 ? trim(substr($str, 0, strpos($str, "="))) : "";
    }

    public function getValue($str)
    {
        return strpos($str, "=") != 0 ? trim(substr($str, strpos($str, "=") + 1, strlen($str))) : "";
    }
    ///L2ClientDat END

    /// Pars PTS files
    public function getServerFile($itemdata_dir){

        if(!file_exists( $itemdata_dir))
            exit('not fount file ' . $itemdata_dir);

        $items = array();


        $file=fopen($itemdata_dir,"r");
        while(!feof($file)){
            $str=fgets($file,8000);
            if(strlen($str)<3)continue;
            if($str[0]=='/')continue;

            if(preg_match('/item_begin\s*(\w*)\s*(\d*)\s*\[(.*?)\]\s*/x',$str,$item)){
                $gtype     = $item[1];
                $item_id   = $item[2];

                $items[$item_id] = array(
                    'gtype'         => $gtype,
                    'grade'         => NULL,
                    'stackable'     => NULL,
                );


                switch($this->regElem($str,"crystal_type")){
                    case"crystal_free":    $items[$item_id]['grade'] = 'cry_free'; break;

                    default:
                        $items[$item_id]['grade']     = $this->regElem($str,"crystal_type");
                }

                switch($this->regElem($str,"consume_type")){
                    case"consume_type_normal":    $items[$item_id]['stackable'] = 0; break;
                    case"consume_type_stackable": $items[$item_id]['stackable'] = 1; break;
                    case"consume_type_asset":     $items[$item_id]['stackable'] = 1; break;
                }

                switch($items[$item_id]['gtype']){

                    case"weapon":case"shadow_weapon":

                    if ($items[$item_id]['gtype'] == 'weapon')
                        $items[$item_id]['gtype']    = 'weapon';
                    else
                        $items[$item_id]['gtype']    = "shadow_weapon";

                    switch($this->regElem3($str,"slot_bit_type")){
                        case"lhand":
                            $items[$item_id]['gtype']    = 'shield';
                            break;
                    }
                    break;
                    case"accessary":
                        $items[$item_id]['gtype']    = "accessary";
                        break;
                    case"armor":
                        $items[$item_id]['gtype']    = "armor";
                        switch($this->regElem3($str,"slot_bit_type")){
                            case"lhand":
                                $items[$item_id]['gtype']    = 'shield';
                                break;
                        }
                        break;
                    case"etcitem":
                        $items[$item_id]['gtype']    = "etcitem";
                        break;
                    case"questitem":
                        $items[$item_id]['gtype']    = "questitem";
                        break;
                    default:
                        $items[$item_id]['gtype']    = 'none';
                }
            }
        }
        fclose($file);
        return $items;

    }

    public function regElem($str,$name,$default=NULL){
        if(preg_match("/\s".$name."\s*=\s*([^\s]*?)\s/",$str,$array)){
            return $array[1];
        } else {
            return $default;
        }
    }

    public function regElem3($str,$name,$default=NULL){
        if(preg_match("/\t".$name."\s*=\s*\{(.*?)\}\t/",$str,$array)){
            return $array[1];
        } else {
            return $default;
        }
    }
    /// Pars PTS files END
}