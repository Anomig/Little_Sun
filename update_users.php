<?php
include_once(__DIR__ . "/classes/Data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    // $location = $_POST['location'];
    // $function = $_POST['function'];
    $task_id = $_POST['task_id'];

    try {
        $stmt = $pdo->prepare("UPDATE employees SET location = :location, function = :function, task_id = :task_id WHERE id = :user_id");
        // $stmt->bindParam(':location', $location);
        // $stmt->bindParam(':function', $function);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            header("Location: manager_workers.php");
            exit();
        } else {
            echo "Er is een fout opgetreden. Probeer het later opnieuw.";
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "Er is een fout opgetreden. Probeer het later opnieuw.";
    }
}
?>
