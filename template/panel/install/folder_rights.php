<?php if (!defined('ROOT_DIR')) { exit ("Error, wrong way to file.<a href=\"/\">Go to main</a>."); }
$arr_error = array();
foreach ($folder_list as $file){

    if(!is_writable($file)) {
        if (file_exists($file))
            $arr_error[] = 'Change permissions from ' . decoct(fileperms($file) & 0777) . ' to 777 -> of the <code>' . $file . '</code> '.(is_file($file) ? 'file!' : 'folder!');
        else
            $arr_error[] = 'Directory or file is missing from this path: <code>' . $file . '</code>';
    }
}

if (count($arr_error) > 0){
    $exist_error = true;
?>
    <div class="alert alert-warning d-flex align-items-center justify-content-between mb-15" role="alert">
        <div class="flex-fill mr-10">
            <p class="mb-0">There are problems with the permissions to write directories and files</p>
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
unset($arr_error, $folder_list);
?>