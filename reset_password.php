<?php
// Databaseverbinding en HubManager klasse inclusief
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubManager.php");

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleer of het e-mailadres is ingevoerd
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Maak verbinding met de database
        $pdo = Db::getConnection();
        $hubManager = new HubManager($pdo);

        // Controleer of de manager met het opgegeven e-mailadres bestaat
        $manager = $hubManager->getUserByEmail($email);

        if ($manager) {
            // Genereer een nieuw wachtwoord
            $newPassword = generateRandomPassword();

            // Update het wachtwoord van de manager in de database
            $hubManager->updatePassword($manager['id'], $newPassword);

            // Stuur het nieuwe wachtwoord naar de manager (hier kun je een e-mail sturen)

            // Redirect naar een succespagina of geef een succesbericht weer
            header("Location: reset_password_success.php");
            exit();
        } else {
            // Manager met het opgegeven e-mailadres bestaat niet
            $error_message = "Geen manager gevonden met dat e-mailadres.";
        }
    } else {
        // E-mailadres is niet ingevoerd
        $error_message = "Voer alstublieft uw e-mailadres in.";
    }
}

// Functie om een ​​willekeurig wachtwoord te genereren
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Wachtwoord</title>
</head>

<body>
    <h1>Reset Wachtwoord</h1>

    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="email">Voer uw e-mailadres in:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Reset Wachtwoord</button>
    </form>
</body>

</html>
