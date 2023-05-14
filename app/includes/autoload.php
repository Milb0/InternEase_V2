<?php
// Autoload function
function autoload($className) {
    // Specify the directory where your model classes are located
    $directory = '../../app/Models/';

    // Convert the class name to the corresponding file path
    $filePath = $directory . $className . '.php';

    // Check if the file exists
    if (file_exists($filePath)) {
        // Include the file
        require_once $filePath;
    }
}

// Register the autoload function
spl_autoload_register('autoload');
?>
