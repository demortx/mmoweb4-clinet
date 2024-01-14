<!-- Page Content -->
{if $_IFRAME == false}
<div class="row mx-0 justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="pb-20 text-center">
                <h1 class="h4 font-w700 mt-30 mb-10">{$signin_title_lang}</h1>
            </div>
            <!-- END Header -->
{/if}

            <!-- Sign In Form -->
            <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.js) -->
            <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
            <form class="js-validation-signin" action="/input" method="post" onsubmit="return false;">
                {$.php.form_hide_input("Modules\Globals\SignIn\SignIn", "signin")}
                <input id="type_login" name="type_login" type="hidden" value="email">
                <div class="block block-themed block-rounded block-shadow {if $_IFRAME}mb-0{/if}">
                    {if $.get.title != 'false'}
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">{$signin_title_desc_lang}</h3>
                        <div class="block-options">
                            <select class="form-control font-size-xs" id="change_lang" style="height: 30px;">
                                {foreach $config.site.language_list as $lang_key => $lang_title}
                                    <option hreflang="{$lang_key}" value="/{$lang_key}{$.site.uri_string}" {if $.php.select_lang() == $lang_key}selected{/if}>{$lang_title|truncate:3:""|upper}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    {/if}
                    <div class="block-content">
                        <div class="form-group">
                            <label for="select-server">{$signin_title_input_server_lang}</label>
                            {set $opt_show = ($.php.count($.site.config.project.server_info) > 1)}
                            <select class="form-control" id="select-server" name="sid"> <!-- select_server() -->
                                {foreach $.site.config.project.server_info as $platform => $server_list}
                                    {if $opt_show}<optgroup label="{$.php.ucfirst($platform)}">{/if}
                                        {foreach $server_list as $sid => $server}
                                            <option value="{$sid}" {if $.php.get_instance()->get_sid() == $sid}selected{/if} {if $server.status == false}disabled{/if}>{$server.name} {if $server.rate > 0}[x{$server.rate}]{/if}</option>
                                        {/foreach}
                                    {if $opt_show}</optgroup>{/if}
                                {/foreach}
                            </select>
                        </div>


                        {set $activ_tab = true}
                        {if $config.cabinet.signin_type.email? OR $config.cabinet.signin_type.login?}
                        <div class="form-group row input-email">
                            <div class="col-12">
                                <label for="email">{$signin_title_input_email_lang}</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="{$signin_title_input_email_lang_placeholder}">
                            </div>
                        </div>
                            {set $activ_tab = false}
                        {/if}

                        {if $config.cabinet.signin_type.phone?}
                        <div class="form-group row input-phone" {if $activ_tab == false}style="display: none;"{/if}>
                            <div class="col-12">
                                <label for="t-signup-phone">{$signin_title_input_email_lang}</label>
                                <div class="input-group">
                                    <input id="phone" name="phone" class="form-control" type="tel">
                                    <input id="phone_code" name="phone_code" type="hidden">
                                </div>

                            </div>
                        </div>
                            {set $activ_tab = false}
                        {/if}



                        {if $activ_tab}

                            {$signin_title_not_active_login_type}

                        {else}


                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password">{$signin_title_input_password_lang}</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="*************">
                                </div>
                            </div>

                            {if $config.cabinet.captcha == 'captcha'}
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="captcha">{$signin_title_input_captcha_lang}</label>
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text p-0"><img id="captcha-img"
                                                                                        style="border-radius: 3px 0 0 3px;"
                                                                                        class="btn-secondary"
                                                                                        src="/captcha/img"></span>
                                                <button type="button" class="btn btn-secondary"
                                                        onclick="$('#captcha-img').attr('src','/captcha/img?'+Math.random());">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i></button>
                                            </div>
                                            <input type="text" class="form-control" id="captcha" name="captcha"
                                                   placeholder="">
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
                                    grecaptcha.ready(function () {
                                        grecaptcha.execute('{$config.cabinet.recaptcha_public_key}', { action: 'signup'})
                                            .then(function (token) {
                                                $('#captcha').val(token);
                                            });
                                    });
                                </script>
                            {/if}

                        {/if}

                        {if $config.cabinet.signin_social}
                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <label for="uLogin">{$signin_title_social}</label>
                                    <script src="//ulogin.ru/js/ulogin.js"></script>
                                    <div id="uLogin" data-ulogin="
                                            display=panel;
                                            theme=flat;
                                            fields=fields=first_name,last_name,email,photo_big;
                                            providers={$.php.implode(",", $config.cabinet.signin_social_type)};
                                            redirect_uri={$config.project.protocol_site}%3A%2F%2F{$.server['SERVER_NAME']}%2Fpanel;
                                            callback=auth_ulogin;
                                            mobilebuttons=0;"></div>
                                </div>
                            </div>
                        {/if}

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 d-sm-flex align-items-center push">
                                <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                    <input type="checkbox" class="custom-control-input" id="remember-me"
                                           name="remember-me">
                                    <label class="custom-control-label"
                                           for="remember-me">{$signin_title_btn_remember_me_lang}</label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-right push">
                                <button type="submit"
                                        class="btn btn-alt-primary submit-form">
                                    <i class="si si-login mr-10"></i> {$login_menu_lang_btn_signin}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="form-group text-center">
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{$.php.set_url('sign-up')}">
                                <i class="fa fa-plus mr-5"></i> {$login_menu_lang_btn_signup}
                            </a>
                            <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{$.php.set_url('reminder')}">
                                <i class="fa fa-warning mr-5"></i> {$login_menu_lang_btn_reminder}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Sign In Form -->
{if $_IFRAME == false}
        </div>
    </div>
