<?php

require_once __DIR__ . '/../includes/config.php';

class DepartmentHead
{
    private $db;

    public function __construct()
    {
        global $db_conn;
        $this->db = $db_conn;
    }

    /*public function createHeadOfDepartment($department_id, $email, $username, $password_hashed, $name, $phonenumber)
    {
        $sql = "INSERT INTO head_of_department (dep_id, email, username, password_hashed, name, phonenumber) VALUES (:department_id, :email, :username, :password_hashed, :name, :phonenumber)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(":department_id", $department_id, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password_hashed", $password_hashed, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }*/

    /*public function isEmailTaken($email)
    {
        $sql = "SELECT id FROM head_of_department WHERE email = :email";
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
    }*/

    public function getDepartmentName($id)
    {
        $sql = "SELECT name FROM department WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $department_name = $stmt->fetchColumn();
            if (!$department_name) {
                throw new Exception("Department not found");
            } else {
                return $department_name;
            }
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function getDepartmentHead($email)
    {
        $sql = "SELECT * FROM head_of_department WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);      
    }

    public function getLoginInfo($email){
        $sql="SELECT email,password_hashed FROM head_of_department WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
