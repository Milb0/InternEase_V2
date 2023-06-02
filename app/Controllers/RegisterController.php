<?php
$student = new Student($db_conn);
$department_obj = new Department($db_conn);

$name = $email = $password = $confirm_password = $birth_date = $birth_place = $phone = $department = $department_id = $student_card_id = $page = "";
$name_err = $email_err = $password_err = $confirm_password_err = $phone_err = $birth_date_err = $birth_place_err = $department_err = $grade_err = $student_card_id_err = $form_error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($expected_input_names as $input_name) {
        if (!isset($_POST[$input_name])) {
            throw new Exception("Something Went Wrong Try again please");
        }
    }
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
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

    if (empty(trim($_POST['birth_date']))) {
        $birth_date_err = "Please enter your birth date.";
    } else {
        $birth_date = trim($_POST["birth_date"]);
        if (!isValidDate($birth_date)) {
            $birth_date_err = "Invalid Birth Date format.";
        }
    }

    if (empty(trim($_POST['birth_place']))) {
        $birth_place_err = "Please enter your birth date.";
    } else {
        $safe_birth_place = trim(filter_input(INPUT_POST, 'birth_place', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (!preg_match('/^[\p{L}\p{N}\s\'\-.,]+$/u', $safe_birth_place)) {
            $birthplace_err = "Please enter a valid birthplace.";
        } else {
            $birth_place = $safe_birth_place;
        }
    }

    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } else {
        $safe_phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (!preg_match("/^\+?\d+$/", $safe_phone)) {
            $phone_err = "Invalid phone format.";
        } else {
            $phone = $safe_phone;
        }
    }

    // Validate department
    if (empty(trim($_POST["department"]))) {
        $department_err = "Please select a department.";
    } else {
        $department = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        try {
            $department_id = $department_obj->getDepartmentId($department);
        } catch (Exception $e) {
            $department_err = $e->getMessage();
        }
    }

    if (empty(trim($_POST['grade']))) {
        $department = NULL;
        $grade_err = "Please select a Grade.";
    } else {
        $grade = trim(filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $allowedGrades = ["L3 TI", "L3 SCI", "M2 STIC", "M2 RSD", "L3 GL", "L3 SI", "M2 SITW", "M2 GL"];
        if (!in_array($grade, $allowedGrades, true)) {
            $department_err = "Something went wrong with the grade you choose. Please try again.";
        }
    }

    if (empty(trim($_POST['student_card_id']))) {
        $student_card_id_err = "Please enter your Student card ID.";
    } else {
        $student_card_id = trim($_POST['student_card_id']);
        if (!preg_match("/^\d+$/", $student_card_id)) {
            $student_card_id_err = "Student card ID must contain numbers only.";
        }
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($address_err) && empty($department_err) && empty($grade_err) && empty($birth_date_err) && empty($birth_place_err) && empty($student_card_id_err)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $verification_code = rand();
        $username = explode('@', $email)[0];
        $is_verified = 0;

        if ($student->createStudent($student_card_id, $department_id, $email, $username, $password_hash, $verification_code, $name, $birth_date, $birth_place, $grade, $phone, $is_verified)) {
            $_SESSION["email"] = $email;
            $_SESSION["verification_code"] = $verification_code;
            send_email($email, $verification_code);
            exit;
        } else {
            $form_error_message = "Oops! Something went wrong. Please try again later.";
        }
    }
}
