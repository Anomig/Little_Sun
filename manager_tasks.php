<?php
include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Db::getConnection();
$hubUser = new HubUser($pdo);

$error = "";
$popupMessage = "";
$workers = $hubUser->getUsers();
$tasks = [];

try {
    // Query om taken op te halen
    $stmt = $pdo->query("SELECT id, task_name, task_start_date, task_end_date, assigned_to FROM hub_tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Sun ☀️</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="index_title">
        <h1>Tasks</h1>
        <div class="log_out">
            <div>🔵</div>
            <div>
                <a href="logout.php">Log out</a>
            </div>
        </div>
    </div>

    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li class="task-item">
                <div class="task-details">
                    <div><?php echo $task['task_name']; ?></div>
                    <!-- Dropdown-menu om gebruiker toe te wijzen -->
                    <form action="update_task.php" method="post" id="assign_form_<?php echo $task['id']; ?>" onchange="toggleDateTimeFields(<?php echo $task['id']; ?>)">
                        <select name="user_id" id="task_<?php echo $task['id']; ?>">
                            <option value="">Assign User</option>
                            <?php foreach ($workers as $worker) : ?>
                                <option value="<?php echo $worker['id']; ?>"><?php echo $worker['firstname'] . ' ' . $worker['lastname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Hidden input voor taak-ID -->
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit">Save</button> <!-- Veranderde knop naar submit type -->
                    </form>
                </div>
                <!-- Start Date and Time input field -->
                <div class="datetime-field">
                    <label for="start_datetime_<?php echo $task['id']; ?>" class="text-slate-700">Start</label>
                    <input type="datetime-local" name="start_datetime_<?php echo $task['id']; ?>" id="start_datetime_<?php echo $task['id']; ?>" class="border-solid border-slate-20 border-2 rounded" value="<?php echo date('Y-m-d\TH:i', strtotime($task['task_start_date'])); ?>" />
                </div>
                <!-- End Date and Time input field -->
                <div class="datetime-field">
                    <label for="end_datetime_<?php echo $task['id']; ?>" class="text-slate-700">End</label>
                    <input type="datetime-local" name="end_datetime_<?php echo $task['id']; ?>" id="end_datetime_<?php echo $task['id']; ?>" class="border-solid border-slate-20 border-2 rounded" value="<?php echo date('Y-m-d\TH:i', strtotime($task['task_end_date'])); ?>" />
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        // JavaScript om de invoervelden dynamisch weer te geven op basis van de taakselectie
        function toggleDateTimeFields(taskId) {
            var selectTask = document.getElementById("task_" + taskId);
            var startDateTimeField = document.getElementById("start_datetime_" + taskId);
            var endDateTimeField = document.getElementById("end_datetime_" + taskId);

            if (selectTask.value !== "") {
                startDateTimeField.style.display = "block";
                endDateTimeField.style.display = "block";
            } else {
                startDateTimeField.style.display = "none";
                endDateTimeField.style.display = "none";
            }
        }
    </script>
</body>

</html>
