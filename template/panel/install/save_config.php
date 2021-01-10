<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}

$search = array(
    "%API_KEY%",
    '%DB_HOST%',
    '%DB_NAME%',
    '%DB_USER%',
    '%DB_PASSWORD%',
    '%ADMIN_LOGIN%',
    '%ADMIN_PASSWORD%',
);
$replace = array(
    $_POST['API_KEY'],
    $_POST['DB_HOST'],
    $_POST['DB_NAME'],
    $_POST['DB_USER'],
    $_POST['DB_PASSWORD'],
    $_POST['ADMIN_LOGIN'],
    $_POST['ADMIN_PASSWORD'],
);

$file = file_get_contents(ROOT_DIR.'/template/panel/install/Config_tpl.txt');
$file = str_replace($search, $replace, $file);

if (file_exists(ROOT_DIR.'/Config.php')) {
    $fopen = fopen(ROOT_DIR.'/Config.php', "w");

    if ($fopen) {
        fwrite($fopen, $file);
        fclose($fopen);
        ?>
        <div class="alert alert-success d-flex align-items-center justify-content-between mb-15" role="alert">
            <div class="flex-fill mr-10">
                <p class="mb-0">Configs file updated</p>
            </div>
            <div class="flex-00-auto">
                <i class="fa fa-fw fa-2x fa-check"></i>
            </div>
        </div>

        <?
    }else
    {
        $write_config = false;
        ?>
        <div class="alert alert-warning d-flex align-items-center justify-content-between mb-15" role="alert">
            <div class="flex-fill mr-10">
                <p class="mb-0">No permission to write to Config.php file</p>
            </div>
            <div class="flex-00-auto">
                <i class="fa fa-fw fa-2x fa-pencil-square-o"></i>
            </div>
        </div>
        <?
    }
} else{
    $write_config = false;
    ?>
    <div class="alert alert-danger d-flex align-items-center justify-content-between mb-15" role="alert">
        <div class="flex-fill mr-10">
            <p class="mb-0">Config.php file was not found</p>
        </div>
        <div class="flex-00-auto">
            <i class="fa fa-fw fa-2x fa-neuter"></i>
        </div>
    </div>
    <?
}