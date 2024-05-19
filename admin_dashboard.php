<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

//reset password
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
//einde reset password


// ADD MANAGER

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
            $hubManager->addManager($firstname, $lastname, $email, $password, "manager", $hub_location/* ,$task_id */);
            // $popupMessage = "New manager added!";
            header('location: admin_dashboard.php');
        }
    } catch (PDOException $e) {
        $error = "There has been an error, please reload the page.";
    }
} //EINDE ADD MANAGER



//TASK TOEVOEGEN
require_once(__DIR__ . "/classes/data.php");

// Functie om een taak toe te voegen
function addTask($name, $description)
{
    $conn = Data::getConnection();
    $sql = "INSERT INTO hub_tasks (task_name, task_description) VALUES (:task_name, :task_description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_name', $name);
    $stmt->bindParam(':task_description', $description);
    return $stmt->execute();
}

try {
    $conn = Data::getConnection();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add_task':
                    $name = $_POST['task_name'];
                    $description = $_POST['task_description'];
                    if (addTask($name, $description)) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Er is een fout opgetreden bij het toevoegen van de taak.<br>";
                    }
                    break;
            }
        }
    }

    $sql = "SELECT * FROM hub_tasks";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
} //EINDE TASK TOEVOEGEN



//LOCATIE TOEVOEGEN

// Functie om een locatie toe te voegen
function addLocation($name, $country)
{
    $conn = Data::getConnection(); // Databaseverbinding ophalen van de Db klasse
    $sql = "INSERT INTO hub_location (name, country) VALUES (:name, :country)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
    return $stmt->execute();
}
try {
    // Maak verbinding met de database
    $conn = Data::getConnection(); // Databaseverbinding ophalen van de Db klasse

    // Als er een actie is om een locatie toe te voegen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add_location') {
        // Locatiegegevens ophalen uit het formulier
        $name = $_POST['name'];
        $country = $_POST['country'];

        // Locatie toevoegen aan de database
        if (addLocation($name, $country)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Er is een fout opgetreden bij het toevoegen van de locatie.<br>";
        }
    }


    // Haal alle hublocaties op uit de database
    $sql = "SELECT * FROM hub_location";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
}
//EINDE LOCATIE TOEVOEGEN

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/column.css">

    <script>
        //ADD MANAGER
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
    <div class="body">

        <div class="form-container"> <!-- Container toegevoegd -->
            <!-- ADD MANAGER -->
            <div class="add-hub-managers">
                <h2>Add new <br /> Hub-Managers:</h2>

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

                        <div class="p-6">
                            <label for="hub_location" class="text-slate-700">Hub location</label>
                            <select name="hub_location" id="hub_location" class="border-solid border-slate-20 border-2 rounded">
                                <option value="">Select a location</option>
                                <?php foreach ($locations as $location) : ?>
                                    <option value="<?php echo htmlspecialchars($location['id']); ?>">
                                        <?php echo htmlspecialchars($location['name'] . ', ' . $location['country']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="p-2">
                            <button type="submit">Add Hub Manager</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- EINDE ADD MANAGER -->

            <!-- Task toevoegen -->
            <div class="add-hub-managers">
                <h2>Add new Task</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="task_name">Task Name:</label>
                    <input type="text" id="task_name" name="task_name" required><br>
                    <label for="task_description">Task Description:</label>
                    <textarea id="task_description" name="task_description" required></textarea><br>
                    <input type="hidden" name="action" value="add_task">
                    <button type="submit">Add Task</button>
                </form>
            </div>
            <!-- einde Task toevoegen -->

            <!-- LOCATIE toevoegen -->
            <div class="location add-hub-managers">
                <h2>Nieuwe locatie toevoegen</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="name">Naam:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="country">Land:</label>
                    <select name="country" id="country" required>
                        <option value="">Select a country</option>
                        <?php
                        // Array met landen
                        $countries = array(
                            "Zambia"
                        );

                        // Opties voor landen uit de array genereren
                        foreach ($countries as $country) {
                            echo "<option value=\"$country\">$country</option>";
                        }
                        ?>
                    </select><br>
                    <input type="hidden" name="action" value="add_location">
                    <button type="submit">Toevoegen</button>
                </form>
            </div>
            <!-- EINDE LOCATIE toevoegen -->



        </div>

        <div class="add-hub-managers">
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
        </div>
    </div>
</body>

</html>