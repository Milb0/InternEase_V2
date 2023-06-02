<?php
class InternshipRequest
{
    private $db;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public function createRequest($student_id, $sup_id, $SSN, $theme, $description, $StartDate, $EndDate, $period, $RequestDate, $Status)
    {
        $RequestDateFormatted = date('Y-m-d', strtotime($RequestDate)); // Format the date as YYYY-MM-DD
        $StartDateFormatted = date('Y-m-d', strtotime($StartDate));
        $EndDateFormatted = date('Y-m-d', strtotime($EndDate));

        $sql = "INSERT INTO internship_request (student_id, sup_id, SSN, theme, description, StartDate, EndDate, period, RequestDate, Status) VALUES (:student_id, :sup_id, :SSN, :theme, :description, :StartDate, :EndDate, :period, :RequestDate, :Status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->bindParam(":sup_id", $sup_id, PDO::PARAM_INT);
        $stmt->bindParam(":SSN", $SSN, PDO::PARAM_STR);
        $stmt->bindParam(":theme", $theme, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":StartDate", $StartDateFormatted, PDO::PARAM_STR);
        $stmt->bindParam(":EndDate", $EndDateFormatted, PDO::PARAM_STR);
        $stmt->bindParam(":period", $period, PDO::PARAM_INT);
        $stmt->bindParam(":RequestDate", $RequestDateFormatted, PDO::PARAM_STR); // Use the formatted date
        $stmt->bindParam(":Status", $Status, PDO::PARAM_STR);

        return $stmt->execute();
    }


    public function getRequestID($student_id, $sup_id)
    {
        $sql = "SELECT id FROM internship_request WHERE ";
        $params = [];

        if ($student_id !== null) {
            $sql .= "student_id = :student_id";
            $params[':student_id'] = $student_id;
        }

        if ($sup_id !== null) {
            if ($student_id !== null) {
                $sql .= " AND ";
            }
            $sql .= "sup_id = :sup_id";
            $params[':sup_id'] = $sup_id;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn(0);
    }


    public function getRequestsByStudent($student_id)
    {
        $sql = "SELECT * FROM internship_request WHERE student_id = :student_id AND Status != '8'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCompletedRequestsByStudent($student_id)
    {
        $sql = "SELECT * FROM internship_request WHERE student_id = :student_id AND Status = '8'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRequestsBySupervisor($sup_id)
    {
        $sql = "SELECT * FROM internship_request WHERE sup_id = :sup_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":sup_id", $sup_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getRequest($id)
    {
        $sql = "SELECT * FROM internship_request WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateRequest($request_id, $SSN, $theme, $description, $StartDate, $EndDate, $period, $RequestDate, $Status)
    {
        $sql = "UPDATE internship_request SET SSN = :SSN, theme = :theme, description = :description, StartDate = :StartDate, EndDate = :EndDate, period = :period, RequestDate = :RequestDate, Status = :Status WHERE id = :request_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":request_id", $request_id, PDO::PARAM_INT);
        $stmt->bindParam(":SSN", $SSN, PDO::PARAM_STR);
        $stmt->bindParam(":theme", $theme, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":StartDate", $StartDate, PDO::PARAM_STR);
        $stmt->bindParam(":EndDate", $EndDate, PDO::PARAM_STR);
        $stmt->bindParam(":period", $period, PDO::PARAM_INT);
        $stmt->bindParam(":RequestDate", $RequestDate, PDO::PARAM_STR);
        $stmt->bindParam(":Status", $Status, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function requestingEligibility($id){
        $sql = "SELECT status FROM internship_request WHERE student_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
    
        if ($result) {
            $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
            foreach ($statuses as $status) {
                if (in_array($status, array(1, 2, 3, 4, 5, 6, 7))) {
                    return false;
                }
            }
    
            return true;
        }
    }
    
    public function deleteRequest($request_id)  
    {
        $sql = "DELETE FROM internship_request WHERE id = :request_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":request_id", $request_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>