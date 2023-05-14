<?php
TODO:// Session User Authentication

require_once BASE_DIR . 'app/Models/Student.php';
$student = new Student();
// define variables and set to empty values
$name = $email = $password = $confirm_password = $phone = $department = $department_id = $page= "";
$name_err = $email_err = $password_err = $confirm_password_err = $phone_err = $department_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
        $errors["name_err"] = $name_err;
    } else {
        $name = trim($_POST["name"]);
        $inputs["name"] = $name;
    }
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
        $errors["email_err"] = $email_err;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
        $errors["email_err"] = $email_err;
    } elseif (!preg_match("/@univ-constantine2.dz$/", $_POST["email"])) {
        $email_err = "Email must have @univ-constantine2.dz only.";
        $errors["email_err"] = $email_err;
    } else {
        // Check if email is already taken
        $stmt = $db_conn->prepare("SELECT id FROM student WHERE email = :email");
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = trim($_POST["email"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $email_err = "This email is already taken.";
            } else {
                $email = trim($_POST["email"]);
                $inputs["email"] = $email;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->closeCursor();
    }
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
        $errors["password_err"] = $password_err;
    } elseif (strlen(trim($_POST["password"])) >= 8 && strlen(trim($_POST["password"])) <= 64) {
        $password_err = "Password must be at least 8 characters and at most 64 characters";
        $errors["password_err"] = $password_err;
    } else {
        $password = trim($_POST["password"]);
        $inputs["password"] = $password;
    }
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
        $errors["confirm_password_err"] = $confirm_password_err;
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            $errors["confirm_password_err"] = $confirm_password_err;
        }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
        $errors["phone_err"] = $phone_err;
    } elseif (!preg_match("/^\+?\d+$/", $_POST["phone"])) {
        $phone_err = "Invalid phone format.";
        $errors["phone_err"] = $phone_err;
    } else {
        $phone = trim($_POST["phone"]);
        $inputs["phone"] = $phone;
    }

    // Validate department
    if (empty($_POST["department"])) {
        $department_err = "Please select a department.";
        $errors["department_err"] = $department_err;
    } else {
        $department = $_POST["department"];
        $inputs["department"] = $department;
        $sql = "SELECT id FROM department WHERE name = :name";
        $stmt = $db_conn->prepare($sql);
        if ($stmt) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_department_name, PDO::PARAM_STR);

            // Set parameters
            $param_department_name = $department;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $department_id = $stmt->fetchColumn();
                if (!$department_id) {
                    $department_err = "No department found with that name.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        unset($stmt);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($address_err) && empty($department_err)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $verification_code = rand();
        $studentCardID = "45454545";
        $username = "Milb";
        $birthdate = "2002-01-01";
        $grade = "100";
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
        

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
