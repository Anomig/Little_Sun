<?php
class Calendar {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getEmployees() {
        $stmt = $this->pdo->query("SELECT id, firstname, lastname FROM employees");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLocations() {
        $stmt = $this->pdo->query("SELECT * FROM hub_location");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>