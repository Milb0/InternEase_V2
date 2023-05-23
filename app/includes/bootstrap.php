<?php
$timeout = 10000; // in seconds
ini_set('session.gc_maxlifetime', $timeout);
session_set_cookie_params($timeout);

session_set_cookie_params(0, '/');
session_cache_limiter('nocache');
session_cache_expire(0);

// Start the session
session_start();

// Set the last activity time
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    // Session timed out
    session_unset();
    session_destroy();
    echo 'Session timed out.';
    header("location: ../index.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

// Your other code here
define('BASE_DIR', dirname(__DIR__) . '/../');
require_once "helpers.php";
require_once 'config.php';
require_once 'autoload.php';
