<!-- Page Content -->
<div class="row mx-0 justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
            <form action="/{$.const.ADMIN_URL}" method="post" onsubmit="return false;">
                <div class="block block-themed block-rounded block-shadow">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">{$signin_title_desc_lang}</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group row input-email">
                            <div class="col-12">
                                <label for="login">{$signin_title_input_email_lang}</label>
                                <input type="text" class="form-control" id="login" name="login" placeholder="{$signin_title_input_email_lang_placeholder}">
                            </div>
                        </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password">{$signin_title_input_password_lang}</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="*************">
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-12 text-sm-right push">
                                <button type="submit" class="btn btn-alt-primary submit-form">
                                    <i class="si si-login mr-10"></i> {$login_menu_lang_btn_signin}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Sign In Form -->
        </div>
    </div>
</div>