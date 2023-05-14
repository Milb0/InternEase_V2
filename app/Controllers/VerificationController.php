<?php
require_once BASE_DIR . 'app/Models/Student.php';
$code = $code_err = '';
$student = new Student();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = filter_input(INPUT_POST,'code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty(trim($code))) {
        $code_err = "Don't leave this field empty";
    } elseif (!preg_match('/^[0-9]+$/', trim($code))) {
        $code_err = "Please enter a valid code";
    } elseif ((int)trim($code) !== (int)$_SESSION["verification_code"]) {
        $code_err = "The code you entered doesn't match the original";
    } elseif ($student->verifyStudent($_SESSION["id"])) {
        unset($_SESSION['verification_code']);
        unset($_SESSION['email']);
        $_SESSION['message'] = 'Your Account is verified';
        header("Location:../student/login.php");
        exit;
    } else {
echo "hi";
        exit;
    }
}
