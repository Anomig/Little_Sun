<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Include necessary classes
include_once(__DIR__ . "/classes/Data.php");
include_once(__DIR__ . "/classes/HubManager.php");

$pdo = Data::getConnection();
$hubManager = new HubManager($pdo);

$locations = []; // Array om locaties op te slaan
$tasks = []; // Array om taken op te slaan

try {
    // Query om locaties op te halen
    $stmt = $pdo->query("SELECT id, name, country FROM hub_location");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query om taken op te halen
    $stmt = $pdo->query("SELECT * FROM hub_tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

// Variabelen voor foutmelding en popup-melding
$error = "";
$popupMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Formuliergegevens ophalen
    switch ($action) {
        case 'add_manager':
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hub_location = $_POST['hub_location'];

            try {
                // Controleren of het e-mailadres al bestaat in de database
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE email = ?");
                $stmt->execute([$email]);
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    $error = "This e-mail address is already being used.";
                } else {
                    $hubManager->addManager($firstname, $lastname, $email, $password, "manager", $hub_location);
                    $_SESSION['popupMessage'] = "New manager added!";
                    header('Location: admin_dashboard.php');
                    exit();
                }
            } catch (PDOException $e) {
                $error = "There has been an error, please reload the page.";
            }
            break;

        case 'add_task':
            $name = $_POST['task_name'];
            $description = $_POST['task_description'];
            if (addTask($name, $description)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Er is een fout opgetreden bij het toevoegen van de taak.";
            }
            break;

        case 'add_location':
            $name = $_POST['name'];
            $country = $_POST['country'];
            if (addLocation($name, $country)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Er is een fout opgetreden bij het toevoegen van de locatie.";
            }
            break;

        case 'reset_password':
            $email = $_POST['email'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                $error = "De nieuwe wachtwoorden komen niet overeen.";
            } else {
                $resetResult = $hubManager->resetPassword($email, $new_password);
                if ($resetResult) {
                    $popupMessage = "Wachtwoord succesvol gereset.";
                } else {
                    $error = "Er is een fout opgetreden bij het resetten van het wachtwoord.";
                }
            }
            break;
    }
}

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

// Functie om een locatie toe te voegen
function addLocation($name, $country)
{
    $conn = Data::getConnection();
    $sql = "INSERT INTO hub_location (name, country) VALUES (:name, :country)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
    return $stmt->execute();
}
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
        window.onload = function() {
            <?php if (isset($_SESSION['popupMessage'])) : ?>
                alert("<?php echo $_SESSION['popupMessage']; unset($_SESSION['popupMessage']); ?>");
                window.location.href = "admin_dashboard.php";
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <?php include_once("admin.nav.inc.php"); ?>
    <div class="body">
        <div class="form-container">
            <!-- ADD MANAGER -->
            <div class="add-hub-managers">
                <h2>Add new hub-managers:</h2>
                <?php if (!empty($error)) : ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="" method="post">
                    <input type="hidden" name="action" value="add_manager">
                    <div class="p-2">
                        <label for="firstname" class="text-slate-700">Firstname</label>
                        <input type="text" name="firstname" id="firstname" class="border-solid border-slate-20 border-2 rounded" required />
                    </div>
                    <div class="p-2">
                        <label for="lastname" class="text-slate-700">Lastname</label>
                        <input type="text" name="lastname" id="lastname" class="border-solid border-slate-20 border-2 rounded" required />
                    </div>
                    <div class="p-3">
                        <label for="email" class="text-slate-700">Email</label>
                        <input type="email" name="email" id="email" class="border-solid border-slate-20 border-2 rounded" required />
                    </div>
                    <div class="p-4">
                        <label for="password" class="text-slate-700">Password</label>
                        <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" required />
                    </div>
                    <div class="p-6">
                        <label for="hub_location" class="text-slate-700">Hub location</label>
                        <select name="hub_location" id="hub_location" class="border-solid border-slate-20 border-2 rounded" required>
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
            <!-- EINDE ADD MANAGER -->

            <!-- Task toevoegen -->
            <div class="add-hub-managers">
                <h2>Add new task</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="action" value="add_task">
                    <label for="task_name">Task name:</label>
                    <input type="text" id="task_name" name="task_name" required><br>
                    <label for="task_description">Task description:</label>
                    <textarea id="task_description" name="task_description" required></textarea><br>
                    <button type="submit">Add task</button>
                </form>
            </div>
            <!-- EINDE Task toevoegen -->

            <!-- LOCATIE toevoegen -->
            <div class="location add-hub-managers">
                <h2>Add new location</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" name="action" value="add_location">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required><br>
                    <label for="country">Country:</label>
                    <select name="country" id="country" required>
                        <option value="">Select a country</option>
                        <?php
                        $countries = array("Zambia");
                        foreach ($countries as $country) {
                            echo "<option value=\"$country\">$country</option>";
                        }
                        ?>
                    </select><br>
                    <button type="submit">Add location</button>
                </form>
            </div>
            <!-- EINDE LOCATIE toevoegen -->

            <!-- Reset Password -->
            <div class="add-hub-managers">
                <h2>Reset password</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="action" value="reset_password">
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" required><br>
                    <label for="new_password">New password:</label>
                    <input type="password" id="new_password" name="new_password" required><br>
                    <label for="confirm_password">Confirm New password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required><br>
                    <button type="submit">Reset password</button>
                </form>
            </div>
            <!-- EINDE Reset Password -->
        </div>
    </div>
</body>
</html>
