<?php
class DB {
    public $conn;
    // construct will create mysqli obj
    public function __construct($host, $user, $pw, $db) {
        $this->conn = new mysqli($host, $user, $pw, $db);
    }
    // getter to get the conn
    public function getConn() {
        return $this->conn;
    }
}