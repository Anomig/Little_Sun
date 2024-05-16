<?php
// Verbinding maken met de database
var_dump($_POST);
include_once(__DIR__ . "/classes/db.php");
$pdo = Db::getConnection();

// Controleren of het verzoek POST is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvangen gegevens van het formulier
    $task_id = $_POST["task_id"];
    $start_datetime = $_POST["start_datetime_" . $task_id];
    $end_datetime = $_POST["end_datetime_" . $task_id];
    $assigned_to = $_POST["user_id"]; // Let op: de naam van dit veld in het formulier moet "user_id" zijn

    // Query om gegevens toe te voegen aan de database
    $stmt = $pdo->prepare("UPDATE hub_tasks SET task_start_date = :start_date, task_end_date = :end_date, assigned_to = :assigned_to WHERE id = :task_id");

    // Bind parameters
    $stmt->bindParam(':start_date', $start_datetime);
    $stmt->bindParam(':end_date', $end_datetime);
    $stmt->bindParam(':assigned_to', $assigned_to);
    $stmt->bindParam(':task_id', $task_id);

    // Uitvoeren van de query
    if ($stmt->execute()) {
        // Als de query succesvol is, doorsturen naar de manager_tasks.php-pagina
        header("Location: manager_tasks.php");
        exit();
    } else {
        // Als er een fout optreedt, deze weergeven
        echo "Er is een fout opgetreden. Probeer het later opnieuw.";
    }
}
?>
