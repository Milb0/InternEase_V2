<?php
$title = "InternEase - Dashboard";
$style_file = "../assets/css/auth.css";
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'student') {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
} elseif (!isset($_SESSION['user_type'])) {
    header("Location:../whoami.php");
}
var_dump($_SESSION['id']);
echo $_SESSION['LAST_ACTIVITY'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_unset();
    session_destroy();
    echo 'Session timed out.';
    $Message = urlencode("DeezNuts");
    header("Location:../index.php?Message=.{$Message}");
}

?>
<form method="POST" action="dashboard.php">
    <button type="submit" name="login" value="LogOut">
</form>