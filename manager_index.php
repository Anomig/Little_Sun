<?php


session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}



include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);


// $locations = []; // Array om locaties op te slaan

// try {
//     // Query om locaties op te halen
//     $stmt = $pdo->query("SELECT id, name, country FROM hub_location");
//     $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//     error_log("Database error: " . $e->getMessage());
// }

// Variabelen voor foutmelding en popup-melding
$error = "";
$popupMessage = "";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // Formuliergegevens ophalen
//   $firstname = $_POST['firstname'];
//   $lastname = $_POST['lastname'];
//   $email = $_POST['email'];
//   $password = $_POST['password'];
//   $profile_picture = $_POST['profile_picture'];
//   // $hub_location = $_POST['hub_location'];

//   try {
//     // Controleren of het e-mailadres al bestaat in de database
//     $stmt = $pdo->prepare("SELECT COUNT(*) FROM hub_users WHERE email = ?");
//     $stmt->execute([$email]);
//     $count = $stmt->fetchColumn();

//     if ($count > 0) {
//       // Het e-mailadres bestaat al, toon een foutmelding aan de gebruiker
//       $error = "This e-mail adress is already being used.";
//     } else {
//       // Het e-mailadres bestaat niet, voer de registratie uit
//       $hubUser->addUser($firstname, $lastname, $email, $password, $profile_picture);
//       $popupMessage = "New user added!";
//     }
//   } catch (PDOException $e) {
//     $error = "There has been an error, please reload the page.";
//   }
// }
$workers = $hubUser->getUsers();
// Variabeel om taken op te slaan
$tasks = [];

try {
  // Query om taken op te halen
  $stmt = $pdo->query("SELECT id, task_name FROM hub_tasks");
  $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun ☀️</title>
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/nav.css">
  <link rel="stylesheet" href="styles/style.css">

</head>

<body>
  <?php include_once("nav.inc.php"); ?>

  <!-- 
  <div class="index_title">
    <h1>Add new users! </h1> -->


  <div class="index_title">
    <div>
      <a href="manager_add_user.php">Add user</a>
      <a href="manager_workers.php">Workers in hub</a>
      <a href="manager_tasks.php">Tasks</a>
    </div>

    <div class="log_out">

      <div>🔵</div>
      <div>
        <a href="logout.php">Log out</a>
      </div>
    </div>

  </div>


  <!-- <div class="bg-slate-100 p-1">
    <form action="" method="post">
      <div class="p-2">
        <label for="firstname" class="text-slate-700">Firstname</label>
        <input type="text" name="firstname" id="firstname" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-2">
        <label for="lastname" class="text-slate-700">Lastname</label>
        <input type="text" name="lastname" id="lastname" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-3">
        <label for="email" class="text-slate-700">Email</label>
        <input type="text" name="email" id="email" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-4">
        <label for="password" class="text-slate-700">Password</label>
        <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-5">
        <label for="profile-picture" class="text-slate-700">Profile picture</label>
        <input type="file" name="profile_picture" id="profile_picture" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-2">
        <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" name="add_user" value="Add User" />
      </div>
    </form>
  </div> -->



    

</body>
<script>
  /*// JavaScript-functie om de taak toe te wijzen aan een gebruiker via AJAX
  function assignTask(userId, taskId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Vernieuw de pagina om de wijzigingen te zien
        location.reload();
      }
    };
    xhttp.open("GET", "assign_task.php?user_id=" + userId + "&task_id=" + taskId, true);
    xhttp.send();
  }*/
</script>

</html>