<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="pin_status">
        {$lang_title_pin}
    </label>
    <div class="col-md-6 pt-5 text-justify">
        <span class="mr-5">
                <i class="fa fa-fw fa-expeditedssl mr-5"></i>
                PIN-code
        </span>
        <label class="css-control css-control-sm css-control-success css-switch p-0">
            <input type="checkbox" class="css-control-input pin-shield" name="pin_status" {if $.php.get_instance()->session->checkShield()}checked="checked"{/if}>
            <span class="css-control-indicator"></span>
        </label>
        <form action="/input" method="post" onsubmit="return false;">
            {$.php.form_hide_input("Modules\Globals\Settings\Settings", "pin_system")}
            <input type="hidden" name="enable" value="false">
            <div class="input-group mt-10 form-pin-code-disable" style="display: none;">
                <input type="text" class="form-control" id="cod_confirm" name="pin" placeholder="{$lang_label_placeholder_pin}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-alt-danger submit-form"><i class="fa fa-check"></i>  {$lang_btn_disable_pin}</button>
                </div>
            </div>
        </form>
        <div class="form-text text-muted mt-5">{$lang_description_pin_settings}</div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        $('body').on('change', '.pin-shield', function (e) {
            var pin_code_enable = {$.php.get_instance()->session->checkShield()};
            if($(this).is(':checked'))
            {
                $('.form-pin-code-disable').hide('slow');
                /*$('.form-pin-recovery').show('slow');*/
                if (pin_code_enable == 0){
                    send_ajax('{$.php.http_build_query(['module_form' => "Modules\Globals\Settings\Settings",'module' => "pin_system"])}&enable=true', true);
                    $(this).attr("disabled", true);
                }
            }else{
                if (pin_code_enable == 1){
                    $('.form-pin-code-disable').show('fade');
                }
                /*$('.form-pin-recovery').hide('fade');*/

            }
        });
    });
</script>
{*{if get_instance()->session->checkShield()}*}
<div class="form-group row {*form-pin-recovery*}">
    <label class="col-md-4 col-form-label text-right border-right" for="name">
        {$lang_title}
    </label>
    <div class="col-md-6 pt-5 text-justify">
        <div class="form-text text-muted"><p class="mb-10">{$lang_description}</p></div>
        {if $.site.session->session.master_account.telegram?}
            <button type="submit" class="btn btn-alt-success mr-5 submit-btn" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "recovery_pin", ['type' => 'telegram'])} title="{$.site.session->session.master_account.telegram}">{$lang_btn_telegram}</button>
        {/if}
        {if $.site.session->session.master_account.email?}
            <button type="submit" class="btn btn-alt-success mr-5 submit-btn" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "recovery_pin", ['type' => 'email'])} title="{$.site.session->session.master_account.email}">{$lang_btn_email}</button>
        {elseif $.site.session->session.master_account.phone?}
            <button type="submit" class="btn btn-alt-success mr-5 submit-btn" {$.php.btn_ajax("Modules\Globals\Settings\Settings", "recovery_pin", ['type' => 'phone'])} title="{$.site.session->session.master_account.phone}">{$lang_btn_phone}</button>
        {/if}

    </div>
</div>
{*{/if}*}
<hr>
