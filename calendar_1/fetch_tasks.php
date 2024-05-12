<?php
require_once 'db.php';

try {
    // Verbinding maken met de database via de Db klasse
    $conn = Db::getConnection();

    // Query om taken op te halen
    $sql = "SELECT * FROM hub_tasks";
    $result = $conn->query($sql);

    // Array om taken op te slaan
    $tasks = array();

    // Controleren of er resultaten zijn en deze toevoegen aan de array
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $tasks[] = $row;
        }
    }

    // Teruggeven van de taken in JSON-indeling
    header('Content-Type: application/json');
    echo json_encode($tasks);
} catch (Exception $e) {
    // Foutafhandeling: retourneer een JSON-foutbericht
    header('Content-Type: application/json');
    echo json_encode(array('error' => $e->getMessage()));
}
?>
