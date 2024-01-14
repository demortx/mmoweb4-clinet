<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");} ?>
<form action="/install.php?step=install" method="post">
    <div class="block block-rounded block-shadow">
        <!-- api section -->
        <div class="block-content block-content-full">
            <h2 class="content-heading text-black pt-20">Api</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Please enter your api key from the admin panel.<br>
                        <a href="https://docs.mmoweb.ru/v/en/quick-start-guide/cms-setup/nastroika-konfiga#installing-an-api-key" target="_blank">More details</a>

                    </p>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="form-group">
                        <label for="install-api-key">Api key</label>
                        <input type="text" class="form-control form-control-lg <?=(isset($error_input['API_KEY'])?'is-invalid':'')?>" id="install-api-key" name="API_KEY" value="<?=(isset($_POST['API_KEY']) ? $_POST['API_KEY'] : API_KEY)?>" placeholder="Insert the api key from the admin panel here">
                        <?=(isset($error_input['API_KEY'])?'<div class="invalid-feedback">'.$error_input['API_KEY'].'</div>':'')?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END api section -->
        <!-- Database section -->
        <div class="block-content block-content-full">
            <h2 class="content-heading text-black pt-20">Database</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Please pay extra attention because adding the correct database info is vital for a successful app installation.<br>
                        <a href="https://docs.mmoweb.ru/v/en/quick-start-guide/cms-setup/nastroika-konfiga#setting-up-a-database-connection" target="_blank">More details</a>
                    </p>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="form-group">
                        <label for="install-db-name">Name</label>
                        <input type="text" class="form-control form-control-lg <?=(isset($error_input['DB_NAME'])?'is-invalid':'')?>" id="install-db-name" name="DB_NAME" value="<?=(isset($_POST['DB_NAME']) ? $_POST['DB_NAME'] : DB_NAME)?>" placeholder="What's the name of your database?">
                        <?=(isset($error_input['DB_NAME'])?'<div class="invalid-feedback">'.$error_input['DB_NAME'].'</div>':'')?>
                    </div>
                    <div class="form-group">
                        <label for="install-db-host">Host</label>
                        <input type="text" class="form-control form-control-lg <?=(isset($error_input['DB_HOST'])?'is-invalid':'')?>" id="install-db-host" name="DB_HOST" value="<?=(isset($_POST['DB_HOST']) ? $_POST['DB_HOST'] : DB_HOST)?>" placeholder="Leave empty for 'localhost'">
                        <?=(isset($error_input['DB_HOST'])?'<div class="invalid-feedback">'.$error_input['DB_HOST'].'</div>':'')?>
                    </div>
                    <div class="form-group">
                        <label for="install-db-username">Username</label>
                        <input type="text" class="form-control form-control-lg <?=(isset($error_input['DB_USER'])?'is-invalid':'')?>" id="install-db-username" name="DB_USER" value="<?=(isset($_POST['DB_USER']) ? $_POST['DB_USER'] : DB_USER)?>" placeholder="Database username">
                        <?=(isset($error_input['DB_USER'])?'<div class="invalid-feedback">'.$error_input['DB_USER'].'</div>':'')?>
                    </div>
                    <div class="form-group">
                        <label for="install-db-password">Password</label>
                        <input type="password" class="form-control form-control-lg <?=(isset($error_input['DB_PASSWORD'])?'is-invalid':'')?>" id="install-db-password" name="DB_PASSWORD" value="<?=(isset($_POST['DB_PASSWORD']) ? $_POST['DB_PASSWORD'] : DB_PASSWORD)?>" placeholder="Database password">
                        <?=(isset($error_input['DB_PASSWORD'])?'<div class="invalid-feedback">'.$error_input['DB_PASSWORD'].'</div>':'')?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Database section -->
        <!-- Administrator section -->
        <div class="block-content block-content-full">
            <h2 class="content-heading text-black pt-20">Administrator</h2>
            <div class="row items-push">
                <div class="col-lg-4">
                    <p class="text-muted">
                        Please add your email and a strong password to create the administrator account.<br>
                        <a href="https://docs.mmoweb.ru/v/en/quick-start-guide/cms-setup/nastroika-konfiga#setting-up-access-to-the-admin-panel" target="_blank">More details</a>
                    </p>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="form-group">
                        <label for="install-admin-email">Login</label>
                        <input type="text" class="form-control form-control-lg <?=(isset($error_input['ADMIN_LOGIN'])?'is-invalid':'')?>" id="install-admin-email" name="ADMIN_LOGIN" value="<?=(isset($_POST['ADMIN_LOGIN']) ? $_POST['ADMIN_LOGIN'] : ADMIN_LOGIN)?>">
                        <?=(isset($error_input['ADMIN_LOGIN'])?'<div class="invalid-feedback">'.$error_input['ADMIN_LOGIN'].'</div>':'')?>
                    </div>
                    <div class="form-group">
                        <label for="install-admin-password">Password</label>
                        <input type="password" class="form-control form-control-lg <?=(isset($error_input['ADMIN_PASSWORD'])?'is-invalid':'')?>" id="install-admin-password" name="ADMIN_PASSWORD" value="<?=(isset($_POST['ADMIN_PASSWORD']) ? $_POST['ADMIN_PASSWORD'] : ADMIN_PASSWORD)?>">
                        <?=(isset($error_input['ADMIN_PASSWORD'])?'<div class="invalid-feedback">'.$error_input['ADMIN_PASSWORD'].'</div>':'')?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Administrator section -->
        <div class="block-content">
            <div class="form-group row">
                <div class="col-lg-6 offset-lg-5">
                    <button type="submit" class="btn btn-hero btn-alt-success min-width-150 mb-10">
                        <i class="fa fa-arrow-right mr-10"></i> Install
                    </button>
                    <button type="reset" class="btn btn-hero btn-alt-secondary min-width-150 mb-10">
                        <i class="fa fa-repeat mr-10"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>