<?php

class Department
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function createDepartment($fac_id, $name)
    {
        $sql = "INSERT INTO department (fac_id, name) VALUES (:fac_id, :name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":fac_id", $fac_id, PDO::PARAM_STR);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        $result = $stmt->execute();

        if ($result) {
            $departmentID = $this->db->lastInsertId();
            return $departmentID;
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
            throw new Exception("Try again please");
        }
    }

    public function getDepartment($id)
    {
        $sql = "SELECT fac_id, name FROM department WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $department_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $department_data;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function getDepartmentByFaculty($id)
    {
        $sql = "SELECT * FROM department WHERE fac_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $department_data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $department_data;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

    public function getDepartmentNames()
    {
        $sql = "SELECT name FROM department";
        $result =$this->db->query($sql);
        if ($result) {
            $department_data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $department_data;
        } else {
            throw new Exception("Failed to execute query");
        }
    }

}