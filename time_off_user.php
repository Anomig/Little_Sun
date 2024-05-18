<?php
session_start();

include_once(__DIR__ . "/classes/data.php");

$pdo = Data::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Zorg ervoor dat de gebruiker is ingelogd en een sessie heeft
    if (isset($_SESSION['user_id'])) {
        $employee_id = $_SESSION['user_id']; 
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];
        $comments = $_POST['comments'];
        $is_sick = $_POST['is_sick'];

        // Controleer of de reden "sickness" is
        $is_sick = ($reason === 'sickness') ? true : false;

        try {
            // Bereid de SQL query voor om de time-off aanvraag toe te voegen
            $sql = "INSERT INTO time_off (employee_id, start_date, end_date, reason, comments, status, is_sick) VALUES (?, ?, ?, ?, ?, 'requested',?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$employee_id, $start_date, $end_date, $reason, $comments, $is_sick]);

            // Bericht dat de time-off aanvraag succesvol is
            echo "Time off requested successfully";
            // Redirect terug naar de user_index pagina
            header('Location: user_index.php');
            exit;
        } catch (PDOException $e) {
            // Foutmelding weergeven
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Als de gebruiker niet is ingelogd, een foutmelding weergeven
        echo "Error: User not logged in.";
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

    <link rel="stylesheet" href="styles/style.css">
    <style>
        /* body {
            margin: 25px;

        } */

        .time_off {
            display: flex;
            flex-direction: column;
            max-width: 40%;

        }
    </style>
</head>

<body>
    <?php include_once("user.nav.inc.php"); ?>



    <form action="time_off_user.php" method="post">
        <h2>Time-off form</h2>
        <div class="time_off">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="reason">Reason:</label>
            <select id="reason" name="reason" required>
                <option value="vacation">Vacation</option>
                <option value="birthday">Birthday</option>
                <option value="maternity">Maternity</option>
                <option value="sickness">Sickness</option>
                <option value="other">Other (please give more information below)</option>
            </select>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments"></textarea>

            <button type="submit">Request Time Off</button>
        </div>
    </form>

</body>