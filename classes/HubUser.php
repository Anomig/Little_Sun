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
        $sql = "SELECT * FROM hub_tasks";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM employees WHERE function = 'user'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($firstname, $lastname, $email, $password, $function, $hub_task)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO employees (firstname, lastname, email, password, function, task_id) VALUES (?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$firstname, $lastname, $email, $hashed_password, $function, $hub_task]);
    }
}
