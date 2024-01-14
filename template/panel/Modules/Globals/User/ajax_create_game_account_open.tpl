{$.php.form_hide_input("Modules\Globals\User\User", "create_game_account")}
<div class="form-group row">
    <div class="col-12">
        <label for="t-signup-login">{$title_input_login_lang}</label>
        <div class="input-group">
            {if $.site.config.cabinet.registration_login_prefix}
                <div class="input-group-prepend">
                    <select class="form-control" data-toggle="tooltip" data-placement="top" name="prefix" title="{$title_input_prefix_lang}" style="border-radius: .25rem 0 0 .25rem;">
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

<div class="form-group row">
    <div class="col-12">
        <label for="create-game-acc">{$title_input_password_lang}</label>
        <div class="input-group">

            <input type="password" class="form-control" id="create-game-acc" name="password" placeholder="********">
            <div class="input-group-append">
                <button type="button" class="btn btn-secondary" id="eye">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('body').off("click", "#eye").on('click', '#eye', function () {
            if ($("#create-game-acc").attr("type") === "password") {
                $("#create-game-acc").attr("type", "text");
                $("#eye").find('.fa').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $("#create-game-acc").attr("type", "password");
                $("#eye").find('.fa').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>