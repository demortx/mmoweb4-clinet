<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <h2 class="content-heading">
        {$NewsSite_title}
        <a href="{$.php.set_url($.const.ADMIN_URL~'/news/add')}" class="btn btn-sm btn-rounded btn-outline-primary float-right"><i class="fa fa-plus mr-5"></i>{$NewsSite_btn_add}</a>
        <a href="{$.php.set_url($.const.ADMIN_URL~'/news/delete_cache')}" class="btn btn-sm btn-rounded btn-outline-secondary float-right mr-5"><i class="fa fa-braille mr-5"></i>{$NewsSite_btn_delete_cache}</a>
    </h2>
    <div class="block block-rounded">
        <div class="block-content  p-0">

            <table class="table table-hover table-vcenter">
                <thead>
                <tr>
                    <th style="width: 15%;"></th>
                    <th style="width: 55%;">{$NewsSite_th_title}</th>
                    <th style="width: 11%;">{$NewsSite_th_public}</th>
                    <th style="width: 11%;">{$NewsSite_th_fixed}</th>
                    <th class="text-center" style="width: 13%;"></th>
                </tr>
                </thead>
                <tbody>
                {foreach $news_list as $news}
                <tr>
                    <td class="font-w600">{$news.date}</td>
                    <td>{$news.json.title}</td>
                    <td>
                        {if $news.publish == 1}<i class="si si-check text-success"></i>{else}<i class="si si-close text-warning"></i>{/if}
                    </td>
                    <td>
                        {if $news.fixed == 1}<i class="si si-check text-success"></i>{else}<i class="si si-close text-warning"></i>{/if}
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <a href="{$.php.set_url($.const.ADMIN_URL~'/news/edit?news='~$news.id)}" class="btn btn-sm btn-circle btn-alt-warning mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_edit_page}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="{$.php.set_url($.const.ADMIN_URL~'/news/delete?news='~$news.id)}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-circle btn-alt-danger mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_delete_news}">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
