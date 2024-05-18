<?php
//error testing
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//include_once(__DIR__ . "/classes/db.php"); oude databank
//nieuwe databank
include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubManager.php");

$pdo = Data::getConnection();
$hubManager = new HubManager($pdo);

$locations = []; // Array om locaties op te slaan

try {
    // Query om locaties op te halen
    $stmt = $pdo->query("SELECT id, name, country FROM hub_location");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

// Variabelen voor foutmelding en popup-melding
$error = "";
$popupMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formuliergegevens ophalen
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $profile_picture = $_POST['profile_picture'];
    $hub_location = $_POST['hub_location'];
    // echo "selected hub location:" . $hub_location;
    try {
        // Controleren of het e-mailadres al bestaat in de database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Het e-mailadres bestaat al, toon een foutmelding aan de gebruiker
            $error = "This e-mail adress is already being used.";
        } else {
            // Het e-mailadres bestaat niet, voer de registratie uit
            $hubManager->addManager($firstname, $lastname, $email, $password,"manager",$hub_location,$task_id);
            // $popupMessage = "New manager added!";
        }
    } catch (PDOException $e) {
        $error = "There has been an error, please reload the page.";
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <script>
        // JavaScript voor de popup-melding en redirect
        window.onload = function() {
            <?php if (!empty($popupMessage)) : ?>
                alert("<?php echo $popupMessage; ?>");
                window.location.href = "admin_dashboard.php"; // Redirect naar het admin dashboard
            <?php endif; ?>
        };
    </script>
</head>

<body>
    <?php include_once("admin.nav.inc.php"); ?>

    <h1>Add new HubManagers:</h1>

    <?php if (!empty($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="bg-slate-100 p-1">
        <form action="" method="post">
            <div class="p-2">
                <label for="firstname" class="text-slate-700">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-2">
                <label for="lastname" class="text-slate-700">Lastname</label>
                <input type="text" name="lastname" id="lastname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-3">
                <label for="email" class="text-slate-700">Email</label>
                <input type="text" name="email" id="email" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-4">
                <label for="password" class="text-slate-700">Password</label>
                <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <!-- <div class="p-5">
                <label for="profile-picture" class="text-slate-700">Profile picture</label>
                <input type="file" name="profile_picture" id="profile_picture" class="border-solid border-slate-20 border-2 rounded" />
            </div> -->

            <div class="p-6">
                <label for="hub_location" class="text-slate-700">Hub location</label>
                <select name="hub_location" id="hub_location" class="border-solid border-slate-20 border-2 rounded">
                    <option value="">Select a location</option> <!-- Standaard 'niet-actieve' optie toegevoegd -->
                    <?php foreach ($locations as $location) : ?>
                        <option value="<?php echo htmlspecialchars($location['id']); ?>">
                            <?php echo htmlspecialchars($location['name'] . ', ' . $location['country']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="p-2">
                <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Add Hub Manager" />
            </div>
        </form>
    </div>

    <div class="flex flex-row flex-wrap gap-1 p-2">
</body>

</html>
