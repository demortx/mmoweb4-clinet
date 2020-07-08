{if $.php.is_array($.site.session->session.user_data.account) AND $.php.count($.site.session->session.user_data.account)}
    {set $hide_account = false}

    {foreach $.site.session->session.user_data.account as $login => $info first=$first}
        {if $info['status'] == 2}
            {set $hide_account = $hide_account + 1}
            {continue}
        {/if}

        <div class="block block-bordered block-rounded mb-2 list_account {if $first}open{/if}">
            <div class="block-header pt-10 pb-10 pr-10 accordion_account" role="tab" id="account_list_info__{$login}_h1">

                <a class="font-w600" data-toggle="collapse" data-parent="#account_list_info" href="#account_list_info_{$login}_q1" aria-expanded="true" aria-controls="account_list_info_{$login}_q1">{if $info.info.is_banned == 'true'}<span class="badge badge-danger"><i class="fa fa-ban mr-5"></i>BAN</span> {/if}{$login}</a>
                <div class="float-left text-right">
                    {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}<i class="fa fa-user-o"></i></i> {$.php.count($info.char_list)}{/if}
                    <i class="fa fa-info-circle text-primary" data-toggle="popover" title="" data-html="true"  data-placement="top" data-content="{$lang_popup_info_status}: {if $info.info.is_banned == 'false'}{$lang_popup_info_active}{else}{$lang_popup_info_banned}{/if}</br>{$lang_popup_info_last_login}: {if $.php.is_array($info.info.last_logout)}-//-{else}{$info.info.last_logout}{/if}</br>{$lang_popup_info_last_ip}: {if $.php.is_array($info.info.last_ip)}-//-{else}{$info.info.last_ip}{/if}" data-original-title="{$login}"></i>
                </div>
            </div>
            <div id="account_list_info_{$login}_q1" class="collapse {if $first}show{/if}" role="tabpanel" aria-labelledby="account_list_info_{$login}_h1">
                <div class="block-content pt-1">
                    {if $.php.is_array($info.char_list) AND $.php.count($info.char_list)}
                        <table class="table table-sm table-vcenter">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">LvL</th>
                                <th class="text-right" style="width: 200px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $info.char_list as $char_id => $char}
                                <tr>
                                    <td>{if $char.ban == 1}<span class="badge badge-danger"><i class="fa fa-ban mr-5"></i>BAN</span> {/if}{$char.name}</td>
                                    <td class="d-none d-sm-table-cell">{$char.level}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {*<button type="button" class="btn btn-sm btn-outline-secondary" >
                                                В город
                                            </button>*}

                                            {if $.site.config.in_game_currency[get_sid()]['config']['char']?}
                                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn" {$.php.btn_ajax("Modules\Globals\InGameCurrency\InGameCurrency", "open_form", ['login' => $login, 'char' => $char.name])}>
                                                {$lang_w_btn_buy} {$payment_system.short_name_valute}
                                            </button>
                                            {/if}
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    {else}
                        <h6 class="text-center text-muted">{$lang_w_notfound_chars}</h6>
                    {/if}
                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-noborder btn-outline-primary min-width-125 mr-5 submit-btn" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "change_password_account_open", ['account'=>$login])}><i class="fa fa-retweet mr-5"></i>{$lang_w_btn_change_password}</button>
                        <button type="button" class="btn btn-sm btn-noborder btn-outline-primary min-width-125 submit-btn" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "forgot_password_account_open", ['account'=>$login])}><i class="fa fa-key mr-5"></i>{$lang_w_btn_forgot_password}</button>
                        <button type="button" class="btn btn-sm btn-noborder btn-outline-primary min-width-125 submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "hide_game_account", ['account'=>$login])}><i class="fa fa-eye-slash mr-5"></i>{$lang_w_btn_hide_account}</button>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}

    {if $hide_account}
        <footer class="blockquote-footer text-right"><a href="{$.php.set_url('/panel/settings#hide')}" class="text-muted">{$lang_w_exist_hide_acc}: {$hide_account}</a></footer>
    {/if}
{else}
    <div class="block block-bordered block-rounded mb-2 p-15 text-center">
        {$lang_w_notfound_account}
    </div>
{/if}