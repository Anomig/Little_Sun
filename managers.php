<?php
// managers.php

// Inclusie van de databaseklasse en de klasse voor Hub Manager
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubManager.php");

// Verbinding maken met de database
$pdo = Db::getConnection();
$hubManager = new HubManager($pdo);

// Alle managers ophalen
$managers = $hubManager->getManagers();

// Map waarin de afbeeldingen moeten worden opgeslagen
$imageDirectory = "images/profile_pictures";

// Loop door elke manager
// Loop door elke manager
foreach ($managers as $manager) {
    // Bestandsnaam van de afbeelding uit de database halen
    $imageName = $manager['profile_picture'];

    // Het pad waar de afbeelding moet worden opgeslagen op de server
    $sourcePath = "/images/profile_pictures/" . $imageName;
    $destinationPath = $imageDirectory . $imageName;

    // De afbeelding kopiëren naar de map "images"
    if (file_exists($sourcePath)) {
        copy($sourcePath, $destinationPath);
    } else {
        echo "Het bestand $sourcePath bestaat niet.";
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managers</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <style>
        .managers {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .manager {
            width: 300px;
            margin: 20px 20px;
        }
    </style>
</head>

<body>
    <?php include_once("nav.inc.php"); ?>
    <h2>Managers</h2>
    <div class="managers">
        <?php
        // Controleren of $managers is geïnitialiseerd en niet leeg is
        if (isset($managers) && !empty($managers)) :
            foreach ($managers as $manager) :
        ?>
                <div class="manager">
                    <!-- De afbeelding weergeven vanuit de map op de server -->
                    <img src="<?php echo $imageDirectory . $manager['profile_picture']; ?>" alt="Profielfoto">
                    <h3>Name: <?php echo $manager['firstname'] . " " . $manager['lastname']; ?></h3>
                    <h3>Email: <?php echo $manager['email']; ?></h3>
                    <h3>Hub location: <?php echo $manager['hub_location']; ?></h3>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Er zijn geen managers gevonden.</p>
        <?php endif; ?>
    </div>

    <button>Add Manager</button>
</body>

</html>