<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <h2 class="content-heading">
        {$StaticPages_title}
        <a href="{$.php.set_url($.const.ADMIN_URL~'/pages/add')}" class="btn btn-sm btn-rounded btn-outline-primary float-right"><i class="fa fa-plus mr-5"></i>{$StaticPages_btn_add}</a>
    </h2>
    <div class="block block-rounded">
        <div class="block-content  p-0">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>URL</th>
                    <th>Description</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Show</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">TPL</th>
                    <th class="d-none d-sm-table-cell" style="width: 20%;">Date</th>
                    <th style="width: 10%;"></th>
                </tr>
                </thead>
                <tbody>
                {foreach $pages_list as $key => $page}
                    <tr>
                        <td>
                            <p class="font-w600 mb-10">{$page.url}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{$page.desc}</p>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {if $page.show == 'true'}<span class="badge badge-success">{$page.show}</span>{else}<span class="badge badge-danger">{$page.show}</span>{/if}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {$page.template}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {if $page.date?}<em class="text-muted">{$page.date|date_format:"%Y/%m/%d %H:%M:%S"}</em>{/if}
                        </td>
                        <td class="">
                            <a href="{$.php.set_url($page.url)}" target="_blank" class="btn btn-sm btn-circle btn-alt-primary mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_go_page}">
                                <i class="si si-action-redo"></i>
                            </a>
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/pages/edit?page='~$key)}" class="btn btn-sm btn-circle btn-alt-warning mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_edit_page}">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>