{$.site._SEO->addTegHTML('head', 'datatablesb4_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/dataTables.bootstrap4.css'])}
{$.site._SEO->addTegHTML('head', 'market_style', 'link', ['rel' => "stylesheet", "href" => $.const.VIEWPATH~'/panel/Modules/Lineage2/Market/market_style.css?7'])}

{$.site._SEO->addTegHTML('footer', 'dataTables', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/jquery.dataTables.min.js'])}
{$.site._SEO->addTegHTML('footer', 'datatablesb4', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/dataTables.bootstrap4.min.js'])}



<div class="block support-grid rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title d-none d-md-block">Список товаров на {$.php.get_sid_name(true, true)}
        </h3>
    </div>
    <div class="block-content">

        <div class="table-responsive">
            {$datatable_render}
        </div>
    </div>
</div>