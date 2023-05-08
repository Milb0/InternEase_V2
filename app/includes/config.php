<?php
// Database configuration
$db_host = "localhost";
$db_name = "internease";
$db_user = "root";
$db_pass = "";
//PDO object
try {
    $db_conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
