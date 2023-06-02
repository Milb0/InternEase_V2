<?php

class Company
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function createCompany($name, $address)
    {
        $sql = "INSERT INTO company (name, address) VALUES (:name, :address)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":address", $address, PDO::PARAM_STR);

        $result = $stmt->execute();

        if ($result) {
            $companyID = $this->db->lastInsertId(); // Retrieve the ID of the inserted record
            return $companyID;
        } else {
            return false; // Return false if the insertion failed
        }
    }


    public function getCompany($company_id, $includeAddress = false)
    {
        $sql = "SELECT name" . ($includeAddress ? ", address" : "") . " FROM company WHERE id = :company_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":company_id", $company_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $company_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$company_data) {
                throw new Exception("Company not found");
            } else {
                return $company_data;
            }
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    /**
     * Update a Company in the database.
     *
     * @param int    $id             The ID of the company to update.
     * @param string $name           The new name of the Company.
     * @param string $email          The new address of the Company.
     *
     * @return bool  True if the update was successful, false otherwise.
     */
    public function updateCompany($id, $name, $address)
    {
        // Prepare the SQL statement with placeholders for the variables
        $sql = "UPDATE company SET ";
        $params = array();

        // Check if name should be updated
        if (!empty($name)) {
            $sql .= "name = :name";
            $params[':name'] = $name;
        }

        // Check if address should be updated
        if (!empty($address)) {
            if (!empty($name)) {
                $sql .= ", ";
            }
            $sql .= "address = :address";
            $params[':address'] = $address;
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
}
?>