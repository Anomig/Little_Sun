<?php
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Db::getConnection();
$hubUser = new HubUser($pdo);

// Controleer of het formulier is verzonden en voeg dan de gebruiker toe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formuliergegevens ophalen
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_picture = $_POST['profile_picture'];

    // Voeg de gebruiker toe met behulp van de klasse
    $addResult = $hubUser->addUser($firstname, $lastname, $email, $password, $profile_picture);
}

// Haal alle gebruikers op om weer te geven
$workers = $hubUser->getUsers();

// Controleer of de taak aan een gebruiker moet worden toegewezen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign_task"])) {
    $task_id = $_POST["task_id"];
    $user_id = $_POST["user_id"];

    try {
        // Update de taak met de toegewezen gebruiker
        $sql = "UPDATE `hub_tasks` SET `assigned_to` = :user_id WHERE `id` = :task_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->execute();
        echo "Task successfully assigned to the user.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun</title>

  <link rel="stylesheet" href="styles/style.css">
  <style>
    body {
      margin: 25px;
    }
  </style>
</head>

<body>
  <?php include_once("nav.inc.php"); ?>


  <div class="index_title">
    <h1>Add new users! </h1>

    <div class="log_out">

      <div>🔵</div>
      <div>
        <a href="logout.php">Log out</a>
      </div>
    </div>

  </div>


  <div class="bg-slate-100 p-1">
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
        <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Add User" />
      </div>
    </form>
  </div>

  <div class="flex flex-row flex-wrap gap-1 p-2">

    <h1>Workers in Hub</h1>

    <!-- oplijsting user informatie -->
    <div class="workers">

      <ul>
        <?php foreach ($workers as $worker) : ?>
          <li>
            <div><img style="width: 50px;" src="https://thispersondoesnotexist.com" alt="Profile Picture"></div>
            <div><?php echo $worker['firstname'] . ' ' . $worker['lastname']; ?></div>
            <!-- <div><?php echo $worker['task']; ?></div> -->

          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <h2>All Tasks</h2>
    <ul>
      <?php
      // Haal alle taken op
      $tasks = $hubUser->getTasks();

      // Haal alle gebruikers op
      $allUsers = $hubUser->getUsers();

      // Toon de taken en voeg een dropdown-menu toe voor het toewijzen van de taak aan een gebruiker
      foreach ($tasks as $task) {
        echo "<li>" . $task['task_name'] . " - " . $task['task_description'] . " - Assigned to: ";
        echo "<select name='assign_user' onchange='assignTask(this.value, " . $task['id'] . ")'>";
        echo "<option value=''>Not Assigned</option>";
        foreach ($allUsers as $user) {
          $selected = ($task['assigned_to'] == $user['id']) ? "selected" : "";
          echo "<option value='" . $user['id'] . "' " . $selected . ">" . $user['firstname'] . " " . $user['lastname'] . "</option>";
        }
        echo "</select></li>";
      }
      ?>
    </ul>

</body>
<script>
  // JavaScript-functie om de taak toe te wijzen aan een gebruiker via AJAX
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
  }
</script>

</html>