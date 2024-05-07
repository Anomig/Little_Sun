<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun</title>
  <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
  <link rel="stylesheet" href="styles/style.css">
  <style>
    body {
      margin: 25px;
      /* Voeg een marge van 20 pixels toe aan alle zijden van het body-element */

    }
  </style>
</head>

<body>
  <?php include_once("nav.inc.php"); ?>


  <div class="index_title">
    <h1>Hi!</h1>



    <div class="log_out">

      <div>🟢</div>
      <div>
        <a href="logout.php">Log out</a>
      </div>

    </div>

  </div>
  <div class="log_out"><a href="time_off_user.php">Request time-off</a></div>