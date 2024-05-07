<!DOCTYPE html>
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
    <?php include_once("nav.inc.php"); ?>
    <a href="admin_add_manager.php">Add manager</a>
    <a href="admin_tasks.php">Tasks</a>
    <a href="admin_locations.php">Locations</a>

    <div class="log_out">
        <div>🔴</div>
        <a href="logout.php">Log out</a>
    </div>
</body>

</html>