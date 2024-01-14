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
                                <th class="text-right"  style="width: 60%;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $info.char_list as $char_id => $char}
                                <tr>
                                    <td>{if $char.ban == 1}<span class="badge badge-danger"><i class="fa fa-ban mr-5"></i>BAN</span> {/if} {if $char.bind_hwid == 'true'}<i class="fa fa-expeditedssl" title="HWID"></i>{/if} {$char.name}</td>
                                    <td class="d-none d-sm-table-cell">{$char.level}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {if $server_info.teleport_char? AND $server_info.teleport_char AND $char.ban != 1}
                                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn" {$.php.btn_ajax("Modules\Lineage2\Character\Character", "ingame_teleport_char", ['login' => $login, 'char' => $char.name])}>{$lang_w_btn_teleport_char}</button>
                                            {/if}
                                            {if $server_info.hwid_char? AND $server_info.hwid_char AND $char.bind_hwid == 'true'}
                                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn" {$.php.btn_ajax("Modules\Lineage2\Character\Character", "ingame_reset_hwid_char", ['login' => $login, 'char' => $char.name])}>{$lang_w_btn_reset_hwid_char}</button>
                                            {/if}
                                            {if $server_info.pin_char? AND $server_info.pin_char}
                                            <button type="button" class="btn btn-sm btn-outline-secondary submit-btn" {$.php.btn_ajax("Modules\Lineage2\Character\Character", "ingame_reset_pin_char", ['login' => $login, 'char' => $char.name])}>{$lang_w_btn_reset_pin_char}</button>
                                            {/if}


                                            {if $.site.config.in_game_currency[get_sid()]['config']['char']? AND $.php.is_array($.site.config.in_game_currency[get_sid()]['settings'])}
                                                {foreach $.site.config.in_game_currency[get_sid()]['settings'] as $_currency}
                                                    {if $_currency['type'] == 'char'}
                                                        <button type="button" class="btn btn-sm btn-outline-secondary submit-btn" title="{$lang_w_btn_buy} {$_currency['long_name']}" {$.php.btn_ajax("Modules\Globals\InGameCurrency\InGameCurrency", "open_form", ['login' => $login, 'char' => $char.name])}>
                                                            {$lang_w_btn_buy} {$_currency['short_name']}
                                                        </button>
                                                        {break}
                                                    {/if}
                                                {/foreach}

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
                        {if $server_info.pin_account? AND $server_info.pin_account}<button type="button" class="btn btn-sm btn-noborder btn-outline-primary min-width-125 mr-5 submit-btn" {$.php.btn_ajax("Modules\Lineage2\Character\Character", "ingame_reset_pin_account", ['login'=>$login])}><i class="fa fa-expeditedssl mr-5" title="PIN-CODE"></i>{$lang_w_btn_reset_pin_account}</button>{/if}
                        {if $server_info.hwid_account? AND $server_info.hwid_account}<button type="button" class="btn btn-sm btn-noborder btn-outline-primary min-width-125 mr-5 submit-btn" {$.php.btn_ajax("Modules\Lineage2\Character\Character", "ingame_reset_hwid_account", ['login'=>$login])}><i class="fa fa-expeditedssl mr-5" title="HWID"></i>{$lang_w_btn_reset_hwid_account}</button>{/if}
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