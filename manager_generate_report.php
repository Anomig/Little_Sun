<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include_once(__DIR__ . "/classes/data.php");
$pdo = Data::getConnection();
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
  <script>
        function generateReport() {
            var reportType = document.getElementById("report_type").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("report_container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "generate_report.php?type=" + reportType, true);
            xhttp.send();
        }
    </script>
</head>
<body>
  <?php include_once("manager.nav.inc.php"); ?>
  <h1>Rapporten Dashboard</h1>
  <form onsubmit="event.preventDefault(); generateReport();">
        <label for="report_type">Selecteer een rapporttype:</label>
        <select name="type" id="report_type">
            <option value="hours_per_person">Aantal gewerkte uren per persoon</option>
            <option value="hours_per_task">Aantal gewerkte uren per taak</option>
            <option value="sick_leave">Ziekteverlof</option>
            <option value="leave">Vakantieverlof</option>
        </select>
        <button type="submit">Genereer Rapport</button>
    </form>
    <div id="report_container"></div>
</body>
</html>
