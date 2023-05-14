<?php
require_once BASE_DIR . 'app/Models/Student.php';
$student = new Student();
// define variables and set to empty values
$name = $email = $password = $confirm_password = $phone = $department = $department_id = $page = "";
$name_err = $email_err = $password_err = $confirm_password_err = $phone_err = $department_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
        $errors["name_err"] = $name_err;
    } else {
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $safe_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } elseif (!preg_match("/@univ-constantine2.dz$/", $safe_email)) {
            $email_err = "Email must have @univ-constantine2.dz only.";
        } else {
            $student->isEmailTaken($safe_email) ? $email_err = "This email is already taken." : $email = $safe_email;
        }
    }
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $safe_password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (strlen($safe_password) < 8 || strlen($safe_password) > 64) {
            $password_err = "Password must be between 8 and 64 characters.";
        } else {
            $password = $safe_password;
        }
    }
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
        $errors["phone_err"] = $phone_err;
    } else {
        $safe_phone=trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (!preg_match("/^\+?\d+$/", $safe_phone)) {
            $phone_err = "Invalid phone format.";
        } else {
            $phone = $safe_phone;
        }
    }

    // Validate department
    if (empty($_POST["department"])) {
        $department_err = "Please select a department.";
    } else {
        $department = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        try {
            $department_id = $student->getDepartmentId($department);
        } catch (Exception $e) {
            $department_err = $e->getMessage();
        }
    }
    if (empty($_POST["department"])) {
        $department_err = "Please select a department.";
    } else {
        $department = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        try {
            $department_id = $student->getDepartmentId($department);
        } catch (Exception $e) {
            $department_err = $e->getMessage();
        }
    }
    
    if (empty($_POST['grade'])) {
        $department_err = "Please select a Grade.";

    }else{
        $grade= trim(filter_input(INPUT_POST,'grade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($address_err) && empty($department_err)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $verification_code = rand();
        $studentCardID = "";
        $username = explode('@', $email)[0];
        $birthdate = "";
        $grade = $grade;
        $is_verified = 0;
        // Prepare an insert statement
        if ($student->createStudent($studentCardID, $department_id, $email, $username, $password_hash, $verification_code, $name, $birthdate, $grade, $phone, $is_verified)) {
            $_SESSION["email"] = $email;
            $_SESSION["verification_code"] = $verification_code;
            send_email($email, $verification_code);
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
