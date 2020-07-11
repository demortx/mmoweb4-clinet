<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <h2 class="content-heading">
        {$LangEditor_title_files}
    </h2>
    <div class="block block-rounded">
        <div class="block-content  p-0">

            <table class="table table-hover table-vcenter">
                <thead>
                <tr>
                    <th style="width: 15%;">Last Edit</th>
                    <th style="width: 55%;">File</th>
                    <th class="text-center" style="width: 10%;"></th>
                </tr>
                </thead>
                <tbody>
                {foreach $lang_files as $file}
                    <tr>
                        <td class="font-w600">{$file.time}</td>
                        <td>{$file.file}</td>
                        <td class="d-none d-sm-table-cell">
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/lang/panel?file='~$file.file)}" class="btn btn-sm btn-circle btn-alt-warning mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$StaticPages_edit_page}">
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
