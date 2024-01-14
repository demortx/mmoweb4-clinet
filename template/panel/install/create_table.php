<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");} ?>
<h3>Creating database tables</h3>
<ul class="list-group push">
<?php
foreach ($db_table_install as $name => $sql){
    try {

        if($DB->query($sql)) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center font-w600">Create table: ' . $name . '<span class="badge badge-pill badge-success">OK</span></li>';
        }else {
            $error_insert = false;
            echo '<li class="list-group-item d-flex justify-content-between align-items-center font-w600">Create table: ' . $name . '<span class="badge badge-pill badge-danger">'.$DB->errorInfo()[2].'</span></li>';
        }
    }catch (\Exception $e){
        $error_insert = false;
        echo '<li class="list-group-item d-flex justify-content-between align-items-center font-w600">Create table: '.$name.'<span class="badge badge-pill badge-danger">'.$e->getMessage().'</span></li>';
    }
}
?>
</ul>