<?php
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubManager.php");

$pdo = Db::getConnection();

$hubManager = new HubManager($pdo);

// $hubManager = new HubManager($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formuliergegevens ophalen
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $profile_picture = $_POST['profile_picture'];
  $hub_location = $_POST['hub_location'];

  // Manager toevoegen met behulp van de klasse
  $hubManager->addManager($firstname, $lastname, $email, $password, $profile_picture, $hub_location);

  header("Location: managers.php");
  exit();
}

// $managers = $hubManager->getManagers();
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun</title>
</head>

<body>
  <?php include_once("nav.inc.php"); ?>
  <h1>Registren</h1>

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
        <label for="profile-picture" class="text-slate-700">Profile piccture</label>
        <input type="file" name="profile_picture" id="profile_picture" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-6">
        <label for="hub-location" class="text-slate-700">Hub location</label>
        <input type="text" name="hub_location" id="hub_location" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-2">
        <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Registreer" />
      </div>
    </form>
  </div>




</body>

</html>