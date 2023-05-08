<?php

require_once __DIR__ . '/../includes/config.php';
class InternshipSupervisor
{
    private $db;

    public function __construct()
    {
        global $db_conn;
        $this->db = $db_conn;
    }

    public function createInternshipSupervisor($company_id, $email, $username, $password_hashed, $name, $phonenumber, $faxnumber, $first_login)
    {
        $sql = "INSERT INTO internship_supervisor (company_id, email, username, password_hashed, name, phonenumber, faxnumber, first_login) VALUES (:company_id, :email, :username, :password_hashed, :name, :phonenumber, :faxnumber, :first_login)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(":company_id", $company_id, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password_hashed", $password_hashed, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(":faxnumber", $faxnumber, PDO::PARAM_STR);
            $stmt->bindParam(":first_login", $first_login, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCompanyName($company_id)
    {
        $sql = "SELECT name FROM company WHERE id = :company_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":company_id", $company_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $company_name = $stmt->fetchColumn();
            if (!$company_name) {
                throw new Exception("Company not found");
            } else {
                return $company_name;
            }
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function accountCompleted($email)
    {
        $sql = "UPDATE internship_supervisor SET first_login = 1 WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isFirstLogin(string $email): bool
    {
        $sql = "SELECT first_login FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $first_login = $stmt->fetchColumn(0);
            return $first_login === 0;
        } else {
            throw new Exception("Failed to execute query");
        }
    }
    public function getInternshipSupervisor($email)
{
    $sql = "SELECT * FROM internship_supervisor WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    if (!$stmt->execute()) {
        // handle database error here, e.g. log the error
        return null;
    }

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function getLoginInfo($email)
    {
        $sql="SELECT email,password_hashed FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(0);
    }
}
