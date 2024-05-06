<?php
// Start de sessie
session_start();

// Databasegegevens
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "littlesun";

// Functie om in te loggen als admin
function loginAsAdmin($username, $password, $conn)
{
    $sql = "SELECT * FROM hub_managers WHERE email = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Sessievariabele instellen om ingelogd te blijven
        $_SESSION['admin_logged_in'] = true;
        return true;
    } else {
        return false;
    }
}

// Functie om uit te loggen als admin
function logoutAsAdmin()
{
    // Sessievariabele vernietigen om uit te loggen
    unset($_SESSION['admin_logged_in']);
}

// Functie om een nieuwe gebruiker te registreren
function registerUser($firstname, $lastname, $email, $password, $conn)
{
    // Controleer eerst of de gebruiker al bestaat
    $sql_check = "SELECT * FROM hub_managers WHERE email = :email";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();
    $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        return false; // Gebruiker bestaat al
    }

    // Voeg de nieuwe gebruiker toe aan de database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO hub_managers (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    return $stmt->execute();
}

// Functie om een locatie toe te voegen
function addLocation($name, $address, $country, $description, $conn)
{
    $sql = "INSERT INTO hub_location (name, address, country, description) VALUES (:name, :address, :country, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

// Functie om een locatie te verwijderen
function deleteLocation($location_id, $conn)
{
    $sql = "DELETE FROM hub_location WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $location_id);
    return $stmt->execute();
}

try {
    // Maak verbinding met de database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Stel de foutmodus in op uitzonderingen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Controleren of het een POST-verzoek is om uit te loggen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'logout') {
        logoutAsAdmin();
        echo "Je bent uitgelogd als admin.<br>";
    }

    // Controleren of er een inlogpoging is
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'login') {
        // Inloggegevens ophalen
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Inloggen als admin
        if (loginAsAdmin($username, $password, $conn)) {
            echo "Je bent succesvol ingelogd als admin.<br>";
        } else {
            echo "Ongeldige inloggegevens voor admin.<br>";
        }
    }

    // Als er een actie is om een locatie toe te voegen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add_location') {
        // Locatiegegevens ophalen uit het formulier
        $name = $_POST['location_name'];
        $address = $_POST['location_address'];
        $country = $_POST['location_country'];
        $description = $_POST['location_description'];

        // Locatie toevoegen aan de database
        if (addLocation($name, $address, $country, $description, $conn)) {
            echo "Locatie succesvol toegevoegd.<br>";
        } else {
            echo "Er is een fout opgetreden bij het toevoegen van de locatie.<br>";
        }
    }

    // Als er een actie is om een locatie te verwijderen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete_location') {
        // Locatie-ID ophalen uit het formulier
        $location_id = $_POST['location_id'];

        // Locatie verwijderen uit de database
        if (deleteLocation($location_id, $conn)) {
            echo "Locatie succesvol verwijderd.<br>";
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de locatie.<br>";
        }
    }

    // Haal alle hublocaties op uit de database
    $sql = "SELECT * FROM hub_location";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $hub_locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

// Verbinding sluiten
$conn = null;

?><!DOCTYPE html>
<html>

<head>
    <title>Hublocaties Beheren</title>
</head>

<body>
    <?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) : ?>
        <h2>Inloggen als Admin</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Gebruikersnaam: <input type="text" name="username"><br>
            Wachtwoord: <input type="password" name="password"><br>
            <input type="hidden" name="action" value="login">
            <input type="submit" value="Inloggen">
        </form>
    <?php else : ?>
        <h2>Hublocaties Beheren</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Uitloggen">
        </form>

        <ul>
            <?php if (isset($hub_locations) && !empty($hub_locations)) : ?>
                <?php foreach ($hub_locations as $location) : ?>
                    <li>
                        <?php echo $location['name']; ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: inline;">
                            <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                            <input type="hidden" name="action" value="delete_location">
                            <input type="submit" value="Verwijderen">
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>Geen hublocaties gevonden.</li>
            <?php endif; ?>
        </ul>

        <h2>Hublocatie Toevoegen</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Naam: <input type="text" name="location_name"><br>
            Adres: <input type="text" name="location_address"><br>
            Land: <input type="text" name="location_country"><br>
            Beschrijving: <input type="text" name="location_description"><br>
            <input type="hidden" name="action" value="add_location">
            <input type="submit" value="Toevoegen">
        </form>
    <?php endif; ?>
</body>

</html>