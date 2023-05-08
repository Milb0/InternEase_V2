<?php
require_once '../../app/includes/bootstrap.php';
var_dump($_SESSION['user_type']);
var_dump($_SESSION["supervisor"]);
var_dump($_SESSION['email']);

$email = $_SESSION['email'];


require_once "../Models/Student.php";
$InternshipSupervisor = new Student();
$result= $InternshipSupervisor->getStudent($email);
print_r($result);
var_dump($result);