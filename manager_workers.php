<?php
include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);
$workers = $hubUser->getUsers();

$error = "";
$popupMessage = "";

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
  <?php include_once("manager.nav.inc.php"); ?>

  <div class="index_title">
    <h1>Workers in Hub</h1>

  </div>

  <div class="flex flex-row flex-wrap gap-1 p-2">




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