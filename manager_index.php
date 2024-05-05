<?php
/*include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubUser.php");

    $pdo = Db::getConnection();

    $hubUser = new HubUser($pdo);

$hubUser = new HubUser($pdo);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Formuliergegevens ophalen
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_picture = $_POST['profile_picture'];
    

    // Manager toevoegen met behulp van de klasse
    $hubUser->addUser($firstname, $lastname, $email, $password, $profile_picture);
}*/

?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun</title>

  <link rel="stylesheet" href="styles/style.css">
  <style>
    body {
      margin: 25px; /* Voeg een marge van 20 pixels toe aan alle zijden van het body-element */
    }
  </style>
</head>

<body >
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
</body>

</html>