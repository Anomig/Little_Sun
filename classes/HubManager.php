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
    
    public function resetPassword($email, $new_password)
    {
        // Controleer eerst of de manager met het opgegeven e-mailadres bestaat
        $stmt = $this->pdo->prepare("SELECT * FROM hub_managers WHERE email = ?");
        $stmt->execute([$email]);
        $manager = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$manager) {
            return false; // Manager met opgegeven e-mailadres niet gevonden
        }

        // Hash het nieuwe wachtwoord
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update het wachtwoord in de database
        $stmt = $this->pdo->prepare("UPDATE hub_managers SET password = ? WHERE email = ?");
        $stmt->execute([$hashed_password, $email]);

        return true; // Wachtwoord succesvol gereset
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
