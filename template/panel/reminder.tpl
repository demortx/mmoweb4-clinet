<div class="row mx-0 justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="pb-20 text-center">

                <h1 class="h4 font-w700 mt-30 mb-10">{$reminder_title_lang}</h1>
            </div>
            <!-- END Header -->

            <form class="js-validation-reminder" action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\Reminder\Reminder", "reminder")}
                <input id="type_reminder" name="type_reminder" type="hidden" value="#r-email">
                <div class="block block-themed block-rounded block-shadow">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title">{$reminder_title_desc_lang}</h3>
                        <div class="block-options">
                            <select class="form-control font-size-xs" id="change_lang" style="height: 30px;">
                                {foreach $config.site.language_list as $lang_key => $lang_title}
                                    <option hreflang="{$lang_key}" value="/{$lang_key}{$.site.uri_string}" {if $.php.select_lang() == $lang_key}selected{/if}>{$lang_title|truncate:3:""|upper}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-tabs-alt row no-gutters" data-toggle="tabs" role="tablist">

                        {set $tab_col_size = 12}
                        {if $config.cabinet.reminder_type.email? AND $config.cabinet.reminder_type.phone?}
                            {set $tab_col_size = 6}
                        {/if}
                        {set $activ_tab = true}

                        {if $config.cabinet.reminder_type.email?}
                            <li class="nav-item col-{$tab_col_size}">
                                <a class="nav-link {if $activ_tab}active {set $activ_tab = false}{/if}" href="#r-email"><i class="si si-envelope"></i> {$reminder_title_tab_email_lang}</a>
                            </li>
                        {/if}

                        {if $config.cabinet.reminder_type.phone?}
                            <li class="nav-item col-{$tab_col_size}">
                                <a class="nav-link {if $activ_tab}active {set $activ_tab = false}{/if}" href="#r-phone"><i class="si si-call-in"></i> {$reminder_title_tab_phone_lang}</a>
                            </li>
                        {/if}
                    </ul>


                    <div class="block-content">


                        {set $activ_tab = true}
                        <div class="tab-content">
                            {if $config.cabinet.reminder_type.email?}
                                <div class="tab-pane {if $activ_tab}active {set $activ_tab = false}{/if}" id="r-email" role="tabpanel">

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="reminder-email">{$reminder_title_input_email_lang}</label>
                                            <input type="email" class="form-control" id="reminder-email" name="email" placeholder="john@example.com">
                                            <div class="form-text text-muted">{$reminder_desc_input_email_lang}</div>

                                        </div>
                                    </div>

                                </div>
                            {/if}
                            {if $config.cabinet.reminder_type.phone?}
                                <div class="tab-pane {if $activ_tab}active {set $activ_tab = false}{/if}" id="r-phone" role="tabpanel">

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="t-reminder-phone">{$reminder_title_input_phone_lang}</label>
                                            <div class="input-group">
                                                <input id="phone" name="phone" class="form-control" type="tel">
                                                <input id="phone_code" name="phone_code" type="hidden">
                                            </div>
                                            <code>{$reminder_desc_input_phone_lang}</code>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="t-reminder-sms-cod">{$reminder_input_phone_sms_lang}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-alt-success min-width-125 send-sms">
                                                        <i class="fa fa-envelope" aria-hidden="true"></i> {$reminder_btn_phone_sms_lang}
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control" id="t-reminder-sms-cod" name="sms_cod" placeholder="XXXXXX">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            {/if}
                        </div>


                        {if $activ_tab}
                            {$reminder_title_not_active_reminder_type}
                        {else}


                            {if $config.cabinet.captcha == 'captcha'}
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="captcha">{$reminder_title_input_captcha_lang}</label>
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-0"><img id="captcha-img" style="border-radius: 3px 0 0 3px;" class="btn-secondary" src="/captcha/img"></span>
                                                <button type="button" class="btn btn-secondary" onclick="$('#captcha-img').attr('src','/captcha/img?'+Math.random());"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                            </div>
                                            <input type="text" class="form-control" id="captcha" name="captcha" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            {elseif $config.cabinet.captcha == 'recaptchav2'}
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" data-sitekey="{$config.cabinet.recaptcha_public_key}"></div>
                                <br>
                            {elseif $config.cabinet.captcha == 'recaptchav3'}
                                <input type="hidden" id="captcha" name="captcha">
                                <script src='https://www.google.com/recaptcha/api.js?render={$config.cabinet.recaptcha_public_key}'></script>
                                <script>
                                    grecaptcha.ready(function() {
                                        grecaptcha.execute('{$config.cabinet.recaptcha_public_key}', { action: 'reminder'})
                                            .then(function(token) {
                                                $('#captcha').val(token);
                                            });
                                    });
                                </script>
                            {/if}



                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-alt-primary submit-form">
                                    <i class="fa fa-asterisk mr-10"></i> {$reminder_menu_lang_btn_reminder}
                                </button>
                            </div>
                        {/if}
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="form-group text-center">
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{$.php.set_url('sign-in')}">
                                <i class="fa fa-user text-muted mr-5"></i> {$login_menu_lang_btn_signin}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Reminder Form -->
        </div>
    </div>
</div>

{if $config.cabinet.registration_type.phone?}
    {$.site._SEO->addTegHTML('head', 'telInput_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/css/intl-telInput/intlTelInput.css?ver=0.1'])}
    {$.site._SEO->addTegHTML('footer', 'telInput', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/intl-telInput/intlTelInput.js?ver=0.1'])}

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "ru",
                nationalMode: false,
                placeholderNumberType: "MOBILE",
                preferredCountries: ["ru", "ua", "by", "md", "kz", "uz", "az", "pl", "am", "ge", "bg", "be", "tj", "kg", "lt", "lv", "ee", "ro", "tm", "ch", "de"],
                separateDialCode: true,
                utilsScript: "/template/panel/assets/js/plugins/intl-telInput/utils.js",
            });
            $('#phone_code').val(iti.getSelectedCountryData().dialCode);

            $('.separate-dial-code').on('click', '.selected-flag, .country',function(){
                $('#phone_code').val(iti.getSelectedCountryData().dialCode);
            });
            $('.nav-tabs').on('click', '.nav-link',function(){
                $('#type_reminder').val($(this).attr('href'));
            });
            $('.nav-link.active').click();


            $('body').on('click', '.send-sms',function(e){
                e.preventDefault();
                var phone_code = $("input[name=phone_code]").val();
                var phone = $("input[name=phone]").val();
                send_ajax('{$.php.http_build_query(['module_form' => "Modules\Globals\Reminder\Reminder",'module' => "reminder_sms"])}&phone_code='+phone_code+'&phone='+phone, true);
            });

        });
    </script>
{/if}