<?php

class Reservation {
    // attributes
    public $conn;

    // methods
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getReservation($limit = 10, $offset = 0, $status = 0){
        $sql = "SELECT bt.*, acc.F_name, acc.L_name, acc.phone_num
                FROM booking_tables bt JOIN accounts acc ON bt.custom_id=acc.id 
                WHERE bt.status=?
                LIMIT ?,?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $status, $offset, $limit);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function getCountReservation(){
        $sql = "SELECT SUM(CASE WHEN status=1 THEN 1 END) AS num_confirm,
                       SUM(CASE WHEN status=0 THEN 1 END) AS num_unconfirm
                FROM booking_tables";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        $results["num_confirm"] = (int)$results["num_confirm"];
        $results["num_unconfirm"] = (int)$results["num_unconfirm"];

        return $results;
    }

    public function confirmReservation($id){
        $sql = "UPDATE booking_tables
                SET status=1
                WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function getTotalTableBooked(){
        $sql = "SELECT count(*) as total_table_booked
                FROM booking_tables";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        return $results['total_table_booked'];
    }
}

?>