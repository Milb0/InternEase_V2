<?php

class InternshipSupervisor
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function createInternshipSupervisor($company_id, $email, $username, $name, $phonenumber, $faxnumber)
    {
        $sql = "INSERT INTO internship_supervisor (company_id, email, username, name, phonenumber, faxnumber) VALUES (:company_id, :email, :username, :name, :phonenumber, :faxnumber)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bindParam(":company_id", $company_id, PDO::PARAM_INT);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(":faxnumber", $faxnumber, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                $supervisorID = $this->db->lastInsertId();
                return $supervisorID;
            } else {
                return false;
            }
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

        // Checking if the variables should be updated
        if (!empty($name)) {
            $sql .= "name = :name";
            $params[':name'] = $name;
        }

        if (!empty($email)) {
            if (!empty($name)) {
                $sql .= ", ";
            }
            $sql .= "email = :email";
            $params[':email'] = $email;
        }

        if (!empty($password_hash)) {
            if (!empty($name) || !empty($email)) {
                $sql .= ", ";
            }
            $sql .= "password_hashed = :password_hash";
            $params[':password_hash'] = $password_hash;
        }

        if (!empty($phone)) {
            if (!empty($name) || !empty($email) || !empty($password_hash)) {
                $sql .= ", ";
            }
            $sql .= "phonenumber = :phone";
            $params[':phone'] = $phone;
        }

        $sql .= " WHERE id = :id";
        $params[':id'] = $id;

        // Appending the WHERE clause
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

    public function getInternshipSupervisor($identifier, $byEmail)
    {
        if ($byEmail) {
            $sql = "SELECT * FROM internship_supervisor WHERE email = :identifier";
        } else {
            $sql = "SELECT * FROM internship_supervisor WHERE id = :identifier";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":identifier", $identifier, PDO::PARAM_STR);

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

    public function isAccountActive(string $id): bool
    {
        $sql = "SELECT active FROM internship_supervisor WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $active = $stmt->fetchColumn(0);
            return $active === 1;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function accountActive($id)
    {
        $sql = "UPDATE internship_supervisor SET Active = 1 WHERE id= :id";
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
?>