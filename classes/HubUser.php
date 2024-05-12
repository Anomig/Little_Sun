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

    public function setProfilePicture($profile_picture)
    {
        $this->profile_picture = $profile_picture;
    }

    public function save()
    {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO hub_users (firstname, lastname, email, password, profile_picture) VALUES (?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->firstname, $this->lastname, $this->email, $hashed_password, $this->profile_picture]);
    }

    // Voeg deze methode toe om alle taken op te halen
    public function getTasks()
    {
        $sql = "SELECT * FROM `hub_tasks`";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM hub_users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($firstname, $lastname, $email, $password, $profile_picture)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO hub_users (firstname, lastname, email, password, profile_picture) VALUES (?,?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email, $hashed_password, $profile_picture]);
    }
}
