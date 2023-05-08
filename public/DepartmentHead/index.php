<?php
TODO:// Session User Authentication

require_once '../../app/includes/bootstrap.php';
$_SESSION["login_type"]='DepartmentHead';
header("location:login.php");
?>