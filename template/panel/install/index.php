<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");} ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MmoWeb v4 - Install</title>
    <meta name="author" content="Demort">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="/template/panel/assets/media/favicons/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
    <link rel="stylesheet" id="css-main" href="/template/panel/assets/css/codebase.min.css">
</head>
<body>
<div id="page-container" class="main-content-boxed">
    <!-- Main Container -->
    <main id="main-container">
        <div class="bg-body-light hero-bubbles">
            <span class="hero-bubble wh-40 pos-t-20 pos-l-10 bg-primary"></span>
            <span class="hero-bubble wh-30 pos-t-20 pos-l-80 bg-success"></span>
            <span class="hero-bubble wh-20 pos-t-40 pos-l-25 bg-corporate"></span>
            <span class="hero-bubble wh-40 pos-t-30 pos-l-90 bg-pulse"></span>
            <span class="hero-bubble wh-30 pos-t-40 pos-l-20 bg-danger"></span>
            <span class="hero-bubble wh-30 pos-t-60 pos-l-25 bg-warning"></span>
            <span class="hero-bubble wh-30 pos-t-60 pos-l-80 bg-info"></span>
            <span class="hero-bubble wh-40 pos-t-75 pos-l-70 bg-flat"></span>
            <span class="hero-bubble wh-40 pos-t-75 pos-l-10 bg-earth"></span>
            <span class="hero-bubble wh-30 pos-t-90 pos-l-90 bg-elegance"></span>
            <div class="row no-gutters justify-content-center">
                <div class="hero-static col-lg-5">
                    <div class="content content-full overflow-hidden">
                        <!-- Header -->
                        <div class="py-50 text-center">
                            <a class="link-effect font-w700" href="/">
                                <i class="si si-fire"></i>
                                <span class="font-size-xl text-primary-dark">Mmo</span><span class="font-size-xl">Web</span>
                            </a>
                            <h1 class="h4 font-w700 mt-30 mb-10">Welcome to your new web app installation</h1>
                            <h2 class="h5 font-w400 text-muted mb-0">Let's get started, it will only take a few seconds!</h2>
                        </div>
                        <!-- END Header -->
                        <?php
                        $exist_error = false;
                        include ROOT_DIR.'/template/panel/install/folder_rights.php';
                        include ROOT_DIR.'/template/panel/install/checking_modules.php';
                        if ($exist_error){
                            ?>
                            <div class="text-center">
                                <div class="alert alert-danger d-flex align-items-center justify-content-between mb-15" role="alert">
                                    <div class="flex-fill mr-10">
                                        <p class="mb-0">The installation will continue after fixing all the errors!</p>
                                    </div>
                                    <div class="flex-00-auto">
                                        <i class="fa fa-fw fa-2x fa-microchip"></i>
                                    </div>
                                </div>
                                <a href="/install.php" class="btn btn-hero btn-alt-secondary min-width-150 mb-10">
                                    <i class="fa fa-repeat mr-10"></i> Reload
                                </a>
                            </div>
                            <?php
                        }else{

                            $error_input = array();

                            if (isset($_POST['API_KEY']) AND empty($_POST['API_KEY']))
                                $error_input['API_KEY'] = 'The "api key" field cannot be empty';

                            if (isset($_POST['DB_NAME']) AND empty($_POST['DB_NAME']))
                                $error_input['DB_NAME'] = 'The "db name" field cannot be empty';

                            if (isset($_POST['DB_HOST']) AND empty($_POST['DB_HOST']))
                                $error_input['DB_HOST'] = 'The "db host" field cannot be empty';

                            if (isset($_POST['DB_USER']) AND empty($_POST['DB_USER']))
                                $error_input['DB_USER'] = 'The "db user" field cannot be empty';

                            if (isset($_POST['DB_PASSWORD']) AND empty($_POST['DB_PASSWORD']))
                                $error_input['DB_PASSWORD'] = 'The "db password" field cannot be empty';

                            if (isset($_POST['ADMIN_LOGIN']) AND empty($_POST['ADMIN_LOGIN']))
                                $error_input['ADMIN_LOGIN'] = 'The "Admin login" field cannot be empty';

                            if (isset($_POST['ADMIN_PASSWORD']) AND empty($_POST['ADMIN_PASSWORD']))
                                $error_input['ADMIN_PASSWORD'] = 'The "Admin password" field cannot be empty';


                            if (!isset($_GET['step']) OR count($error_input))
                                include ROOT_DIR.'/template/panel/install/step_1.php';
                            else{
                                $DB = null;
                                $db_true = true;
                                include ROOT_DIR.'/template/panel/install/check_base.php';

                                if ($db_true) {
                                    $write_config = true;
                                    include ROOT_DIR . '/template/panel/install/save_config.php';
                                    if ($write_config){


                                        $error_insert = true;
                                        include ROOT_DIR . '/template/panel/install/create_table.php';

                                        if ($error_insert) {
                                            $fw = fopen(ROOT_DIR . '/Files/blocked_install.txt', "a+");
                                            fwrite($fw, date('Installation completed ' . date('Y-m-d H:i:s')));
                                            fclose($fw);
                                            include ROOT_DIR . '/template/panel/install/finis_install.php';
                                        }else
                                            include ROOT_DIR . '/template/panel/install/finis_install_error.php';



                                    }else{
                                        include ROOT_DIR.'/template/panel/install/step_1.php';
                                    }
                                }else
                                    include ROOT_DIR.'/template/panel/install/step_1.php';
                            }

                        }
                        ?>
                        <!-- END Installation Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->
<script src="/template/panel/assets/js/codebase.core.min.js"></script>
<script src="/template/panel/assets/js/codebase.app.min.js"></script>
</body>
</html>