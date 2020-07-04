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

                $temp = $this->L2FileEdit($dir, 'id');

                foreach ($temp as $item_id=>$item) {

                    if ($file_name == 'itemname-e.txt'){

                        $items[$item_id]['name'] = $item['name'];
                        $items[$item_id]['add_name'] = $item['add_name'];
                        $items[$item_id]['description'] = str_replace(array('u,', '\\0'), "", $item['description']);
                        $items[$item_id]['icon'] = '';

                    }else{
                        if(!isset($items[$item_id]))continue;

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

            return $items;

        }elseif ($this->type == 'L2ClientDat'){

            foreach ($this->files_list as $file_name => $dir) {

                if ($file_name == 'itemname-e.txt') {
                    $temp = $this->L2ClientDat($dir, 2, 1, -1, -1, array('name', 'additionalname', 'description'));
                }else
                    $temp = $this->L2ClientDat($dir, 2, 1, -1, -1, array('icon'));

                foreach ($temp as $item_id=>$item) {

                    if ($file_name == 'itemname-e.txt'){

                        $items[$item_id]['name'] = $this->trim($item['name']);
                        $items[$item_id]['add_name'] = $this->trim($item['additionalname']);
                        $items[$item_id]['description'] = $this->trim($item['description']);
                        $items[$item_id]['icon'] = '';
                    }else{
                        if(!isset($items[$item_id]))continue;
                        if (!isset($item["icon"]))continue;
                        $temp_ = explode("]", $this->trim($item["icon"], 2));
                        $temp_ = explode(".", $temp_[0]);
                        $items[$item_id]['icon'] = strtolower($temp_[count($temp_) - 1]);
                        unset($temp_);
                    }

                }
                unset($temp);

            }
            return $items;


        }else
            return false;




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
    /*
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

}