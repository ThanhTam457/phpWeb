<?php

class Bill {
    // attributes
    public $conn;

    // methods
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTotalEarnings (){
        $sql = "SELECT SUM(total_pay_amount) as totalEarnings
                FROM bills";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        return $results['totalEarnings'];
    }
}

?>