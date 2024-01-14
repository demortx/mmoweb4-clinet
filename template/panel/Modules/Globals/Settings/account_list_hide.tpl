{if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
    {set $hide_account = false}
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right">
        {$lang_list_hide_account}
    </label>
    <div class="col-md-7 pt-5">
        <div class="p-10">{$text_hide_account_info}</div>

        <table class="table table-bordered  table-hover table-vcenter">
            <tbody>
            {foreach $.site.session->session.user_data.account as $login => $info first=$first}
                {if $info['status'] == 2}
                    {set $hide_account = $hide_account + 1}

                    <tr>
                        <th class="text-center" scope="row">{$login}</th>
                        <td class="text-center" style="width: 100px;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "show_game_account", ['account'=>$login])}>
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                {/if}
            {/foreach}
            {if $hide_account == false}
                <tr>
                    <th rowspan="2" class="text-center">{$lang_list_hide_account_empty}</th>
                </tr>
            {/if}
            </tbody>
        </table>
    </div>
</div>
{/if}