<?php
// Databasegegevens
// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "littlesun";

include_once('classes/db.php');

// Functie om een locatie toe te voegen
function addLocation($name, $country/* , $conn */)
{
    $conn = Db::getConnection(); // Databaseverbinding ophalen van de Db klasse
    $sql = "INSERT INTO hub_location (name, country) VALUES (:name, :country)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
    return $stmt->execute();
    // $sql = "INSERT INTO hub_location (name, country) VALUES (:name, :country)";
    // $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':name', $name);
    // $stmt->bindParam(':country', $country);
    // return $stmt->execute();
}

// Functie om een locatie te bewerken
function editLocation($id, $name, $country, $conn)
{
    $sql = "UPDATE hub_location SET name = :name, country = :country WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
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
    $conn = Db::getConnection(); // Databaseverbinding ophalen van de Db klasse
    // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Stel de foutmodus in op uitzonderingen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Als er een actie is om een locatie toe te voegen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add_location') {
        // Locatiegegevens ophalen uit het formulier
        $name = $_POST['name'];
        $country = $_POST['country'];

        // Locatie toevoegen aan de database
        if (addLocation($name, $country, $conn)) {
            // echo "Locatie succesvol toegevoegd.<br>";
        } else {
            echo "Er is een fout opgetreden bij het toevoegen van de locatie.<br>";
        }
    }

    // Als er een actie is om een locatie te bewerken
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'edit_location') {
        // Locatiegegevens ophalen uit het formulier
        $id = $_POST['location_id'];
        $name = $_POST['edit_name'];
        $country = $_POST['edit_country'];

        // Locatie bewerken in de database
        if (editLocation($id, $name, $country, $conn)) {
            // echo "Locatie succesvol bewerkt.<br>";
        } else {
            echo "Er is een fout opgetreden bij het bewerken van de locatie.<br>";
        }
    }

    // Als er een actie is om een locatie te verwijderen
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete_location') {
        // Locatie-ID ophalen uit het formulier
        $location_id = $_POST['location_id'];

        // Locatie verwijderen uit de database
        if (deleteLocation($location_id, $conn)) {
            // echo "Locatie succesvol verwijderd.<br>";
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de locatie.<br>";
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

// Verbinding sluiten
$conn = null;
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hublocaties Beheren</title>
    <link rel="stylesheet" href="styles/locations.css">
</head>

<body>
    <div class="location">
        <h3>Nieuwe locatie toevoegen</h3>
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

    <!-- Divs voor het weergeven van bestaande locaties -->
    <h3>Bestaande locaties</h3>
    <?php foreach ($locations as $location) : ?>
        <div class="location">
            <p><strong>Naam:</strong> <?php echo $location['name']; ?></p>
            <p><strong>Land:</strong> <?php echo $location['country']; ?></p>
            <!-- Formulier voor het bewerken van een locatie -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                <input type="hidden" name="action" value="edit_location">
                <label for="edit_name_<?php echo $location['id']; ?>">Naam:</label>
                <input type="text" id="edit_name_<?php echo $location['id']; ?>" name="edit_name" value="<?php echo $location['name']; ?>">
                <label for="edit_country_<?php echo $location['id']; ?>">Land:</label>
                <select name="edit_country" id="edit_country_<?php echo $location['id']; ?>">
                    <?php foreach ($countries as $country) : ?>
                        <option value="<?php echo $country; ?>" <?php if ($location['country'] === $country) echo 'selected'; ?>><?php echo $country; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Opslaan</button>
            </form>
            
            <!-- Formulier voor het verwijderen van een locatie -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                <input type="hidden" name="action" value="delete_location">
                <button type="submit">Verwijderen</button>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- JavaScript voor interactie -->
    <script>
        function editLocation(locationId) {
            // JavaScript voor het bewerken van een locatie
            // Voeg hier de logica toe om locaties te bewerken
            console.log("Bewerken van locatie met ID:", locationId);
        }
    </script>
</body>

</html>
