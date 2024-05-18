//NIET NODIG
<?php
session_start();

include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Db::getConnection();
$hubUser = new HubUser($pdo);

// Functie om in te loggen als beheerder
function loginAsAdmin($username, $password, $conn)
{
    $sql = "SELECT * FROM hub_users WHERE email = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleer of de gebruiker bestaat en het wachtwoord overeenkomt
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        return true;
    } else {
        return false;
    }
}

// Functie om uit te loggen als beheerder
function logoutAsAdmin()
{
    unset($_SESSION['admin_logged_in']);
}

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Controleer de inloggegevens
        if (loginAsAdmin($username, $password, $pdo)) {
            // Als de inloggegevens geldig zijn, doorsturen naar de gebruikersdashboardpagina
            header("Location: user_index.php");
            exit();
        } else {
            // Als de inloggegevens ongeldig zijn, geef een foutmelding
            $error_message = "Invalid email or password.";
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <title>User 🟢 - Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
            padding: 0;
        }
        h1 {
            margin-top: 40px;
        }
        .profiles {
            margin-top: 100px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 20px;
        }
        article {
            margin-bottom: 20px;
            background-color: #f2f2f2;
            padding: 50px;
            border-radius: 8px;
        }
        .profile-pic {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include_once("nav.inc.php"); ?>

<h1>Welcome user 🟢!<br> Please choose an account to log in:</h1>

<div class="bg-slate-100 p-1 container">
    <form action="" method="post">
        <?php if (isset($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="profiles">

            <!-- Inlogformulier voor beheerder -->
            <article>
                <div class="profile-pic">
                    <img src="https://thispersondoesnotexist.com" alt="Profile Picture" width="200">
                </div>
                <div class="p-3">
                    <label for="email" class="text-slate-700">Email</label>
                    <input type="text" name="username" id="email" class="border-solid border-slate-20 border-2 rounded" />
                </div>
                <div class="p-4">
                    <label for="password" class="text-slate-700">Password</label>
                    <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
                </div>
                <div class="p-2">
                    <input type="hidden" name="action" value="login" />
                    <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Login" />
                </div>
            </article>
        </div>
    </form>
</div>

</body>
</html>
