<?php
require_once '../../app/includes/bootstrap.php';
$title = "InternEase - Dashboard";
$style_file = "../assets/css/auth.css";
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'internship-supervisor') {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
} elseif (!isset($_SESSION['user_type'])) {
    header("Location:../whoami.php");
}
echo $_SESSION['LAST_ACTIVITY'];
var_dump($_SESSION['user_type']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_unset();
    session_destroy();
    echo 'Session timed out.';
    $Message = urlencode("DeezNuts");
    header("Location: ../whoami.php?Message=.{$Message}");
}

?>
<form method="POST" action="dashboard.php">
    <button type="submit" name="login" value="LogOut">
</form>: