<?php
session_start();

include_once(__DIR__ . "/classes/db.php");

$pdo = Db::getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Dit veronderstelt dat de gebruiker is ingelogd en een sessie heeft.
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];
    $comments = $_POST['comments'];
    
    // Voer de query uit om de data toe te voegen
    $sql = "INSERT INTO time_off (user_id, start_date, end_date, reason, comments, status) VALUES (?, ?, ?, ?, ?, 'requested')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $start_date, $end_date, $reason, $comments,]);

    echo "Time off requested successfully";
    // Redirect terug naar de vorige pagina of naar een specifieke pagina
    header('Location: user_index.php');
    exit;
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
    <?php include_once("nav.inc.php"); ?>


    <div class="index_title">
        <h1>Hi!</h1>

        <div class="log_out">

            <div>🟢</div>
            <div>
                <a href="logout.php">Log out</a>
            </div>

        </div>

    </div>


    <form action="user_index.php" method="post">
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