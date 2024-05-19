<?php
session_start();
include_once(__DIR__ . "/classes/data.php");

//TIME-OFF
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
        $is_sick = ($reason === 'sickness') ? 1 : 0;

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

//EINDE TIME-OFF

//CLOCK IN

$pdo = Data::getConnection();

// Functie om de huidige sessiestatus te controleren
function getCurrentSession($pdo)
{
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

//EINDE CLOCK IN

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/column.css">
</head>

<body>
    <?php include_once("user.nav.inc.php"); ?>

    <div class="form-container">

        <div class="body">
            <form method="post">
                <button name="toggle_clock" class="button"><?php echo $button_text; ?></button>
            </form>
            <div id="work_duration_message" class="message" style="display: <?php echo ($current_session && $button_text === 'Clock Out') ? 'block' : 'none'; ?>;">
                <?php
                if ($current_session && $button_text === 'Clock Out') {
                    echo "Je hebt gewerkt voor: " . $current_session['total_hours'];
                }
                ?>
            </div>
        </div>

        <div class="add-hub-managers">
            <form action="time_off_user.php" method="post">
                <h2>Time-off form</h2>
                <div class="field-container">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                </div>

                <div class="field-container">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                </div>

                <div class="field-container">
                    <label for="reason">Reason:</label>
                    <select id="reason" name="reason" required>
                        <option value="vacation">Vacation</option>
                        <option value="birthday">Birthday</option>
                        <option value="maternity">Maternity</option>
                        <option value="sickness">Sickness</option>
                        <option value="other">Other (please give more information below)</option>
                    </select>
                </div>

                <div class="field-container">
                    <label for="comments">Comments:</label>
                    <textarea id="comments" name="comments"></textarea>
                </div>

                <div class="field-container">
                    <button type="submit" class="button">Request Time Off</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
