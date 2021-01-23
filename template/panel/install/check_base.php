<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}
try {
    $DB = new PDO('mysql:host=' . $_POST['DB_HOST'] . ';dbname=' . $_POST['DB_NAME'], $_POST['DB_USER'], $_POST['DB_PASSWORD']);
} catch (PDOException $e) {
    $db_true = false;
?>
    <div class="alert alert-danger d-flex align-items-center justify-content-between mb-15" role="alert">
        <div class="flex-fill mr-10">
            <p class="mb-0">No connection to base!<br>
                <?=$e->getMessage()?>
            </p>
        </div>
        <div class="flex-00-auto">
            <i class="fa fa-fw fa-2x fa-database"></i>
        </div>
    </div>
    <hr>
<?php
}
?>