<div class="row mx-0 justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="pb-20 text-center">
                <h1 class="h4 font-w700 mt-30 mb-10">{$signup_title_lang}</h1>
            </div>
            <!-- END Header -->


            <form class="js-validation-signin" action="/input" method="post" id="form_signup" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\SignUp\SignUp", "signup")}
                <input id="type_reg" name="type_reg" type="hidden" value="#r-email">

                <div class="block block-themed block-rounded block-shadow">
                    <div class="block-header bg-gd-emerald">
                        <h3 class="block-title">{$signup_title_desc_lang}</h3>
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
                        {if $config.cabinet.registration_type.email? AND $config.cabinet.registration_type.phone?}
                            {set $tab_col_size = 6}
                        {/if}
                        {set $activ_tab = true}
                        {if $config.cabinet.registration_type.email?}
                        <li class="nav-item col-{$tab_col_size}">
                            <a class="nav-link {if $activ_tab}active {set $activ_tab = false}{/if}" href="#r-email"><i class="si si-envelope"></i> {$signup_title_tab_email_lang}</a>
                        </li>
                        {/if}

                        {if $config.cabinet.registration_type.phone?}
                        <li class="nav-item col-{$tab_col_size}">
                            <a class="nav-link {if $activ_tab}active {set $activ_tab = false}{/if}" href="#r-phone"><i class="si si-call-in"></i> {$signup_title_tab_phone_lang}</a>
                        </li>
                        {/if}

                    </ul>

                    <div class="block-content">
                        {if $config.cabinet.registration_login}

                            <div class="form-group add-login" style="display: none;">
                                <label for="t-signup-server">{$signup_title_input_server_lang}</label>
                                <a href="javascript:void(0)" class="float-right text-primary-light login-hide" style="font-size: 11px;">{$signup_title_btn_hide_email_lang}</a>

                                <select class="form-control" id="t-signup-server" name="sid">
                                    {foreach $.site.config.project.server_info as $platform => $server_list}
                                        <optgroup label="{$.php.ucfirst($platform)}">
                                            {foreach $server_list as $sid => $server}
                                                <option value="{$sid}" {if $server.status == false}disabled{/if}>{$server.name}  {if $server.rate > 0}[x{$server.rate}]{/if}</option>
                                            {/foreach}
                                        </optgroup>
                                    {/foreach}
                                </select>
                            </div>

                            <div class="form-group row add-login" style="display: none;">
                                <div class="col-12">
                                    <label for="t-signup-login">{$signup_title_input_login_lang}</label>
                                    <div class="input-group">
                                        {if $config.cabinet.registration_login_prefix}
                                            <div class="input-group-prepend">
                                                <select class="form-control" data-toggle="tooltip" data-placement="top" name="prefix" title="{$signup_title_input_prefix_lang}" style="border-radius: .25rem 0 0 .25rem;">
                                                    {foreach $prefix_list as $prefix first=$first}
                                                        <option value="{$prefix}" {if $first}selected{/if}>{$prefix}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        {/if}
                                        <input type="text" class="form-control" id="t-signup-login" name="login" placeholder="Login">
                                    </div>
                                </div>
                            </div>

                            <div class="row btn-add-login">
                                <div class="col-12 text-center">
                                    <a class="link-effect text-primary-light login-show" style="font-size: 11px;" href="javascript:void(0)">{$signup_title_btn_add_login_lang}</a>
                                </div>
                            </div>
                        {/if}

                        {set $activ_tab = true}
                        <div class="tab-content">
                            {if $config.cabinet.registration_type.email?}
                            <div class="tab-pane {if $activ_tab}active {set $activ_tab = false}{/if}" id="r-email" role="tabpanel">

                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="signup-email">{$signup_title_input_email_lang}</label>
                                        <input type="email" class="form-control" id="signup-email" name="email" placeholder="john@example.com">
                                        {if $config.cabinet.registration_confirmation}
                                            <div class="form-text text-muted">{$signup_desc_input_email_lang}</div>
                                        {else}
                                            <div class="form-text text-muted">{$signup_desc_input_email_phone_lang}</div>
                                        {/if}

                                    </div>
                                </div>

                            </div>
                            {/if}
                            {if $config.cabinet.registration_type.phone?}
                            <div class="tab-pane {if $activ_tab}active {set $activ_tab = false}{/if}" id="r-phone" role="tabpanel">

                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="t-signup-phone">{$signup_title_input_phone_lang}</label>
                                        <div class="input-group">
                                            <input id="phone" name="phone" class="form-control" type="tel">
                                            <input id="phone_code" name="phone_code" type="hidden">
                                        </div>
                                        <code>{$signup_desc_input_phone_lang}</code>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="t-signup-sms-cod">{$signup_input_phone_sms_lang}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-alt-success min-width-125 send-sms">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i> {$signup_btn_phone_sms_lang}
                                                </button>
                                            </div>
                                            <input type="text" class="form-control" id="t-signup-sms-cod" name="sms_cod" placeholder="XXXXXX">
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group row add-email" style="display: none;">
                                    <div class="col-12">
                                        <label for="signup-email-phone">{$signup_title_input_email_lang}</label>
                                        <a href="javascript:void(0)" class="float-right text-primary-light email-hide" style="font-size: 11px;">{$signup_title_btn_hide_email_lang}</a>
                                        <input type="email" class="form-control" id="signup-email-phone" name="email-phone" placeholder="john@example.com">
                                        <div class="form-text text-muted">{$signup_desc_input_email_phone_lang}</div>
                                    </div>
                                </div>
                                <div class="row btn-add-email">
                                    <div class="col-12 text-center">
                                        <a class="link-effect text-primary-light email-show" style="font-size: 11px;" href="javascript:void(0)">{$signup_title_btn_add_email_lang}</a>
                                    </div>
                                </div>

                            </div>
                            {/if}
                        </div>




                        {if $activ_tab}
                            {$signup_title_not_active_reg_type}
                        {else}
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="t-signup-password">{$signup_title_input_password_lang}</label>
                                    <div class="input-group">

                                        <input type="password" class="form-control" id="t-signup-password" name="password" placeholder="********">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-secondary" id="eye">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {if $config.cabinet.captcha == 'captcha'}
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="captcha">{$signup_title_input_captcha_lang}</label>
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
                            {elseif $config.cabinet.captcha == 'recaptchav2inv'}
                                <input type="hidden" id="captcha" name="g-recaptcha-response">
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                            {elseif $config.cabinet.captcha == 'recaptchav3'}
                                <input type="hidden" id="captcha" name="g-recaptcha-response">
                                <script src='https://www.google.com/recaptcha/api.js?render={$config.cabinet.recaptcha_public_key}'></script>
                                <script>
                                    grecaptcha.ready(function() {
                                        grecaptcha.execute('{$config.cabinet.recaptcha_public_key}', { action: 'sign-up'})
                                            .then(function(token) {
                                                $('#captcha').val(token);
                                            });
                                    });
                                </script>
                            {/if}


                            <div class="form-group row mb-0">
                                <div class="col-sm-12 push">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="signup-terms" name="terms">
                                        <label class="custom-control-label" for="signup-terms">{$signup_title_input_terms_lang}</label>
                                    </div>
                                    {if $config.cabinet.registration_subscribe}
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signup-subscribe" name="subscribe">
                                            <label class="custom-control-label" for="signup-subscribe">{$signup_title_input_subscribe_lang}</label>
                                        </div>
                                    {/if}
                                </div>
                                <div class="col-sm-12 text-sm-right push">

                                    <button type="submit" class="btn btn-alt-success submit-form {if $config.cabinet.captcha == 'recaptchav2inv'}g-recaptcha{/if}" {if $config.cabinet.captcha == 'recaptchav2inv'}data-sitekey="{$config.cabinet.recaptcha_public_key}" data-callback="onSubmitReInv"{/if}>
                                       {$signup_title_btn_submit_lang}
                                    </button>
                                </div>
                            </div>
                        {/if}
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="form-group text-center">
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                                <i class="fa fa-book text-muted mr-5"></i> {$signup_title_btn_read_terms_lang}
                            </a>
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{$.php.set_url('sign-in')}">
                                <i class="fa fa-user text-muted mr-5"></i> {$signup_title_btn_sign_in_lang}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Sign Up Form -->
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


        $('body').on('click', '.email-show',function(){
            $('.add-email').show();
            $('.btn-add-email').hide();
        });
        $('body').on('click', '.email-hide',function(){
            $('.add-email').hide();
            $('.btn-add-email').show();
            $("input[name=email]").val('');
        });

        $('body').on('click', '.send-sms',function(e){
            e.preventDefault();
            var phone_code = $("input[name=phone_code]").val();
            var phone = $("input[name=phone]").val();
            var captcha = $("input[name=captcha]").val();

            send_ajax('{$.php.http_build_query(['module_form' => "Modules\Globals\SignUp\SignUp",'module' => "send_sms"])}&phone_code='+phone_code+'&phone='+phone+'&captcha='+captcha, true);

        });

    });
</script>
{/if}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {


       /* function onSubmitReInv(token) {
            $('#captcha').val(token);
            document.getElementById("form_signup").submit();

        }*/

        $('.nav-tabs').on('click', '.nav-link',function(){
            $('#type_reg').val($(this).attr('href'));
        });
        $('.nav-link.active').click();


        $('body').on('click', '.login-show',function(){
            $('.add-login').show();
            $('.btn-add-login').hide();
        });
        $('body').on('click', '.login-hide',function(){
            $('.add-login').hide();
            $('.btn-add-login').show();
            $("input[name=login]").val('');
        });

        $("#eye").click(function () {
            const this__ = $(this).find('.fa');
            const password = $("#t-signup-password");

            if (password.attr("type") === "password") {
                password.attr("type", "text");
                this__.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                password.attr("type", "password");
                this__.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

    });
</script>