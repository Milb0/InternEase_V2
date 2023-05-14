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

            return $stmt->execute();
        } else {
            return false;
        }
    }

    /**
     * Update an Internship Supervisor in the database.
     *
     * @param int    $id             The ID of the Internship Supervisor to update.
     * @param string $name           The new name of the Internship Supervisor.
     * @param string $email          The new email of the Internship Supervisor.
     * @param string $password_hash  The new hashed password of the Internship Supervisor.
     * @param string $phone          The new phone number of the Internship Supervisor.
     *
     * @return bool  True if the update was successful, false otherwise.
     */
    public function updateInternshipSupervisor($id, $name, $email, $password_hash, $phone)
    {
        // Prepare the SQL statement with placeholders for the variables
        $sql = "UPDATE internship_supervisor SET ";
        $params = array();

        // Check if name should be updated
        if (!empty($name)) {
            $sql .= "name = :name";
            $params[':name'] = $name;
        }

        // Check if email should be updated
        if (!empty($email)) {
            if (!empty($name)) {
                $sql .= ", ";
            }
            $sql .= "email = :email";
            $params[':email'] = $email;
        }

        // Check if password_hash should be updated
        if (!empty($password_hash)) {
            if (!empty($name) || !empty($email)) {
                $sql .= ", ";
            }
            $sql .= "password_hashed = :password_hash";
            $params[':password_hash'] = $password_hash;
        }

        // Check if phone should be updated
        if (!empty($phone)) {
            if (!empty($name) || !empty($email) || !empty($password_hash)) {
                $sql .= ", ";
            }
            $sql .= "phonenumber = :phone";
            $params[':phone'] = $phone;
        }

        // Append the WHERE clause
        $sql .= " WHERE id = :id";
        $params[':id'] = $id;

        // Execute the query
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($params)) {
            return true;
        } else {
            return false;
        }
    }

    public function getLoginInfo($email)
    {
        $sql = "SELECT email,password_hashed FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(0);
    }

    public function isEmailTaken($email)
    {
        $sql = "SELECT id FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->rowCount() == 1;
        } else {
            return false;
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

    public function isFirstLogin(string $email): bool
    {
        $sql = "SELECT first_login FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $first_login = $stmt->fetchColumn(0);
            return $first_login === 1;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function accountCompleted($id)
    {
        $sql = "UPDATE internship_supervisor SET first_login = 0 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getInternshipSupervisorID($email)
    {
        $sql = "SELECT id FROM internship_supervisor WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Failed to execute query");
        }
    }
}
