<?php
/**
 * Created by PhpStorm.
 * User: mmoweb
 * Date: 12.02.2020
 * Time: 17:41
 */

class SeoX
{
    public $head = array();
    public $body = array();
    public $footer = array();

    public $config = array();
    public $advertising = false;

    public $url = 'init';
    public $url_site = 'init';
    public $seo = array();
    public $lang = 'en';
    public $teg_replace = array(
        '%site_name%' => '',
        '%server_name%' => '',
        '%platform_server_name%' => '',
        '%url%' => '',
    );

    public function __construct($lang, $url)
    {

        $this->lang = $lang;
        $this->seo = get_lang('seo.lang');

        $this->initReplaceTeg();
        $url = $this->url_site = $this->parsUrl($url);

        if (!isset($this->seo[$url])) $this->url = 'init'; else $this->url = $url;
        if (isset($this->seo[$this->url])) {
            foreach ($this->seo[$this->url] as $area => $teg) {
                $this->$area = array_merge($this->$area, $this->replaceTeg($teg));
            }
        }

        //Подгрузка файлов js css
        $this->config = get_lang(ROOT_DIR . '/Library/js_css_include.php');
        if (isset($this->config['init'])) {
            foreach ($this->config['init'] as $area => $teg) {
                $this->$area = array_merge($this->$area, $teg);
            }
        }

        //Загрузка рекламной аналитики
        $this->advertising();
    }

    public function loudSite()
    {
        global $_TEMP;
        $this->head = array();
        $this->body = array();
        $this->footer = array();
        $url = $this->parsUrl($this->url_site);

        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/Headers.php')){

            if(!isset($_TEMP['site_headers']))
                $temp = $_TEMP['site_headers'] = include_once ROOT_DIR.TEMPLATE_DIR.'/Headers.php';
            else
                $temp = $_TEMP['site_headers'];


            $this->seo = get_lang($temp);
            unset($temp);

            if (!isset($this->seo[$url])) $this->url = 'init'; else $this->url = $url;
            if (isset($this->seo[$this->url])) {
                foreach ($this->seo[$this->url] as $area => $teg) {
                    $this->$area = array_merge($this->$area, $this->replaceTeg($teg));
                }
            }
        }

        if (file_exists(ROOT_DIR.TEMPLATE_DIR.'/IncludeJsCss.php')) {
            $this->config = get_lang(ROOT_DIR.TEMPLATE_DIR.'/IncludeJsCss.php');

            //Подгрузка файлов js css
            if (isset($this->config['init'])) {
                foreach ($this->config['init'] as $area => $teg) {
                    $this->$area = array_merge($this->$area, $teg);
                }
            }
        }

