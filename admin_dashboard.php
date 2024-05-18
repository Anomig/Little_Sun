<?php 

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}


?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include_once("admin.nav.inc.php"); ?>
    <a href="admin_add_manager.php">Add manager</a>
    <a href="admin_tasks.php">Tasks</a>
    <a href="admin_locations.php">Locations</a>

</body>

</html>