<?php
include_once(__DIR__ . "/classes/data.php");
$pdo = Data::getConnection();

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];
    switch ($reportType) {
        // case 'hours_per_person':
        //     $stmt = $pdo->query("SELECT employees.firstname, employees.lastname, SUM(TIMESTAMPDIFF(HOUR, total_hours)) as total_hours");
        //     $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     echo "<h2>Aantal gewerkte uren per persoon</h2>";
        //     echo "<table>";
        //     echo "<tr><th>User ID</th><th>User Name</th><th>Total Hours</th></tr>";
        //     foreach ($reportData as $row) {
        //         echo "<tr><td>{$row['user_id']}</td><td>{$row['user_name']}</td><td>{$row['total_hours']}</td></tr>";
        //     }
        //     echo "</table>";
        //     break;

        // case 'hours_per_task':
        //     $stmt = $pdo->query("SELECT hub_tasks.id AS task_id, SUM(TIMESTAMPDIFF(HOUR, work_times.clock_in, work_times.clock_out)) as total_hours FROM work_times INNER JOIN task_assignments ON task_assignments.user_id = work_times.id INNER JOIN hub_tasks ON hub_tasks.id = task_assignments.task_id GROUP BY hub_tasks.id");
        //     $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     echo "<h2>Aantal gewerkte uren per taak</h2>";
        //     echo "<table>";
        //     echo "<tr><th>Task ID</th><th>Total Hours</th></tr>";
        //     foreach ($reportData as $row) {
        //         echo "<tr><td>{$row['task_id']}</td><td>{$row['total_hours']}</td></tr>";
        //     }
        //     echo "</table>";
        //     break;

        case 'leave':
            $stmt = $pdo->query("SELECT employees.firstname, employees.lastname, COUNT(*) as leave_days FROM time_off INNER JOIN employees ON employees.id = time_off.employee_id WHERE time_off.is_sick = 0 GROUP BY employees.id");
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>Time Off</h2>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Leave Days</th></tr>";
            foreach ($reportData as $row) {
                echo "<tr><td>{$row['firstname']}</td><td>{$row['lastname']}</td><td>{$row['leave_days']}</td></tr>";
            }
            echo "</table>";
            break;
    
        case 'sick_leave':
            $stmt = $pdo->query("SELECT employees.firstname, employees.lastname, COUNT(*) as sick_days FROM time_off INNER JOIN employees ON employees.id = time_off.employee_id WHERE time_off.is_sick = 1 GROUP BY employees.id");
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>Sick leave</h2>";
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Sick Days</th></tr>";
            foreach ($reportData as $row) {
                echo "<tr><td>{$row['firstname']}</td><td>{$row['lastname']}</td><td>{$row['sick_days']}</td></tr>";
            }
            echo "</table>";
            break;

        default:
            echo "Ongeldig rapporttype geselecteerd.";
            break;
    }
} else {
    echo "Geen rapporttype geselecteerd.";
}
?>
