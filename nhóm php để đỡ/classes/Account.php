<?php

class Account {
    // attributes
    public $conn;

    // methods
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTotalAccounts (){
        $sql = "SELECT COUNT(*) as totalAccounts
                FROM accounts";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        return $results['totalAccounts'];
    }
}

?>