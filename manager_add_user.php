<?php
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Db::getConnection();
$hubUser = new HubUser($pdo);

$error = "";
$popupMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formuliergegevens ophalen
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $profile_picture = $_POST['profile_picture'];
  // $hub_location = $_POST['hub_location'];

  try {
    // Controleren of het e-mailadres al bestaat in de database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM hub_users WHERE email = ?");
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
      // Het e-mailadres bestaat al, toon een foutmelding aan de gebruiker
      $error = "This e-mail adress is already being used.";
    } else {
      // Het e-mailadres bestaat niet, voer de registratie uit
      $hubUser->addUser($firstname, $lastname, $email, $password, $profile_picture);
      $popupMessage = "New user added!";
    }
  } catch (PDOException $e) {
    $error = "There has been an error, please reload the page.";
  }
}
?><!DOCTYPE html>
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
        <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" name="add_user" value="Add User" />
      </div>
    </form>
  </div>