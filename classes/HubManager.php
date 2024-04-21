<?php 

class HubManager{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function addManager($firstname, $lastname, $email, $password, $profile_picture, $hub_location){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO hub_managers (firstname, lastname, email, password, profile_picture, hub_location) VALUES (?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email, $hashed_password, $profile_picture, $hub_location]);
    }

}