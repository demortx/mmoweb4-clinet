<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading">
        Path notes
        <a href="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/add')}" class="btn btn-sm btn-rounded btn-outline-primary float-right"><i class="fa fa-plus mr-5"></i>{$IBlock_btn_add}</a>
        <a href="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/delete_cache')}" class="btn btn-sm btn-rounded btn-outline-secondary float-right mr-5"><i class="fa fa-braille mr-5"></i>{$NewsSite_btn_delete_cache}</a>
    </h2>
    <div class="block block-rounded">
        <div class="block-content  p-0">

            <table class="table table-hover table-vcenter">
                <thead>
                <tr>
                    <th style="width: 18%;">Дата</th>
                    <th style="width: 18%;">Название</th>
                    <th style="width: 18%;">Опубликована</th>
                    <th class="text-center" style="width: 13%;"></th>
                </tr>
                </thead>
                <tbody>
                {foreach $patchnotes as $patchnote}
                    <tr>
                        <td class="font-w600">{$patchnote.date|date_format:"%Y/%m/%d"}</td>
                        <td>{array_shift(array_values(json_decode($patchnote.name,true)))}</td>
                        <td>
                            {if $patchnote.publish == 1}<i class="si si-check text-success"></i>{else}<i class="si si-close text-warning"></i>{/if}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/edit?patchnotes='~$patchnote.id)}" class="btn btn-sm btn-circle btn-alt-warning mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_edit_page}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/delete?patchnotes='~$patchnote.id)}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-circle btn-alt-danger mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_delete_news}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/patchnotes/section?patchnotes='~$patchnote.id)}" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$IBlock_btn_open_content}">
                                <i class="fa fa-sitemap"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>