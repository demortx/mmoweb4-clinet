<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="email">
        {$lang_list_ma}
    </label>
    <div class="col-md-7 pt-5">
        <table class="table table-striped table-vcenter">
            <thead>
            <tr>
                <th>{$table_th_acc}</th>
                <th class="d-none d-sm-table-cell" style="width: 15%;">{$table_th_ip}</th>
                <th class="d-none d-sm-table-cell" style="width: 25%;">{$table_th_login}</th>
                <th class="d-none d-sm-table-cell" style="width: 15%;">{$table_th_status}</th>
                <th class="text-center" style="width: 50px;"></th>
            </tr>
            </thead>
            <tbody>
            {if $.php.is_array($manager_list) AND $.php.count($manager_list)}
            {foreach $manager_list as $m_a}
                <tr>
                    <td type="{if $m_a.email? AND $m_a.phone?}{$m_a.phone}{/if}">
                        {if $m_a.mn_status == 0}<i class="fa fa-exclamation-triangle mr-5 text-warning" title="{$table_th_status_0}"></i>{/if}
                        {if $m_a.email?}{$m_a.email}{else}{$m_a.phone}{/if}
                    </td>
                    {if $m_a.mn_status == 1}
                    <td class="d-none d-sm-table-cell">
                        {$m_a.last_ip}
                    </td>
                    <td class="d-none d-sm-table-cell">
                        {$m_a.last_login}
                    </td>
                    <td class="d-none d-sm-table-cell">
                        {if $m_a.status == 0}
                            <span class="badge badge-success">Active</span>
                        {else}
                            <span class="badge badge-warning">BAN</span>
                        {/if}
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "manager_delete", ['mid' => $m_a.mid])} class="btn btn-sm btn-secondary submit-btn" title="Delete">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </td>
                    {else}
                        <td colspan="4" title="{$table_th_status_0}">
                            <form action="/input" class="form-inline float-right" method="post" onsubmit="return false;">
                                {$.php.form_hide_input("Modules\Globals\Settings\Settings", "manager_confirm")}
                                <input type="hidden" name="mid" value="{$m_a.mid}">
                                <label class="sr-only" for="key">{$form_confirm_key}</label>
                                <input type="email" class="form-control mb-2 mr-sm-2 mb-sm-0" id="key" name="key" placeholder="Enter key..">
                                <button type="submit" class="btn btn-alt-primary submit-form">{$form_confirm_btn}</button>
                            </form>

                        </td>
                    {/if}
                </tr>
            {/foreach}
            {else}
                <tr>
                    <td colspan="5" class="text-center">{$lang_list_ma_empty}</td>
                </tr>
            {/if}
            </tbody>
        </table>
    </div>
</div>




<form action="/input" method="post" onsubmit="return false;">
    {$.php.form_hide_input("Modules\Globals\Settings\Settings", "manager_add")}
    <h4 class="font-w400 text-center">{$lang_title}</h4>
    <hr>
    <div class="form-group row input-email">
        <label class="col-md-4 col-form-label text-right border-right" for="email">
            {$lang_input_email_or_phone}
        </label>
        <div class="col-md-4 pt-5">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-right border-right" for="input_password">
            {$lang_input_password}
        </label>
        <div class="col-md-4 pt-5">
            <input type="password" class="form-control" id="input_password" name="password" placeholder="Password">
        </div>
    </div>
    {if $.site.config.cabinet.pin_shield}
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-right border-right" for="input_password_pin">
                {$lang_input_password_pin}
            </label>
            <div class="col-md-4 pt-5">
                <input type="password" class="form-control" maxlength="4" id="input_password_pin" name="pin" placeholder="Pin-code">
            </div>
        </div>
    {/if}
    <div class="block-content block-content-sm block-content-full bg-body-light block-settings-save-fix">
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-alt-success submit-form">
                <i class="fa fa-save mr-5"></i> {$lang_button_add}
            </button>
        </div>
    </div>

</form>
