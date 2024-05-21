<?php class HubUser
{
    private $pdo;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $profile_picture;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // public function setProfilePicture($profile_picture)
    // {
    //     $this->profile_picture = $profile_picture;
    // }

    public function save()
    {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO hub_users (firstname, lastname, email, password/* , profile_picture */) VALUES (?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->firstname, $this->lastname, $this->email, $hashed_password, $this->profile_picture]);
    }

    // Voeg deze methode toe om alle taken op te halen
    public function getTasks()
    {
        try {
            // Bereid de SQL-query voor
            $stmt = $this->pdo->prepare("SELECT * FROM hub_tasks");
            
            // Voer de query uit
            $stmt->execute();

            // Haal alle rijen op als een associatieve array
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retourneer de taken
            return $tasks;
        } catch (PDOException $e) {
            // Vang eventuele databasefouten op en geef ze weer
            echo "Fout bij het ophalen van taken: " . $e->getMessage();
            return []; // Retourneer een lege array als er een fout optreedt
        }
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM employees WHERE typeOfUser = 'user'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($firstname, $lastname, $email, $password, $typeOfUser, $hub_task)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO employees (firstname, lastname, email, password, typeOfUser, task_id) VALUES (?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email, $hashed_password, $typeOfUser, $hub_task]);
    }
}