</div>
<!-- END Page Content -->
{/if}


{if $config.cabinet.signin_type.phone?}
    {$.site._SEO->addTegHTML('head', 'telInput_css', 'link', ['rel'=>'stylesheet', 'href'=> $.const.VIEWPATH~'/panel/assets/css/intl-telInput/intlTelInput.css?ver=0.1'])}
    {$.site._SEO->addTegHTML('footer', 'telInput', 'script', ['src'=> $.const.VIEWPATH~'/panel/assets/js/plugins/intl-telInput/intlTelInput.js?ver=0.1'])}

<script>
    {ignore}
    function ValidPhone(Phone) {
        var re = /^\+?(\d[\d-. ]+)?(\([\d-. ]+\))?[\d-. ]+\d$/;
        var valid = re.test(Phone);
        return valid;
    }
    {/ignore}
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

        $('.separate-dial-code').on('click', '.selected-flag, .country', function () {
            $('#phone_code').val(iti.getSelectedCountryData().dialCode);
        });


        /*.input-email .input-phone #type_login */
        $('body').on('input keyup', '#email', function () {
            if (ValidPhone($(this).val())) {
                /* phone */
                if ($('.input-phone').is(":hidden")) {
                    $('#type_login').val('phone');
                    $('#phone').val($(this).val());

                    $('.input-phone').show();
                    $('.input-email').hide();
                    document.getElementById("phone").focus();
                }
            }
        });
        {if $config.cabinet.signin_type.email?}
        $('body').on('input keyup', '#phone', function () {
            var phone = $(this).val();
            if (phone.length > 2) {
                if (ValidPhone(phone) == false) {
                    /* email */
                    if ($('.input-email').is(":hidden")) {
                        $('#type_login').val('email');
                        $('#email').val(phone);

                        $('.input-email').show();
                        $('.input-phone').hide();
                        document.getElementById("email").focus();
                    }
                } else {
                    if (phone.length > 6) {
                        phone = phone.replace('+' + iti.getSelectedCountryData().dialCode, '');
                        $('#phone').val(phone);
                    }
                }
            }

        });
        {/if}

    });
</script>
{/if}