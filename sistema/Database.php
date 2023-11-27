<?php

class Database {
    private $host = 'host.docker.internal:3333';
    private $user = 'root';
    private $password = 'root';
    private $database = 'mysql01';

    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
?>
