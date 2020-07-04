<div class="row mx-0 justify-content-center">
    <div class="col-lg-7 col-xl-5">
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="py-30 text-center">
                <h1 class="h4 font-w700 mt-30 mb-10">
                    {if $response_error == 1}
                        <i class="fa fa-times"></i> {$message}
                    {else}
                        <i class="fa fa-check"></i> {$signup_completed_title}
                    {/if}

                </h1>
            </div>
            <div class="py-30 h6 text-center">
                {if $response_error == 0}
                    {$signup_completed_desc}
                    <br>
                    <br><br>
                    <table class="table table-bordered table-vcenter text-left">
                        <tbody>
                        {if $.session.signup.prefix?}
                            <tr><td>{$signup_completed_prefix}</td><td>{$.session.signup.prefix}</td></tr>
                        {/if}
                        {if $.session.signup.login?}
                            <tr><td>{$signup_completed_login}</td><td>{$.session.signup.prefix}{$.session.signup.login}</td></tr>
                        {/if}
                        {if $.session.signup.email?}
                            <tr><td>{$signup_completed_email}</td><td>{$.session.signup.email}</td></tr>
                        {/if}
                        {if $.session.signup.phone?}
                            <tr><td>{$signup_completed_phone}</td><td>{$.session.signup.phone}</td></tr>
                        {/if}
                        {if $.session.signup.pin?}
                            <tr><td>{$signup_completed_pin}</td><td>{$.session.signup.pin}</td></tr>
                        {/if}
                        {if $.session.signup.password?}
                            {if $.session.signup.login?}
                                <tr><td>{$signup_completed_password_and_game}</td><td>{$.session.signup.password}</td></tr>
                            {else}
                                <tr><td>{$signup_completed_password}</td><td>{$.session.signup.password}</td></tr>
                            {/if}
                        {/if}
                        {if $.session.signup.subscribe?}
                            <tr><td>{$signup_completed_subscribe}</td><td><i class="fa fa-check"></i> {$.session.signup.subscribe}</td></tr>
                        {/if}
                        <tr><td colspan="2" class="text-center"><a class="link-effect" href="/text?type=registration&{if $.session.signup.prefix?}prefix={$.session.signup.prefix}&{/if}{if $.session.signup.login?}login={$.session.signup.prefix}{$.session.signup.login}&{/if}{if $.session.signup.email?}email={$.session.signup.email}&{/if}{if $.session.signup.pin?}pin={$.session.signup.pin}&{/if}{if $.session.signup.phone?}phone={$.session.signup.phone}&{/if}{if $.session.signup.password?}password={$.session.signup.password}{/if}"><i class="fa fa-save"></i> Сохранить в .txt файл.</a></td></tr>
                        </tbody>
                    </table>
                    <br><br>
                    {if $.session.signup.email?}
                        {$signup_completed_text_1} <code>{$.session.signup.email}</code>  {$signup_completed_text_2}
                        <br>
                        {$signup_completed_desc_2}
                        <br><br>
                    {/if}
                    {$signup_completed_desc_3}
                {/if}
            </div>
        </div>
    </div>
</div>