<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading">Кеш сайта</h2>
    <div class="block block-rounded">

        <div class="block-content">
            <table class="js-table-sections table table-hover">
                <thead>
                <tr>
                    <th style="width: 30px;"></th>
                    <th>Section</th>
                    <th style="width: 15%;">Files</th>
                    <th style="width: 15%;"></th>
                </tr>
                </thead>

                {foreach $cache_list as $key => $cache}
                <tbody class="js-table-sections-header">
                <tr>
                    <td class="text-center">
                        <i class="fa fa-angle-right"></i>
                    </td>
                    <td class="font-w600">{$key}</td>
                    <td>
                        <span class="badge badge-success">{count($cache)}</span>
                    </td>
                    <td>
                        <a href="{$.php.set_url($.const.ADMIN_URL~'/cache/'~$key)}" class="btn btn-sm btn-rounded btn-outline-secondary float-right mr-5"><i class="fa fa-braille mr-5"></i>Clear</a>
                    </td>
                </tr>
                </tbody>



                <tbody>
                    {foreach $cache as $file}
                    <tr>
                        <td class="text-center"></td>
                        <td class="font-w600" colspan="3">{$file}</td>
                    </tr>
                    {/foreach}
                </tbody>
                {/foreach}

            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        jQuery(function(){ Codebase.helpers('table-tools'); });
    });
</script>