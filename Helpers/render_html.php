<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 17.10.2018
 * Time: 13:13
 */

if (!function_exists('render_menu')) {

    function render_menu()
    {
        global $TEMP;
        $active = array();


        if (get_instance()->session->isLogin) {
            $file = 'auth.menu';
            $rules = get_instance()->config['project']['server_menu'][get_instance()->get_sid()];
            $rules['panel'] = true;
        } else {
            $file = 'menu';
            $rules = isset(get_instance()->config['cabinet']['page_active_no_auth']) ? get_instance()->config['cabinet']['page_active_no_auth'] : array();
        }

        if (!isset($TEMP['menu']) AND file_exists(ROOT_DIR . "/Language/" . $file . ".php"))
            $TEMP['menu'] = include_once ROOT_DIR . "/Language/" . $file . ".php";


        $url_array = get_instance()->url->segment_array();


        array_sort_by_column($TEMP['menu'], 'level');
        #TODO пофиксить багу с невыбраными активами в меню
        foreach ($TEMP['menu'] as $key_0 => $buttons_0) {

            if ($key_0 == 'panel') {

                if (isset($url_array[0]) AND $key_0 == $url_array[0]) {
                    $active[$key_0] = 1;
                }

                if (isset($buttons_0['ul']) AND isset($url_array[1])) {
                    foreach ($buttons_0['ul'] as $key_1 => $buttons_1) {

                        if ($key_1 == $url_array[1]) {

                            unset($active);
                            $active[$key_0][$key_1] = 1;

                            if (isset($buttons_1['ul']) AND isset($url_array[2])) {
                                foreach ($buttons_1['ul'] as $key_2 => $buttons_2) {
                                    if ($key_2 == $url_array[2]) {
                                        unset($active);
                                        $active[$key_0][$key_1][$key_2] = 1;
                                    }
                                }
                            }
                        }

                    }
                }

            } else {

                if (isset($url_array[1]) AND $key_0 == $url_array[1]) {
                    unset($active);
                    $active[$key_0] = 1;
                }

                if (isset($buttons_0['ul']) AND isset($url_array[2])) {
                    foreach ($buttons_0['ul'] as $key_1 => $buttons_1) {

                        if ($key_1 == $url_array[2]) {

                            unset($active);
                            $active[$key_0][$key_1] = 1;

                            if (isset($buttons_1['ul']) AND isset($url_array[3])) {


                                foreach ($buttons_1['ul'] as $key_2 => $buttons_2) {
                                    if ($key_2 == $url_array[3]) {
                                        unset($active);
                                        $active[$key_0][$key_1][$key_2] = 1;
                                    }

                                }
                            } else if (isset($buttons_1['ul'])) {
                                foreach ($buttons_1['ul'] as $key_2 => $buttons_2) {
                                    if ($key_2 == $url_array[2]) {
                                        unset($active);
                                        $active[$key_0][$key_1][$key_2] = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        $str = '';
        foreach ($TEMP['menu'] as $key => $buttons) {

            if (!isset($rules[$key]) AND !isset($buttons["custom_btn"]))
                continue;

            if (!isset($buttons["ul"]) AND !isset($buttons['empty_hide']) OR $buttons['empty_hide'])
                continue;

            if(isset($buttons["init"]) AND is_callable($buttons["init"]))
                $buttons["init"]($buttons);

            //Проверка на активность для модулей
            if(is_bool($buttons["enable"])){
                if ($buttons["enable"] == false) continue;
            }elseif (is_callable($buttons["enable"])) {
                if ($buttons["enable"]() == false) continue;
            }


            if (isset($buttons["title_name"])) {

                $str .= '<li class="nav-main-heading">
                            <span class="sidebar-mini-visible">' . get_lang($buttons["title_name_min"]) . '</span>
                            <span class="sidebar-mini-hidden">' . get_lang($buttons["title_name"]) . '</span>
                         </li>';
                continue;
            }


            $str .= '<li class="' . (isset($active[$key]) ? 'open' : '') . '">';


            if (isset($buttons['ul']))
                $str .= '<a data-toggle="nav-submenu" href="#" lv_menu="' . $buttons["level"] . '" class="nav-submenu ' . (isset($active[$key]) ? 'active' : '') . '"><i class="' . $buttons["icon"] . '"></i><span class="sidebar-mini-hide">' . get_lang($buttons["name"]) . (is_callable($buttons["function"]) ? $buttons["function"]($buttons) : '') . '</span></a>';
            else
                $str .= '<a href="' . set_url($buttons["href"]) . '" target="' . $buttons['target'] . '" lv_menu="' . $buttons["level"] . '" class="' . (isset($active[$key]) ? 'active' : '') . ' ' . (isset($buttons["class"]) ? $buttons["class"] : '') . '" '.(isset($buttons["btn_ajax"]) ? $buttons["btn_ajax"] : '').'><i class="' . $buttons["icon"] . '"></i><span class="sidebar-mini-hide">' . get_lang($buttons["name"]) . (is_callable($buttons["function"]) ? $buttons["function"]($buttons) : '') . '</span></a>';

            if (isset($buttons['ul'])) {
                $str .= '<ul>';
                foreach ($buttons['ul'] as $key2 => $buttons) {
                    $str .= '<li class="' . (isset($active[$key][$key2]) ? 'open' : '') . '">';
                    if (isset($buttons['ul']))
                        $str .= '<a data-toggle="nav-submenu" href="#" lv_menu="' . $buttons["level"] . '" class="nav-submenu ' . (isset($active[$key][$key2]) ? 'active' : '') . '">' . get_lang($buttons["name"]) . (is_callable($buttons["function"]()) ? $buttons["function"]() : '') . '</a>';
                    else
                        $str .= '<a href="' . set_url($buttons["href"]) . '" target="' . $buttons['target'] . '" lv_menu="' . $buttons["level"] . '" class="' . (isset($active[$key][$key2]) ? 'active' : '') . ' ' . (isset($buttons["class"]) ? $buttons["class"] : '') . '" '.(isset($buttons["btn_ajax"]) ? $buttons["btn_ajax"] : '').'>' . get_lang($buttons["name"]) . (is_callable($buttons["function"]) ? $buttons["function"]($buttons) : '') . '</a>';

                    if (isset($buttons['ul'])) {
                        $str .= '<ul>';
                        foreach ($buttons['ul'] as $key3 => $buttons) {
                            $str .= '<li class="' . (isset($active[$key][$key2][$key3]) ? 'open' : '') . '">';
                            $str .= '<a href="' . set_url($buttons["href"]) . '" target="' . $buttons['target'] . '" lv_menu="' . $buttons["level"] . '" class="' . (isset($active[$key][$key2][$key3]) ? 'active' : '') . ' ' . (isset($buttons["class"]) ? $buttons["class"] : '') . '" '.(isset($buttons["btn_ajax"]) ? $buttons["btn_ajax"] : '').'>' . get_lang($buttons["name"]) . (is_callable($buttons["function"]) ? $buttons["function"]($buttons) : '') . '</a>';
                            $str .= '</li>';
                        }
                        $str .= '</ul>';
                    }
                    $str .= '</li>';
                }
                $str .= '</ul>';
            }
            $str .= '</li>';
        }


        return $str;


    }
}

if (!function_exists('array_sort_by_column')) {


    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
    {

        $sort_col = array();


        if (is_array($arr)) {

            foreach ($arr as $key => $row) {

                if (!isset($row[$col])) {
                    var_dump($row, $col);
                }


                $sort_col[$key] = $row[$col];
                if (is_array($row)) {

                    foreach ($row as $rowKey => $rowVal) {

                        $arSort = array();
                        if (is_array($rowVal)) {
                            foreach ($rowVal as $keyRow => $secondVal) {

                                if (is_array($secondVal)) {

                                    if (!isset($arr[$key][$rowKey][$keyRow][$col]))
                                        continue;

                                    $arSort[] = $arr[$key][$rowKey][$keyRow][$col];

                                    foreach ($secondVal as $thirdKey => $thirdAr) {
                                        if (is_array($thirdAr)) {
                                            $arSortThird = array();

                                            foreach ($thirdAr as $thirdKeyRow => $thirdVal) {

                                                if (!isset($arr[$key][$rowKey][$keyRow][$thirdKey][$thirdKeyRow][$col]))
                                                    continue;

                                                $arSortThird[] = $arr[$key][$rowKey][$keyRow][$thirdKey][$thirdKeyRow][$col];
                                            }


                                            if (is_array($arSortThird) && count($arSortThird) > 0)
                                                array_multisort($arSortThird, $dir, $arr[$key][$rowKey][$keyRow][$thirdKey]);
                                        }

                                    }

                                }

                            }
                            if (is_array($arSort) && count($arSort) > 0)
                                array_multisort($arSort, $dir, $arr[$key][$rowKey]);

                        }

                    }

                }

            }

        }

        if (is_array($sort_col) && count($sort_col) > 0)
            array_multisort($sort_col, $dir, $arr);

    }

}

if (!function_exists('array_key_first')) {
    /**
     * Gets the first key of an array
     *
     * @param array $array
     * @return mixed
     */
    function array_key_first(array $array)
    {
        if (count($array)) {
            reset($array);
            return key($array);
        }

        return null;
    }
}

if (!function_exists('set_url')) {

    function set_url($str, $add_url_site = true, $lang_det = true)
    {

        if (empty($str))
            return '#';

        if (strpos($str, 'javascript:void') !== false)
            return 'javascript:void(0);';
        elseif ($str == '#')
            return '#';

        $url = parse_url($str);

        if (count($url) < 1)
            return '#';


        $config_project = get_instance()->config;

        if (!isset($url['host']) AND $add_url_site){
            $url_cfg = parse_url($config_project['project']['url_site']);
            $url['scheme'] = $url_cfg['scheme'];
            $url['host'] = $url_cfg['host'];

        }else
            $lang_det = false;

        if (isset($url['host'])){
            if (!isset($url_cfg))
                $url_cfg = parse_url($config_project['project']['url_site']);

            if ($url['host'] != $url_cfg['host'])
                $lang_det = false;
        }

        if (isset($url['path'])){
            if (substr($url['path'], 0, 1) != '/')
                $url['path'] = '/'.$url['path'];
        }


        if (DETECT_LANG AND $lang_det) {
            $url_lang = select_lang();

            if (isset($url['path'])){
                $url['path'] = '/'.$url_lang.$url['path'];
            }else{
                $url['path'] = '/'.$url_lang;
            }
        }

        return reverse_parse_url($url);

    }
}

if (!function_exists('set_item')) {

    function set_item($item_id, $sid = false, $return_array = true, $pattern = '<div data-item="%id%"><img src="%icon%" data-src="%src%" width="15px">%name% %add_name%</div>')
    {
        global $TEMP;
        if ($sid === false)
            $sid = get_instance()->get_sid();

        if (isset($TEMP[$sid][$item_id])){
            $item = $TEMP[$sid][$item_id];
        }else{
            try {
                $db = get_instance()->db();
            }catch (\Exception $e){
                echo error_404_html(500, 'Error connecting to database', DEBUG ? $e->getMessage() : '', '/', true);
                exit;
            }

            $result = $db->prepare('SELECT `id`, `item_id`, `name`, `add_name`, `description`, `icon`, `icon_panel`, \'\' AS src, \'\' AS src_panel, `grade`, `type`, `stackable`,`sid` FROM mw_item_db WHERE `item_id` = :item_id AND `sid`=:sid ');
            $result->execute(array(':item_id' => $item_id, ':sid' => $sid));
            $item = $TEMP[$sid][$item_id] = $result->fetch(PDO::FETCH_ASSOC);
            unset($result);
        }
        if ($item === false){
            $item = array(
                'id' => 0,
                'item_id' => $item_id,
                'name' => 'No name',
                'add_name' => '',
                'description' => '',
                'icon' => '',
                'icon_panel' => '',
                'src' => '',
                'src_panel' => '',
                'grade' => '',
                'stackable' => 0,
                'type' => '',
                'sid' => $sid,
            );
        }

        //поиск картинки предмета
        $item['src'] = $item['icon'];
        $item['src_panel'] = $item['icon_panel'];
        $item['icon'] = check_icon_item($item['icon'], $sid);
        if (!empty($item['icon_panel'])) {
            $item['icon_panel'] = str_replace("icon.", "", $item['icon_panel']);
            $item['icon_panel'] = check_icon_item($item['icon_panel'], $sid);
        }
        if ($return_array) {
            $item['id'] = isset($item['id']) ? $item['id'] : 0;
            $item['item_id'] = $item_id;
            $item['name'] = isset($item['name']) ? $item['name'] : 'No name';
            $item['add_name'] = isset($item['add_name']) ? $item['add_name'] : '';
            $item['description'] = isset($item['description']) ? $item['description'] : '';
            $item['icon_panel'] = isset($item['icon_panel']) ? $item['icon_panel'] : '';
            $item['grade'] = isset($item['grade']) ? $item['grade'] : '';
            $item['type'] = isset($item['type']) ? $item['type'] : '';
            $item['stackable'] = isset($item['stackable']) ? $item['stackable'] : 0;

            return $item;
        }else{
            unset($item['popup']);
            return str_replace(array('%id%', '%item_id%', '%name%', '%add_name%', '%description%', '%icon%', '%icon_panel%', '%src%', '%src_panel%', '%grade%', '%stackable%', '%type%', '%sid%' ) , array_values($item), $pattern);
        }

    }
}

if (!function_exists('check_icon_item')) {

    function check_icon_item($icon, $sid){

        if (!empty($icon)){
            if (file_exists(ROOT_DIR.'/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.png'))
                $icon = '/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.png';
            elseif (file_exists(ROOT_DIR.'/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.jpg'))
                $icon = '/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.jpg';
            elseif (file_exists(ROOT_DIR.'/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.gif'))
                $icon = '/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.gif';
            elseif (file_exists(ROOT_DIR.'/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.jpeg'))
                $icon = '/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.jpeg';
            elseif(DEBUG)
                $icon = '/template/panel/assets/media/icon/'.$sid.'/'.$icon.'.png';
            else
                $icon = '/template/panel/assets/media/icon/no_icon.png';
        }elseif(DEBUG)
            $icon = 'Item not icon in DB!';
        else
            $icon = '/template/panel/assets/media/icon/no_icon.png';

        return $icon;
    }

}

if (!function_exists('get_icon_item')) {

    function get_icon_item($icon,$icon_panel, $sid, $dir = true){

        if (!empty($icon_panel)) {
            if ($dir)
                $icon_panel = str_replace("icon.", "", $icon_panel);
            $bg = 'style="background: url('.($dir ? check_icon_item($icon, $sid) : $icon).') no-repeat; background-size: 100%;"';
            $icon = $dir ? check_icon_item($icon_panel, $sid) : $icon_panel;
        }else{
            $bg = '';
            $icon = $dir ? check_icon_item($icon, $sid) : $icon;
        }

        return 'src="'.$icon.'" '.$bg;
    }

}



if (!function_exists('render_menu_server')) {

    function render_menu_server()
    {

        $str = '';
        $game_select = get_platform();
        $server_select = false;
        $select_sid = get_sid();
        $url_array = get_instance()->url->segment_array();

        //visualization.cabinet_layout_login


        //Рендер меню выпадающей менюшкой
        //Страници где не выводим
        if (get_instance()->session->isLogin) {

            $server_info = get_instance()->config['project']['server_info'];


            foreach ($server_info[$game_select] as $server_id => $srv) {
                if ($server_id == $select_sid) {
                    $server_select = $srv['name'] . (empty($srv["rate"]) ? '' : ' [x'.$srv["rate"].']');
                    break;
                }

            }

            $str .= '<button type="button" class="btn btn-block btn-alt-success btn-rounded dropdown-toggle push d-flex align-items-center justify-content-between min-width-175" id="toolbarDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="' . ucfirst($game_select) . '">';
            $str .= '<img class="img-avatar img-avatar16 img-avatar-thumb m-0" src="/template/panel/assets/media/icon_platform/' . $game_select . '.png" alt="' . $game_select . '">';
            $str .= $server_select;
            $str .= '</button>';

            $show_opt = (count($server_info) > 1);


            $str .= '<div class="dropdown-menu" aria-labelledby="toolbarDrop">';
            foreach ($server_info as $game => $server_list) {
                if ($show_opt)
                    $str .= '<h6 class="dropdown-header min-width-175">' . '<img class="img-avatar img-avatar20 img-avatar-thumb" src="/template/panel/assets/media/icon_platform/' . $game . '.png" alt="' . ucfirst($game) . '">' . ucfirst($game) . '</h6>';
                $str .= '<div class="ml-10 ">';
                foreach ($server_list as $id => $server) {
                    if ($server['status']) {
                        $str .= '<a class="dropdown-item '
                            . (ucfirst($server_select) == ucfirst($server['name']) ? 'active' : " submit-btn")
                            . '" data-post="'
                            . http_build_query(['module_form' => "Modules\Globals\Settings\Settings",'module' => "server_change",'set_sid' => $id])
                            . '" href="javascript:void(0);">'
                            . $server['name'] . (empty($server["rate"]) ? '' : ' [x'.$server["rate"].']')
                            . '</a>';
                    }
                }
                $str .= '</div>';
            }
            $str .= ' </div>';


            return $str;


        } else {
            //выбор сервера для не авторизованого пользователя

            $page_no_ignore = array('rating', 'shop', 'donations');

            //Проверка на запрет вывода на определенных страницах в зависимости от авторизации
            if (!in_array($url_array[1], $page_no_ignore))
                return $str;

            $page_select = $url_array[1];

            $server_info = get_instance()->config['project']['server_info'];


            //Проверка если что то выбрано
            if (isset($url_array[2])) {
                foreach ($server_info as $game => $server_list) {

                    foreach ($server_list as $sid => $srv) {
                        if (prepareStringForUrl($srv['name']).'.'.$sid == $url_array[2] AND $sid == $select_sid){
                            $server_select = $srv['name'] . (empty($srv["rate"]) ? '' : ' [x'.$srv["rate"].']');
                            $game_select = $game;
                            break;
                        }elseif (prepareStringForUrl($srv['name']).'.'.$sid == $url_array[2]){
                            $server_select = false;
                            $select_sid = $sid;
                            $game_select = $game;
                            break;
                        }
                    }
                }



            }

            //проверка на первый запуск
            if ($server_select == false) {
                $server_select = $server_info[$game_select][$select_sid]["name"];

                get_instance()->set_sid($select_sid);
                if (true){
                    header('Location: '. set_url($page_select . '/' . prepareStringForUrl($server_select).'.'.$select_sid), TRUE, 301);
                    die;
                }else{
                    $str .= '<script type="text/javascript">document.location.href="' . set_url($page_select . '/' . prepareStringForUrl($server_select).'.'.$select_sid) . '";</script>';
                }

            }
            $show_opt = (count($server_info) > 1);
            $str .= '<button type="button" class="btn btn-block btn-alt-success btn-rounded dropdown-toggle push d-flex align-items-center justify-content-between min-width-175" id="toolbarDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="' . ucfirst($game_select) . '">';
            $str .= '<img class="img-avatar img-avatar16 img-avatar-thumb m-0" src="/template/panel/assets/media/icon_platform/' . $game_select . '.png" alt="' . $game_select . '">';
            $str .= $server_select;
            $str .= '</button>';

            $str .= '<div class="dropdown-menu" aria-labelledby="toolbarDrop">';
            foreach ($server_info as $game => $server_list) {
                if ($show_opt)
                    $str .= '<h6 class="dropdown-header min-width-175">' . '<img class="img-avatar img-avatar20 img-avatar-thumb" src="/template/panel/assets/media/icon_platform/' . $game . '.png" alt="' . ucfirst($game) . '">' . ucfirst($game) . '</h6>';
                $str .= '<div class="ml-10 ">';
                foreach ($server_list as $sid => $server) {
                    if ($server['status']) {
                        $str .= '<a class="dropdown-item '
                            . (ucfirst($server_select) == ucfirst($server['name']) ? 'active' : "")
                            . '" href="' . set_url($page_select . '/' . prepareStringForUrl( $server['name']).'.'.$sid) . '">'
                            . $server['name'] . (empty($server["rate"]) ? '' : ' [x'.$server["rate"].']')
                            . '</a>';
                    }
                }
                $str .= '</div>';
            }
            $str .= '</div>';

            return $str;

        }
    }
}

if (!function_exists('valid_parse_row')) {

    function valid_parse_row($array){

        if (array_key_exists('row', $array))
            $row_key = 'row';
        elseif (array_key_exists('row justify-content-center', $array))
            $row_key = 'row justify-content-center';
        elseif (array_key_exists('row gutters-tiny', $array))
            $row_key = 'row gutters-tiny';
        elseif (array_key_exists('row no-gutters', $array))
            $row_key = 'row no-gutters';
        elseif (array_key_exists('grid', $array))
            $row_key = 'grid';
        else
            $row_key = false;

        return $row_key;
    }
}

if (!function_exists('parse_row')) {

    function parse_row($pages)
    {
        if (empty($pages))
            return false;

        if (empty($render_tpl))
            $render_tpl = '';


        if (array_key_exists('header', $pages)) {
            $render_tpl .= "<h2 class=\"content-heading\">{$pages['header']}</h2>";
            unset($pages['header']);
        }


        $row_key = valid_parse_row($pages);

        if ($row_key) {

            $render_tpl .= '<div class="'.$row_key.'">';
            //Сортировка по уровням
            array_sort_by_column($pages[$row_key], 'level');

            foreach ($pages[$row_key] as $key => $row) {

                if (empty($render_tpl))
                    $render_tpl = '';

                $render_tpl .= '<div class="' . $row['class'] . ' box_mw" data-layers-level="'.$row['level'].'">';
                unset($row['class']);
                unset($row['level']);


                if (valid_parse_row($row)) {
                    $render_tpl .= parse_row($row);
                } else {
                    foreach ($row as $widget_content) {

                        if (empty($render_tpl))
                            $render_tpl = '';

                        $render_tpl .= $widget_content();
                    }
                }

                $render_tpl .= '</div>';
            }
            $render_tpl .= '</div>';
            $render_tpl .= "<script> document.querySelectorAll('div.box_mw').forEach(div => { if (div.textContent === '') { div.remove(); } }); </script>";

        } elseif (is_array($pages)) {
            foreach ($pages as $page)
                $render_tpl .= parse_row($page);
        }


        if (empty($render_tpl))
            $render_tpl = error_404_html();


        return $render_tpl;

    }
}

if (!function_exists('parse_row_hero')) {

    function parse_row_hero($pages)
    {
        if (empty($pages))
            return '';
        $render_tpl = '';

        $row_key = array_key_first($pages);
        if (is_numeric($row_key)) {
            array_sort_by_column($pages, 'level');
            foreach ($pages as $key => $row) {
                unset($row['level']);
                foreach ($row as $widget_content) {
                    $render_tpl .= trim($widget_content());
                }
            }

        } elseif (is_array($pages)) {
            foreach ($pages as $page)
                $render_tpl .= parse_row_hero($page);
        }

        return $render_tpl;

    }
}

if (!function_exists('error_404_html')) {

    function error_404_html($code = 404, $title = 'Oops.. You just found an error page..', $desc = 'We are sorry but the page you are looking for was not found..', $link = './', $full = false)
    {

        $return = '<div class="hero-inner">
                    <div class="content content-full">
                        <div class="py-30 text-center">
                            <div class="display-3 text-danger">
                                <i class="fa fa-warning"></i> ' . $code . '
                            </div>
                            <h1 class="h2 font-w700 mt-30 mb-10">' . $title . '</h1>
                            <h2 class="h3 font-w400 text-muted mb-50">' . $desc . '</h2>
                            <a class="btn btn-hero btn-rounded btn-alt-secondary" href="' . $link . '">
                                <i class="fa fa-arrow-left mr-10"></i> Back
                            </a>
                        </div>
                    </div>
                </div>';

        if ($full){

            if (file_exists(ROOT_DIR . VIEWPATH . '/panel/error.tpl')){
                $file = file_get_contents(ROOT_DIR . VIEWPATH . '/panel/error.tpl', true);
                $return = str_replace(
                    array('{$title}', '{$content}', '{$.site.dir_panel}'),
                    array( $title, $return, VIEWPATH . '/panel'),
                    $file);
            }
        }

        return $return;

    }

}

if (!function_exists('get_tpl_file')) {

    /**
     * @param $name
     * @param bool|string $name_module
     * @param string $sub_dir
     * @return bool|string
     */
    function get_tpl_file($name, $name_module = false, $sub_dir = 'panel')
    {
        $dir = '';
        if ($name_module !== false) {
            $dir = explode('\\', $name_module);
            if (count($dir) > 3) {
                array_pop($dir);
            }
            $dir = implode('/', $dir) . '/';
        }
        //поиск вариант в шаблоне сайта
        if (file_exists(ROOT_DIR . TEMPLATE_DIR . '/' . $sub_dir . '/' . $dir . '' . $name)) {

            return 'site:' . $sub_dir . '/' . $dir . '' . $name;

        }//поиск кастомного варианта
        elseif (file_exists(ROOT_DIR . VIEWPATH . '/' . $sub_dir . '/' . $dir . 'custom/' . $name)) {

            return $sub_dir . ':' . $dir . '/custom/' . $name;

        }//Поиск
        elseif (file_exists(ROOT_DIR . VIEWPATH . '/' . $sub_dir . '/' . $dir . '' . $name)) {

            return $sub_dir . ':' . $dir . '/' . $name;

        } else {
            echo 'Шаблон ' . $name . ' Не найден!<br> В деректории :'
                . ROOT_DIR . VIEWPATH . '/' . $sub_dir . '/' . $dir . 'custom/' . $name . '<br>и<br>'
                . ROOT_DIR . VIEWPATH . '/' . $sub_dir . '/' . $dir . '' . $name;
            return false;
        }


    }


}

if (!function_exists('render_menu_user_dropdown')) {

    function render_menu_user_dropdown()
    {
        global $TEMP;

        if (!isset($TEMP['menu_user_dropdown']) AND file_exists(ROOT_DIR . "/Language/auth.menu.user.dropdown.php"))
            $TEMP['menu_user_dropdown'] = include_once ROOT_DIR . "/Language/auth.menu.user.dropdown.php";

        array_sort_by_column($TEMP['menu_user_dropdown'], 'level');
        $str = render_menu_bonus_cod('link');
        foreach ($TEMP['menu_user_dropdown'] as $key => $buttons) {

            if (isset($buttons['hr'])) {
                $str .= '<div class="dropdown-divider"></div>';
                continue;
            }

            $str .= '<a href="' . set_url($buttons["href"]) . '" target="' . $buttons['target'] . '" class="dropdown-item ' . (isset($buttons["class"]) ? $buttons["class"] : '') . '" '.(isset($buttons["btn_ajax"]) ? $buttons["btn_ajax"] : '').'>
                <i class="' . $buttons["icon"] . ' mr-5"></i>'
                . get_lang($buttons["name"]) . (is_callable($buttons["function"]) ? $buttons["function"]($buttons) : '')
                .'</a>';

        }

        return $str;

    }


}

if (!function_exists('render_widget_ma_manager')) {

    function render_widget_ma_manager()
    {

        if (isset(get_instance()->config['cabinet']['manager_ma']) AND get_instance()->config['cabinet']['manager_ma'] AND get_instance()->check_plugin('manager_account')) {

            $str = '<h6 class="h6 text-center py-10 mb-5 border-b">' . get_lang('widget_manager.lang')['lang_title_dropdown'] . '</h6>';
            $manager_list = isset(get_instance()->session->getSession()["user_data"]["manager"]) ? get_instance()->session->getSession()["user_data"]["manager"] : array();

            if (is_array($manager_list) AND count($manager_list)) {
                foreach ($manager_list as $m_a) {
                    if ($m_a['mn_status'] == 1) {
                        $str .= '<button type="button" class="dropdown-item submit-btn" ' . btn_ajax("Modules\Globals\Settings\Settings", "manager_change", ['mid' => $m_a['mid']]) . '>
                        <i class="si si-action-redo mr-5"></i>'
                            . (empty($m_a['email']) ? $m_a['phone'] : $m_a['email'])
                            . '</button>';
                    } else {
                        $str .= '<a href="' . set_url('panel/settings#manager') . '" class="dropdown-item" title="' . get_lang('widget_manager.lang')['lang_account_not_approve'] . '">
                        <i class="fa fa-exclamation-triangle mr-5 text-warning"></i>'
                            . (empty($m_a['email']) ? $m_a['phone'] : $m_a['email'])
                            . '</a>';
                    }
                }
            }
            $str .= '<a href="' . set_url('panel/settings#manager') . '" class="dropdown-item"><i class="fa fa-plus"></i> ' . get_lang('widget_manager.lang')['lang_btn_add'] . '</a>';
            return $str;

        }else
            return false;
    }


}

if (!function_exists('get_crest')) {

    function get_crest($id, $sid, $class = '', $pattern = '<img class="%class%" src="%src%">')
    {
        if (!empty($id) AND !empty($sid) AND file_exists(ROOT_DIR.CACHEPATH.'/crest/'.$sid.'/'.$id.'.png')){

            $crest = array(
                'class' => $class,
                'src' => CACHEPATH.'/crest/'.$sid.'/'.$id.'.png',
            );

            return str_replace(array('%class%', '%src%') , array_values($crest), $pattern);
        }else
            return '';
    }


}

if (!function_exists('prepareStringForUrl')) {

    function prepareStringForUrl($string, $romanize = true)
    {
        global $TEMP;

        $string = strval($string);
        $cacheKey = $string . ($romanize ? '|r' : '');

        if (isset($TEMP['stringCache'][$cacheKey])) {
            return $TEMP['stringCache'][$cacheKey];
        }

        if ($romanize) {
            $string = utf8_romanize(utf8_deaccent($string));

            $originalString = $string;

            // Attempt to transliterate remaining UTF-8 characters to their ASCII equivalents
            $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            if (!$string) {
                // iconv failed so forget about it
                $string = $originalString;
            }
        }

        $string = strtr(
            $string,
            '`!"$%^&*()-+={}[]<>;:@#~,./?|' . "\r\n\t\\",
            '                             ' . '    '
        );
        $string = strtr($string, ['"' => '', "'" => '']);

        if ($romanize) {
            $string = preg_replace('/[^a-zA-Z0-9_ -]/', '', $string);
        }

        $string = preg_replace('/[ ]+/', '-', trim($string));
        $string = strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
        $string = urlencode($string);

        $TEMP['stringCache'][$cacheKey] = $string;

        return $string;
    }

}

if (!function_exists('render_menu_bonus_cod')) {

    function render_menu_bonus_cod($type = 'button')
    {
        if (get_instance()->check_plugin('bonus_cod') AND get_instance()->status_plugin('bonus_cod')) {
            if (get_instance()->config['visualization']['cabinet_layout_login'] == 'top') {
                $str = '<button type="button" class="dropdown-item submit-btn" ' . btn_ajax("Modules\Plugins\BonusCod\BonusCod", "ajax_open_form") . '>
                <i class="fa fa-gift mr-5"></i>'
                    . get_lang('bonus_cod.lang')['btn_menu_bonus_cod']
                    . '</button>';
            } else {
                if ($type == 'button') {
                    $str = '<button type="button" class="btn btn-rounded btn-dual-secondary submit-btn" ' . btn_ajax("Modules\Plugins\BonusCod\BonusCod", "ajax_open_form") . '>
                <i class="fa fa-gift mr-5"></i>'
                        . get_lang('bonus_cod.lang')['btn_menu_bonus_cod']
                        . '</button>';
                }else{
                    $str = '<button type="button" class="dropdown-item submit-btn" ' . btn_ajax("Modules\Plugins\BonusCod\BonusCod", "ajax_open_form") . '>
                <i class="fa fa-gift mr-5"></i>'
                        . get_lang('bonus_cod.lang')['btn_menu_bonus_cod']
                        . '</button>';
                }
            }
        }else
            $str = '';

        return $str;

    }


}

if (!function_exists('render_formbuilder')){

    function render_formbuilder(array $form, $value = false){

        $lable = substr(md5(mt_rand()), 0, 7);

        if ($form['type'] != 'hidden') {
            $str = '<div class="form-group row">
                    <label class="col-lg-4 col-form-label" for="val-' . $lable . '">' . $form['label'] . '</label>
                        <div class="col-lg-8">';
        }

        //($value !== false ? $value : (isset($form['value']) ? $form['value'] : ''));


        if($value === false)
        {
            if (isset($form['value']))
                $value = $form['value'];
            else
                $value = '';
        }

        switch ($form['type']){

            case "hidden":
                $str .= '<input type="' .$form['type']. '" name="'.$form['name'].'" value="'.$value.'">';
                break;

            case "text":
            case "number":
            case "date":

                if($form['type'] == 'date')
                    $form['type'] = 'datetime-local';

                $str .= '<input type="' .$form['type']. '" class="form-control" 
                    id="val-' .$lable. '" 
                    name="'.$form['name'].'" 
                    value="'.$value.'"'
                    .(isset($form['maxlength']) ? ' maxlength="' .$form['maxlength']. '"' : '').
                    (isset($form['placeholder']) ? ' placeholder="'.$form['placeholder'].'" ' : '').
                    (isset($form['min']) ? ' min="'.$form['min'].'" ' : '').
                    (isset($form['max']) ? ' max="'.$form['max'].'" ' : '').
                    (isset($form['step']) ? ' step="'.$form['step'].'" ' : '')
                    . '">';
                break;


            case "textarea":
                $str .= '<textarea 
                    ' .(isset($form['rows']) ? 'rows="' .$form['rows']. '" ' : 'rows="3" '). '
                    id="val-' .$lable. '" 
                    name="' .$form['name']. '" 
                    class="form-control '.$form['subtype'].'" '
                    .(isset($form['maxlength']) ? ' maxlength="' .$form['maxlength']. '"' : '')
                    .(isset($form['placeholder']) ? ' placeholder="'.$form['placeholder'].'"' : '')
                    . '>'.$value.'</textarea>';
                break;

            case "select":
                $str .= '<select class="form-control" id="val-' .$lable. '" name="' .$form['name']. '" '
                    .(isset($form['placeholder']) ? ' placeholder="'.$form['placeholder'].'"' : '')
                    .($form['multiple'] ? ' multiple' : '')
                    .'>';

                foreach ($form['values'] as $opt){
                    if ($value != '')
                        $opt['selected'] = false;
                    if ($value != '' AND $value == $opt['value'])
                        $opt['selected'] = true;


                    $str .= '<option value="'.$opt['value'].'"   '.($opt['selected']? 'selected' : '').'>'.$opt['label'].'</option>';
                }
                $str .= '</select>';
                break;


            case "checkbox-group":

                foreach ($form['values'] as $chec) {

                    if ($value != '')
                        $chec['selected'] = false;
                    if ($value != '' AND $value == $chec['value'])
                        $chec['selected'] = true;


                    $str .= '<div class="custom-control custom-checkbox ' . ($form['inline'] ? 'custom-control-inline' : '') . ' mb-5">
                            <input class="custom-control-input" type="checkbox" name="' . $form['name'] . '" id="val-' . $lable . '-checkbox" value="'.$chec['value'].'" '.($chec['selected']? 'checked' : '').'>
                            <label class="custom-control-label" for="val-' . $lable . '-checkbox">'.$chec['label'].'</label>
                        </div>';
                    $lable = substr(md5(mt_rand()), 0, 7);
                }

                break;

            case "radio-group":

                foreach ($form['values'] as $chec) {

                    if ($value != '')
                        $chec['selected'] = false;
                    if ($value != '' AND $value == $chec['value'])
                        $chec['selected'] = true;

                    $str .= '<div class="custom-control custom-radio ' . ($form['inline'] ? 'custom-control-inline' : '') . ' mb-5">
                            <input class="custom-control-input" type="radio" name="' . $form['name'] . '" id="val-' . $lable . '-radio" value="'.$chec['value'].'" '.($chec['selected']? 'checked' : '').'>
                            <label class="custom-control-label" for="val-' . $lable . '-radio">'.$chec['label'].'</label>
                        </div>';
                    $lable = substr(md5(mt_rand()), 0, 7);
                }

                break;

        }
        if ($form['type'] != 'hidden') {
            if (isset($form['description']))
                $str .= '<div class="form-text text-muted">' . $form['description'] . '</div>';

            $str .= '</div></div>';
        }
        return $str;
    }

}

if (!function_exists('find_html_pages')){

    function find_html_pages($dir_1, $dir_2){

        if (file_exists(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'.html' )) {

            return file_get_contents(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'.html');

        }else if (file_exists(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/index.html' )) {

            return file_get_contents(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/index.html');

        }else if (file_exists(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/'.$dir_2.'.html' )) {

            return file_get_contents(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/'.$dir_2.'.html');

        }else if (file_exists(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/'.$dir_2.'/index.html' )) {

            return file_exists(ROOT_DIR . '/Catalog_html/'.select_lang().'/'.$dir_1.'/'.$dir_2.'/index.html' );

        }

        return false;

    }


}