<?php
session_start();

include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubManager.php");

function loginAsManager($username, $password, $conn) {
    $sql = "SELECT * FROM hub_managers WHERE email = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        return true;
    } else {
        return false;
    }
}

function logoutAsManager() {
    unset($_SESSION['admin_logged_in']);
}

$pdo = Db::getConnection();
$hubManager = new HubManager($pdo);

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] === 'reset_password') {
        // Hier voeg je de logica toe om het wachtwoord te resetten
        // Dit kan bijvoorbeeld een e-mail zijn met een reset-link of een ander proces voor wachtwoordherstel
        $reset_email = $_POST['reset_email'];
        $new_password = $_POST['new_password'];
        // Voeg hier de code toe om het wachtwoord te resetten
        $error_message = "Password reset email sent successfully."; // Voorbeeldmelding, pas dit aan afhankelijk van je implementatie
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager 🔵 - Reset Password</title>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <h1>Reset Password</h1>

    <div class="bg-slate-100 p-1">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php if(isset($error_message)): ?>
                <div class="success"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="p-3">
                <label for="reset_email" class="text-slate-700">Email</label>
                <input
                    type="text"
                    name="reset_email"
                    id="reset_email"
                    class="border-solid border-slate-20 border-2 rounded"
                />
            </div>

            <div class="p-4">
                <label for="new_password" class="text-slate-700">New Password</label>
                <input
                    type="password"
                    name="new_password"
                    id="new_password"
                    class="border-solid border-slate-20 border-2 rounded"
                />
            </div>

            <div class="p-2">
                <input
                    type="hidden"
                    name="action"
                    value="reset_password"
                />
                <input
                    class="cursor-pointer p-2 rounded text-white font-bold bg-green-600"
                    type="submit"
                    value="Reset Password"
                />
            </div>
        </form>
    </div>

</body>
</html>
