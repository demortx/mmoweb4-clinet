<!-- Multiple Items -->
<div class="block block-rounded ribbon ribbon-modern ribbon-primary invisible" data-toggle="appear">
    {*<div class="ribbon-box" data-toggle="tooltip" data-placement="top" title="{$lang_w_title_tooltip}">
        <i class="fa fa-fw fa-users"></i> {count($.site.session->session.user_data.account)}
    </div>*}
    <button type="button" class="btn btn-rounded btn-primary btn-create-account submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "create_game_account_open",[0])} {if count($.site.session->session.user_data.account) >= $.site.config.cabinet.max_game_accounts}disabled{/if}>
        <i class="fa fa-plus mr-5"></i>{$title_btn_open_popup_lang}
        {if $.site.config.cabinet.max_game_accounts < 100}
            ({count($.site.session->session.user_data.account)}/{$.site.config.cabinet.max_game_accounts})
        {else}
            ({count($.site.session->session.user_data.account)}/99+)
        {/if}
    </button>
    <div class="block-content">
        <div class="mb-20">
            <span class="d-none d-md-inline-block">{$lang_w_title_chars_list}</span> {$.php.get_sid_name()}
        </div>
        <div id="account_list_info" role="tablist" aria-multiselectable="true">
            {$content_account_list}
        </div>
        <div class="text-center p-10">
            <button type="button" class="btn btn-sm btn-rounded btn-outline-primary submit-btn" {$.php.btn_ajax("Modules\Globals\User\User", "ajax_refresh_accounts", [0])}><i class="fa fa-refresh mr-5"></i>{$lang_w_refresh_account}</button>
        </div>
    </div>
</div>
<!-- END Multiple Items -->
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('#account_list_info').on('click', '.list_account > .accordion_account > a',function(){

            if ($(this).parent().parent().hasClass('open')){
                $(this).parent().parent().removeClass('open');
            }else{
                $(this).parent().parent().addClass('open');
            }
            setTimeout(() => window.masonry_div.masonry('layout'), 200);
        });
    });
</script>