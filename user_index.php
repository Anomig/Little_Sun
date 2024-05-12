<?php
session_start();
include_once(__DIR__ . "/classes/db.php");

$pdo = Db::getConnection();

// Controleer of de gebruiker is ingelogd en haal de gebruikers-ID op
$user_id = $_SESSION['user_id'] ?? null;

// Bepaal de tekst voor de knop op basis van de huidige status
if (!$user_id) {
    // Geen actieve sessie, toon standaard "Clock In"
    $button_text = "Clock In";
} else {
    // Haal de huidige status op basis van de laatste in- en uitklokgegevens
    $stmt = $pdo->prepare("SELECT * FROM work_times WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
    $stmt->execute(['user_id' => $user_id]);
    $status = $stmt->fetch();

    if ($status && !$status['clock_out']) {
        // Er is een actieve sessie zonder clock_out, toon "Clock Out"
        $button_text = "Clock Out";
    } else {
        // Geen actieve sessie, toon standaard "Clock In"
        $button_text = "Clock In";
    }
}

// Verwerk het in- en uitklokken
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_clock'])) {
    if ($button_text === "Clock In") {
        // Clock in
        $stmt = $pdo->prepare("INSERT INTO work_times (user_id, clock_in) VALUES (:user_id, :clock_in)");
        $stmt->execute([
            'user_id' => $user_id,
            'clock_in' => date('Y-m-d H:i:s')
        ]);
    } else {
        // Clock out
        $stmt = $pdo->prepare("UPDATE work_times SET clock_out = :clock_out WHERE user_id = :user_id AND clock_out IS NULL");
        $stmt->execute([
            'clock_out' => date('Y-m-d H:i:s'),
            'user_id' => $user_id
        ]);
    }
}

// Haal de toegewezen taken voor de huidige gebruiker op uit de user_tasks-tabel
if ($user_id) {
    $task_stmt = $pdo->prepare("SELECT t.task_name, t.task_description FROM hub_tasks t INNER JOIN user_tasks ut ON t.id = ut.task_id WHERE ut.user_id = :user_id");
    $task_stmt->execute(['user_id' => $user_id]);
    $tasks = $task_stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <title>little sun ☀️</title>
</head>

<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="index_title">
        <h1>Hi!</h1>
        <div class="log_out">
            <div>🟢</div>
            <div><a href="logout.php">Log out</a></div>
        </div>
    </div>
    <div class="log_out"><a href="time_off_user.php">Request time-off</a></div>

    <form method="post">
        <button name="toggle_clock"><?php echo $button_text; ?></button>
    </form>

    <div>
        <h2>Task overview:</h2>
        <ul>
            <?php if (!empty($tasks)) : ?>
                <?php foreach ($tasks as $task) : ?>
                    <li><?php echo htmlspecialchars($task['task_name']) . ": " . htmlspecialchars($task['task_description']); ?></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>No tasks assigned.</li>
            <?php endif; ?>
        </ul>
    </div>

</body>

</html>
