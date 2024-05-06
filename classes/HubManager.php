<?php

class HubManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getManagers()
    {
        $stmt = $this->pdo->query("SELECT * FROM hub_managers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addManager($firstname, $lastname, $email, $password, $profile_picture, $hub_location)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO hub_managers (firstname, lastname, email, password, profile_picture, hub_location) VALUES (?,?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email, $hashed_password, $profile_picture, $hub_location]);
    }


    // // Voeg deze methode toe om alle taken op te halen
    // public function getTasks()
    // {
    //     $sql = "SELECT * FROM `hub_tasks`";
    //     $stmt = $this->pdo->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Andere methoden van de klasse hieronder...
}
