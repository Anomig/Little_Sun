<?php
session_start();
include_once(__DIR__ . "/classes/data.php");

$pdo = Data::getConnection();

// Functie om de huidige sessiestatus te controleren
function getCurrentSession($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM work_times WHERE clock_out IS NULL ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    return $stmt->fetch();
}

$current_session = getCurrentSession($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_clock'])) {
    if ($current_session) {
        // Clock out
        $clock_out_time = new DateTime();
        $clock_in_time = new DateTime($current_session['clock_in']);
        $interval = $clock_out_time->diff($clock_in_time);

        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;
        $total_hours = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        $overtime = max(0, $hours + ($minutes / 60) - 8); // overtime staat nu op +8 uur

        $stmt = $pdo->prepare("UPDATE work_times SET clock_out = :clock_out, total_hours = :total_hours, overtime = :overtime WHERE id = :id");
        if (!$stmt->execute([
            'clock_out' => $clock_out_time->format('Y-m-d H:i:s'),
            'total_hours' => $total_hours,
            'overtime' => $overtime,
            'id' => $current_session['id']
        ])) {
            die("Error updating record: " . implode(", ", $stmt->errorInfo()));
        }
    } else {
        // Clock in
        $stmt = $pdo->prepare("INSERT INTO work_times (clock_in) VALUES (:clock_in)");
        if (!$stmt->execute([
            'clock_in' => date('Y-m-d H:i:s')
        ])) {
            die("Error inserting record: " . implode(", ", $stmt->errorInfo()));
        }
    }

    // Vernieuw de pagina om de status van de knop bij te werken
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Werk de sessiestatus bij na het verwerken van het POST-verzoek
$current_session = getCurrentSession($pdo);

// Bepaal de tekst van de knop
$button_text = $current_session ? "Clock Out" : "Clock In";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/style.css">
    <style>
        body {
            margin: 25px;
            /* Voeg een marge van 25 pixels toe aan alle zijden van het body-element */
        }
    </style>
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

    <div id="work_duration_message" style="display: <?php echo ($current_session && $button_text === 'Clock Out') ? 'block' : 'none'; ?>;">
        <?php
        if ($current_session && $button_text === 'Clock Out') {
            echo "Je hebt gewerkt voor: " . $current_session['total_hours'];
        }
        ?>
    </div>
</body>
</html>
