<?php
function autoload($className) {
    $directory = '../../app/Models/';
    $filePath = $directory . $className . '.php';
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}
spl_autoload_register('autoload');
?>