        //Загрузка рекламной аналитики
        $this->advertising();
    }

    public function parsUrl($url){
        if (!empty($url)){
            $url_temp = explode('/',$url);
            if (isset($url_temp[1]) AND !empty($url_temp[1]))
                $url = $url_temp[1];
            if (isset($url_temp[2]) AND !empty($url_temp[2])){
                $cfg = get_instance()->config;
                if (isset($cfg['game']) AND !in_array($url_temp[2], $cfg['game']))
                    $url .= '_'.$url_temp[2];
            }

            unset($url_temp);
        }

        return $url;
    }

    public function initReplaceTeg(){

        $this->teg_replace['%site_name%'] = get_instance()->config['project']['name'];
        $this->teg_replace['%server_name%'] = get_sid_name(false);
        $this->teg_replace['%platform_server_name%'] = get_sid_name();
        $this->teg_replace['%url%'] = get_instance()->config['project']['url_site'];
        $this->teg_replace['%this_url%'] = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    }

    public function reload($cfg_name){
        if (isset($this->config[$this->lang][$cfg_name])) {
            foreach ($this->config[$this->lang][$cfg_name] as $area => $teg) {
                $this->$area = $teg;
            }
        }


        return $this;
    }

    public function addSeoTeg($idx, $typex, array $teg){

        $search = false;
        foreach ($this->head as $id => $_teg){
            if ($_teg['idx'] == $idx AND $_teg['typex'] == $typex ) {
                $this->head[$id] = array_merge(array('idx' => $idx, 'typex' => $typex), $this->replaceTeg($teg));
                $search = true;
            }
        }
        if ($search == false){
            array_unshift($this->head, array_merge(array('idx' => $idx, 'typex' => $typex), $this->replaceTeg($teg)));
        }
        return '';
    }

    public function addTegHTML($area, $idx, $typex, array $teg){

        $this->deleteTeg($area, $idx, false, false);


        $this->{$area}[] = array_merge(array( 'idx'=>$idx, 'typex' => $typex), $teg );

        return '';
    }

    public function addTeg($area, $idx, $typex, array $teg){

        $this->{$area}[] = array_merge(array( 'idx'=>$idx, 'typex' => $typex), $teg );

        return $this;
    }

    public function deleteTeg($area, $idx, $key = false, $name = false){

        if (is_bool($key)){
            foreach ($this->$area as $id => $item) {
                if ($item['idx'] == $idx){
                    if ($area == 'head')
                        unset($this->head[$id]);
                    elseif($area == 'body')
                        unset($this->body[$id]);
                    else
                        unset($this->footer[$id]);
                }
            }
        }else{
            foreach ($this->$area as $id => $item) {
                if ($item[$key] == $name){
                    if ($area == 'head')
                        unset($this->head[$id]);
                    elseif($area == 'body')
                        unset($this->body[$id]);
                    else
                        unset($this->footer[$id]);
                }
            }
        }

        return $this;
    }

    /**
    @return string
    */
    public function getHead(){
        $html = '';
        foreach ($this->head as $item) {
            $html .= $this->parsTeg($item);
        }
        return $html;
    }
    /**
    @return string
    */
    public function getBody(){
        $html = '';
        foreach ($this->body as $item) {
            $html .= $this->parsTeg($item);
        }
        return $html;
    }
    /**
    @return string
    */
    public function getFooter(){
        $html = '';
        foreach ($this->footer as $item) {
            $html .= $this->parsTeg($item);
        }
        return $html;
    }
    /**
    @return array
     */
    public function replaceTeg(array $teg){

        foreach ($teg as &$item) {
            $item = str_replace(array_keys($this->teg_replace), array_values($this->teg_replace), $item);
        }

        return $teg;

    }

    private function parsTeg(array $teg){

        switch ($teg['typex']){

            case 'title':

                return '<title>'.$teg['content'].'</title>';

                break;

            case 'meta':

                $temp = '<meta ';
                $temp.= $this->lineConnector($teg);
                $temp.= '>';
                return $temp;
                break;

            case 'link':

                $temp = '<link ';
                $temp.= $this->lineConnector($teg);
                $temp.= '>';

                return $temp;
                break;

            case 'script':

                if (!isset($teg['js'])) {

                    $temp = '<script ';
                    $temp.= $this->lineConnector($teg);
                    $temp.= '></script>';

                }else{
                    $temp = '<script>'.$teg['js'].'</script>';
                }
                return $temp;
                break;

            case 'html':

                $temp = $teg['html'];
                return $temp;
                break;


            default:
                return '';
        }


    }

    public function lineConnector(array $line, $del_teg = array('idx','typex')){
        $str = '';

        foreach ($line as $key => $item) {
            if (!in_array($key,$del_teg))
                $str.= $key.'="'.$item.'" ';
        }


        return $str;
    }

    public function advertising(){

        if ($this->advertising === false)
            $this->advertising = include ROOT_DIR . '/Library/advertising.php';

        //Google Analytics
        if (isset($this->advertising['gawpid']) AND !empty($this->advertising['gawpid'])){
            $this->addTeg('head', 'googleanalytics', 'script', array('src' => 'https://www.googletagmanager.com/gtag/js?id='.$this->advertising['gawpid'], 'async'=>'true'));
            $this->addTeg('head', 'googleanalytics_js', 'script', array('js' => "window.dataLayer = window.dataLayer || []; 
            function gtag(){dataLayer.push(arguments);} 
            gtag('js', new Date());"
            ." gtag('config', '".$this->advertising['gawpid']."'" .( $this->advertising['ga_anonymize'] ? ",{ 'anonymize_ip': true }" : '' ).");"));




        }
        //Google Tag Manager
        if (isset($this->advertising['gt_manager']) AND !empty($this->advertising['gt_manager'])){

            $this->addTeg('head', 'googletagmanager_js', 'script', array('js' => "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','".$this->advertising['gt_manager']."');"));

            $this->addTeg('body', 'googletagmanager_noscript', 'html', array('html' => '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$this->advertising['gt_manager'].'" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>'));
        }


        //Yandex
        if (isset($this->advertising['ymid']) AND !empty($this->advertising['ymid'])) {

            $this->addTeg('head', 'yandex_teg', 'script', array('js' => '   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
               m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
               (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
               ym('.$this->advertising['ymid'].', "init", {
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:'.($this->advertising['ym_webvisor'] ? 'true' : 'false').'
               });'));

            $this->addTeg('head', 'yandex_noscript', 'html', array('html' => '<noscript><div><img src="https://mc.yandex.ru/watch/'.$this->advertising['ymid'].'" style="position:absolute; left:-9999px;" alt="" /></div></noscript>'));
        }


    }


}