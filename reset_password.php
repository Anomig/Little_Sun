<?php
require_once(__DIR__ . "/classes/db.php");
require_once(__DIR__ . "/classes/HubManager.php");

$pdo = Db::getConnection();
$hubManager = new HubManager($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formuliergegevens ophalen
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Controleer of de nieuwe wachtwoorden overeenkomen
    if ($new_password !== $confirm_password) {
        echo "De nieuwe wachtwoorden komen niet overeen.";
        exit; // Stop de scriptuitvoering als de wachtwoorden niet overeenkomen
    }

    // Reset het wachtwoord met behulp van de klasse
    $resetResult = $hubManager->resetPassword($email, $new_password);
    if ($resetResult) {
        echo "Wachtwoord succesvol gereset.";
    } else {
        echo "Er is een fout opgetreden bij het resetten van het wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun ☀️</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    
</head>

<body>
<?php include_once("nav.inc.php"); ?>
    <h2>Reset Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>
