<?php
require_once(__DIR__ . "/classes/Data.php");

function addLocation($name, $country)
{
    $conn = Data::getConnection(); 
    $sql = "INSERT INTO hub_location (name, country) VALUES (:name, :country)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
    return $stmt->execute();
}

// Functie om een locatie te bewerken
function editLocation($id, $name, $country)
{
    $conn = Data::getConnection(); 
    $sql = "UPDATE hub_location SET name = :name, country = :country WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':country', $country);
    return $stmt->execute();
}

function deleteLocation($location_id)
{
    $conn = Data::getConnection(); 

    try {
        $conn->beginTransaction();

        $sql = "UPDATE employees SET location_id = NULL WHERE location_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $location_id);
        $stmt->execute();

        $sql = "DELETE FROM hub_location WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $location_id);
        $stmt->execute();

        $conn->commit();
        return true;
    } catch (PDOException $e) {

        $conn->rollBack();
        throw $e;
    }
}

try {

    $conn = Data::getConnection(); 

    $errorMessage = "";


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'add_location') {

        $name = $_POST['name'];
        $country = $_POST['country'];


        if (addLocation($name, $country)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $errorMessage = "Er is een fout opgetreden bij het toevoegen van de locatie.";
        }
    }


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'edit_location') {

        $id = $_POST['location_id'];
        $name = $_POST['edit_name'];
        $country = $_POST['edit_country'];


        if (editLocation($id, $name, $country)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $errorMessage = "Er is een fout opgetreden bij het bewerken van de locatie.";
        }
    }


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'delete_location') {

        $location_id = $_POST['location_id'];


        try {
            if (!deleteLocation($location_id)) {
                $errorMessage = "Er is een fout opgetreden bij het verwijderen van de locatie.";
            } else {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        } catch (PDOException $e) {
            $errorMessage = "Er is een fout opgetreden bij het verwijderen van de locatie: " . $e->getMessage();
        }
    }


    $sql = "SELECT * FROM hub_location";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$locations) {
        $locations = [];
    }
} catch (PDOException $e) {
    $errorMessage = "Fout: " . $e->getMessage();
}

$conn = null;

?><!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hublocaties Beheren</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/locations.css">
</head>

<body>
<?php include_once("admin.nav.inc.php"); ?>
<div class="content">
    <div class="location">
        <h3>Add new location</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="country">Country:</label>
            <select name="country" id="country" required>
                <option value="">Select a country</option>
                <?php
               
                $countries = array(
                    "Zambia"
                );

                
                foreach ($countries as $country) {
                    echo "<option value=\"$country\">$country</option>";
                }
                ?>
            </select><br>
            <input type="hidden" name="action" value="add_location">
            <button type="submit">Add location</button>
        </form>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>


    <h3>Existing locations</h3>
    <?php if (!empty($locations)) : ?>
        <?php foreach ($locations as $location) : ?>
            <div class="location">
                <p><strong>Name:</strong> <?php echo $location['name']; ?></p>
                <p><strong>Country:</strong> <?php echo $location['country']; ?></p>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                    <input type="hidden" name="action" value="edit_location">
                    <label for="edit_name_<?php echo $location['id']; ?>">Name:</label>
                    <input type="text" id="edit_name_<?php echo $location['id']; ?>" name="edit_name" value="<?php echo $location['name']; ?>">
                    <label for="edit_country_<?php echo $location['id']; ?>">Country:</label>
                    <select name="edit_country" id="edit_country_<?php echo $location['id']; ?>">
                        <?php foreach ($countries as $country) : ?>
                            <option value="<?php echo $country; ?>" <?php if ($location['country'] === $country) echo 'selected'; ?>><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Save</button>
                </form>

              
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                    <input type="hidden" name="action" value="delete_location">
                    <button type="submit">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No locations found.</p>
    <?php endif; ?>
</div>


<script>
    function editLocation(locationId) {

        console.log("Bewerken van locatie met ID:", locationId);
    }
</script>
</body>

</html>
