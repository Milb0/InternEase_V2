<?php

require_once __DIR__ . '/../includes/config.php';

class Student
{
    private $db;

    public function __construct()
    {
        global $db_conn;
        $this->db = $db_conn;
    }

    public function createStudent($studentCardID, $department_id, $email, $username, $password_hashed,$verification_code, $name, $birthdate, $grade, $phonenumber, $is_verified)
    {
        $sql = "INSERT INTO student (StudentCardID, dep_id, email, username, password_hashed, verification_code , name, birthdate, grade, phonenumber, is_verified) VALUES (:StudentCardID, :department_id, :email, :username, :password_hashed, :verification_code, :name, :birthdate, :grade, :phonenumber, :is_verified)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(":StudentCardID", $studentCardID, PDO::PARAM_STR);
            $stmt->bindParam(":department_id", $department_id, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password_hashed", $password_hashed, PDO::PARAM_STR);
            $stmt->bindParam(":verification_code", $verification_code, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
            $stmt->bindParam(":grade", $grade, PDO::PARAM_STR);
            $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(":is_verified", $is_verified, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function isEmailTaken($email)
    {
        $sql = "SELECT id FROM student WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getDepartmentId($name)
    {
        $sql = "SELECT id FROM department WHERE name = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $department_id = $stmt->fetchColumn();
            if (!$department_id) {
                throw new Exception("Department not found");
            } else {
                return $department_id;
            }
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function verifyStudent($email): bool
    {
        $sql = "UPDATE student SET is_verified = 1 WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isVerified(string $email): bool
    {
        $sql = "SELECT is_verified FROM student WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $is_verified = $stmt->fetchColumn(0);
            return $is_verified === 1;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function getStudent($email)
    {
        $sql = "SELECT * FROM student WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);      
    }

    public function getLoginInfo($email){
        $sql="SELECT email,password_hashed FROM student WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentVerificationCode($email){
        $sql="SELECT verification_code FROM student WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
}
