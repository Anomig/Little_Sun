<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun ☀️</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    
</head>

<body>
<?php include_once("nav.inc.php"); ?>
    <h1>Welcome to Little Sun☀️</h1>

    <p>Choose your role:</p>

    <!-- Buttons for each role -->
    <form method="post" action="admin_login.php"> <!--admin_login.php is the admin login page -->
        <input type="submit" value="Admin Login 🔴">
    </form>

    <form method="post" action="manager_login.php"> <!--manager_login.php is the manager login page -->
        <input type="submit" value="Manager Login 🔵">
    </form>

    <form method="post" action="user_login.php"> <!--user_login.php is the user login page -->
        <input type="submit" value="User Login 🟢">
    </form>
</body>

</html>