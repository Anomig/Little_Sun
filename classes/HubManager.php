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
        $stmt = $this->pdo->query("SELECT * FROM employees WHERE function = 'manager'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addManager($firstname, $lastname, $email, $password, $function, $hub_location/* , $hub_tasks */)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO employees (firstname, lastname, email, password, function, location_id/* , task_id */) VALUES (?,?,?,?,?,?/* ,? */)";
        // var_dump($hub_location);
        $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$firstname, $lastname, $email, $hashed_password, 'manager', $hub_location/* , $hub_tasks *//* , NULL */]);
    }

    public function resetPassword($email, $new_password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE email = ?");
        $stmt->execute([$email]);
        $manager = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$manager) {
            return false;
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("UPDATE employees SET password = ? WHERE email = ?");
        $stmt->execute([$hashed_password, $email]);

        return true;
    }
}

    

    // // Voeg deze methode toe om alle taken op te halen
    // public function getTasks()
    // {
    //     $sql = "SELECT * FROM `hub_tasks`";
    //     $stmt = $this->pdo->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Andere methoden van de klasse hieronder...
