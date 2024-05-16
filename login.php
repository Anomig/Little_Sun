<?php


echo password_hash('1234', PASSWORD_DEFAULT);



session_start();
include_once(__DIR__ . "/classes/Data.php");


// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Controleer of de e-mail en het wachtwoord zijn ingevuld
    if (!empty($email) && !empty($password)) {
        // Maak gebruik van de databaseverbinding via de Data klasse
        $db = Data::getConnection();

        // Zoek de gebruiker op in de database
        $sql = "SELECT * FROM employees WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of de gebruiker is gevonden
        if ($user) {
            // Verifieer het wachtwoord
            if (password_verify($password, $user['password'])) {
                // Start een sessie en sla de gegevens op
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['function'];

                // Stuur de gebruiker naar de juiste indexpagina
                if ($user['function'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($user['function'] == 'manager') {
                    header("Location: manager_index.php");
                } else {
                    header("Location: user_index.php");
                }
                exit;
            } else {
                $error_message = "Ongeldig wachtwoord.";
            }
        } else {
            $error_message = "Geen gebruiker gevonden met dit e-mailadres.";
        }
    } else {
        $error_message = "Vul alstublieft zowel een e-mailadres als een wachtwoord in.";
    }
}

?><!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <title>Little Sun</title>
  <link rel="stylesheet" href="styles/login.css">
</head>

<body>

  <div class="logo"><img src="images/little_sun_logo.png" alt=""></div>

  <div class="loginContainer">
    <div class="formContainer form--login">
      <form action="" method="post">
        <h2 class="form__title">Log in ☀️</h2>

        <?php if (isset($error_message)) : ?> 
          <div class="form__error">
            <p><?php echo htmlspecialchars($error_message); ?></p> <!-- error message laten zien -->
          </div>
        <?php endif; ?>

        <div class="form__field">
          <label for="email">Email</label>
          <input type="text" name="email" required> 
        </div>
        <div class="form__field">
          <label for="password">Password</label>
          <input type="password" name="password" required> 
        </div>

        <div class="form__field">
          <input type="hidden" name="action" value="login"> 
          <input type="submit" value="Log in" class="btn btn--primary">
        </div>
      </form>
    </div>
  </div>
</body>

</html>
