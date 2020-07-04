<div class="block block-rounded">
    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#settings">{$lang_tab_title_settings}</a>
        </li>
        {if $.site.config.cabinet.manager_ma? AND $.site.config.cabinet.manager_ma AND $check_plugin_man_acc}
        <li class="nav-item">
            <a class="nav-link" href="#manager">{$lang_tab_title_manager}</a>
        </li>
        {/if}
        {if $account_list_hide? AND $account_list_hide != false}
        <li class="nav-item">
            <a class="nav-link" href="#hide">{$lang_tab_title_account_hide}</a>
        </li>
        {/if}
        {if $.site.config.cabinet.tab_active_log}
        <li class="nav-item">
            <a class="nav-link" href="#log-list">{$lang_tab_title_logs}</a>
        </li>
        {/if}


    </ul>
    <div class="block-content tab-content">
        <div class="tab-pane active" id="settings" role="tabpanel">
            <div class="row justify-content-center py-20">
                <div class="col-xl-12">
                    <h4 class="font-w400 text-center">{$lang_tab_title_settings_desc}</h4>
                    <hr>
                    {$content}
                </div>
            </div>
        </div>
        {if $.site.config.cabinet.manager_ma? AND $.site.config.cabinet.manager_ma AND $check_plugin_man_acc}
        <div class="tab-pane" id="manager" role="tabpanel">
            <div class="row justify-content-center py-20">
                <div class="col-xl-12">
                    <h4 class="font-w400 text-center">{$lang_tab_title_manager_desc}</h4>
                    <hr>
                    {$manager_content}
                </div>
            </div>
        </div>
        {/if}

        {if $account_list_hide? AND $account_list_hide != false}
            <div class="tab-pane" id="hide" role="tabpanel">
                <div class="row justify-content-center py-20">
                    <div class="col-xl-12">
                        <h4 class="font-w400 text-center">{$lang_tab_title_account_hide_desc}</h4>
                        <hr>
                        {$account_list_hide}
                    </div>
                </div>
            </div>
        {/if}

        {if $.site.config.cabinet.tab_active_log}
        <div class="tab-pane mb-20" id="log-list" role="tabpanel">
            <h4 class="font-w400 text-center">{$lang_tab_title_logs_desc}</h4>
            <table class="table table-bordered table-striped table-vcenter log-list-table ">
                <thead>
                <tr>
                    <th class="text-center"></th>
                    <th>{$lang_tab_logs_th_action}</th>
                    <th class="d-none d-sm-table-cell">IP</th>
                    <th class="d-none d-sm-table-cell">{$lang_tab_logs_th_date}</th>
                </tr>
                </thead>
                <tbody>
                {if $.site.session->session.user_data.logs? AND $.php.is_array($.site.session->session.user_data.logs)}
                    {foreach $.site.session->session.user_data.logs as $log}
                        <tr>
                            <td class="text-center">{$log.id}</td>
                            <td class="font-w600">{$log.description}</td>
                            <td class="d-none d-sm-table-cell">{$log.ip}</td>
                            <td class="d-none d-sm-table-cell">{$log.date}</td>
                        </tr>
                    {/foreach}
                {/if}
                </tbody>
            </table>
        </div>
        {/if}
    </div>
</div>
<!-- Page JS Plugins -->
{if $.site.config.cabinet.tab_active_log}
    {$.site._SEO->addTegHTML('head', 'datatablesb4_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/dataTables.bootstrap4.css'])}
    {$.site._SEO->addTegHTML('footer', 'dataTables', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/jquery.dataTables.min.js'])}
    {$.site._SEO->addTegHTML('footer', 'datatablesb4', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/datatables/dataTables.bootstrap4.min.js'])}

<script>
    class BeTableDatatables {
        static exDataTable() {
            jQuery.extend( jQuery.fn.dataTable.ext.classes, {
                sWrapper: "dataTables_wrapper dt-bootstrap4"
            });
        }
        static initDataTableFull() {
            jQuery('.log-list-table').dataTable({
                columnDefs: [ { orderable: false, targets: [ 1 ] } ],
                pageLength: 8,
                lengthMenu: [[5, 8, 15, 20], [5, 8, 15, 20]],
                autoWidth: false
            });
        }
        static init() {
            this.exDataTable();
            this.initDataTableFull();

        }
    }
    document.addEventListener("DOMContentLoaded", function(event) {
        jQuery(() => { BeTableDatatables.init(); });
    });

</script>
{/if}