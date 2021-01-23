<?php if (! defined ( 'ROOT_DIR' )){ exit ( "Error, wrong way to file.<a href=\"/\">Go to main</a>.");}
$arr_error = array();
$php_modules = get_loaded_extensions();
foreach ($php_module_list as $module => $name){

    if (!in_array($module, $php_modules))
        $arr_error[] = "PHP library - <code>{$name}</code> not found!";

}

if (count($arr_error) > 0){
    $exist_error = true;
?>
    <div class="alert alert-warning d-flex align-items-center justify-content-between mb-15" role="alert">
        <div class="flex-fill mr-10">
            <p class="mb-0">Work cannot be continued until all PHP libraries are active</p>
        </div>
        <div class="flex-00-auto">
            <i class="fa fa-fw fa-2x fa-exclamation-triangle"></i>
        </div>
    </div>
    <ul class="list-group push">
    <?php
    foreach ($arr_error as $err){
        echo '<li class="list-group-item  justify-content-between align-items-center font-w600">
        '.$err.'
    </li>';
    }
?>
    </ul>
    <hr>
<?php
}
unset($arr_error, $php_module_list);
?>