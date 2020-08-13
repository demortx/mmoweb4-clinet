<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 04.10.2019
 * Time: 17:46
 */

return array(
    'ru' => array(
        UPLOAD_ERR_INI_SIZE => 'Загруженный файл превышает директиву upload_max_filesize в php.ini',
        UPLOAD_ERR_FORM_SIZE => 'Загруженный файл превышает директиву MAX_FILE_SIZE, указанную в HTML-форме.',
        UPLOAD_ERR_PARTIAL => 'Загруженный файл был загружен только частично',
        UPLOAD_ERR_NO_FILE => 'Файл не загружен',
        UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка',
        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск',
        UPLOAD_ERR_EXTENSION => 'Загрузка файла остановлена ​​расширением',
        'accepted_file_types' => 'Тип файла не разрешен для ',
        'file_uploads' => 'В php.ini отключена возможность загрузки файлов',
        'max_file_size' => ' слишком большой',
        'max_files_size' => 'Файлы слишком большие',
        'max_number_of_files' => 'Превышено максимальное количество файлов',
        'required_and_no_file' => 'Файл не выбран. Пожалуйста, выберите один',
        'invalid_folder_path' => 'Папка загрузки не существует или недоступна для записи',
        'default' => 'Неизвестная ошибка загрузки',
    ),
    'en' => array(

        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        'accepted_file_types' => 'File type is not allowed for ',
        'file_uploads' => 'File uploading option in disabled in php.ini',
        'max_file_size' => ' is too large',
        'max_files_size' => 'Files are too big',
        'max_number_of_files' => 'Maximum number of files is exceeded',
        'required_and_no_file' => 'No file was choosed. Please select one',
        'invalid_folder_path' => 'Upload folder doesn\'t exist or is not writable',
        'default' => 'Unknown upload error',
    ),
);