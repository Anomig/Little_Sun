<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);

$error = "";
$popupMessage = "";

$workers = $hubUser->getUsers();
// Variabele om taken op te slaan
$tasks = [];

try {
  // Query om taken op te halen
  $stmt = $pdo->query("SELECT id, task_name, task_description FROM hub_tasks");
  $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formuliergegevens ophalen
  $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
  $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $hub_task = isset($_POST['hub_task']) ? $_POST['hub_task'] : '';

  // Controleer of alle vereiste velden zijn ingevuld
  if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($hub_task)) {
    $error = "All fields are required.";
  } else {
    try {
      // Controleren of het e-mailadres al bestaat in de database
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE email = ?");
      $stmt->execute([$email]);
      $count = $stmt->fetchColumn();

      if ($count > 0) {
        // Het e-mailadres bestaat al, toon een foutmelding aan de gebruiker
        $error = "This e-mail address is already being used.";
      } else {
        // Het e-mailadres bestaat niet, voer de registratie uit
        $hubUser->addUser($firstname, $lastname, $email, $password, "user", $hub_task);
        $popupMessage = "New user added!";
      }
    } catch (PDOException $e) {
      $error = "There has been an error, please reload the page.";
    }
  }
}

$timeOffRequests = [];
try {
  $stmt = $pdo->query(
    "SELECT time_off.id, time_off.start_date, time_off.end_date, time_off.reason, time_off.comments, time_off.status, time_off.is_sick, time_off.employee_id, employees.firstname, employees.lastname, employees.email
    FROM time_off
    JOIN employees ON time_off.employee_id = employees.id"
  );
  $timeOffRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
}
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Management</title>
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/nav.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/column.css">
</head>

<body>
  <?php include_once("manager.nav.inc.php"); ?>

  <div class="body">
    <div class="index_title">
      <div>
        <!--<a href="manager_workers.php">Workers in hub</a>
        <a href="manager_tasks.php">Tasks</a>-->
      </div>
    </div>

    <div class="form-container">
      <!-- ADD NEW USERS -->
      <div class="add-hub-managers-container add-hub-managers">
        <h1>Add new users!</h1>

        <?php if (!empty($error)) : ?>
          <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div>
          <form action="" method="post">
            <div class="p-2 field-container">
              <label for="firstname" class="text-slate-700">Firstname</label>
              <input type="text" name="firstname" id="firstname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-2 field-container">
              <label for="lastname" class="text-slate-700">Lastname</label>
              <input type="text" name="lastname" id="lastname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-3 field-container">
              <label for="email" class="text-slate-700">Email</label>
              <input type="text" name="email" id="email" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-4 field-container">
              <label for="password" class="text-slate-700">Password</label>
              <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-6 field-container">
              <label for="hub_task" class="text-slate-700">Hub task</label>
              <select name="hub_task" id="hub_task" class="border-solid border-slate-20 border-2 rounded">
                <option value="">Select a task</option> <!-- Standaard 'niet-actieve' optie toegevoegd -->
                <?php foreach ($tasks as $task) : ?>
                  <option value="<?php echo htmlspecialchars($task['id']); ?>">
                    <?php echo htmlspecialchars($task['task_name']);
                    if (!empty($task['task_description'])) {
                      echo ', ' . htmlspecialchars($task['task_description']);
                    } ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="p-2">
              <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Add user" />
            </div>
          </form>
        </div>
      </div>
      <!-- EINDE ADD NEW USERS -->

      <!-- TASKS -->
      <div class="body add-hub-managers">
        <div class="index_title">
          <h1>Tasks</h1>
        </div>

        <ul>
          <?php foreach ($tasks as $task) : ?>
            <li class="task-item add-hub-managers"> <!-- Gebruik van de juiste CSS-klasse voor consistentie -->
              <div class="task-details">
                <div><?php echo htmlspecialchars($task['task_name']); ?></div>
              </div>
              <!-- Start Date and Time input field -->
              <div class="datetime-field">
                <label for="start_datetime_<?php echo $task['id']; ?>" class="text-slate-700">Start</label>
                <input type="datetime-local" name="start_datetime_<?php echo $task['id']; ?>" id="start_datetime_<?php echo $task['id']; ?>" class="border-solid border-slate-20 border-2 rounded" value="<?php echo !empty($task['task_start_date']) ? date('Y-m-d\TH:i', strtotime($task['task_start_date'])) : ''; ?>" />
              </div>
              <!-- End Date and Time input field -->
              <div class="datetime-field">
                <label for="end_datetime_<?php echo $task['id']; ?>" class="text-slate-700">End</label>
                <input type="datetime-local" name="end_datetime_<?php echo $task['id']; ?>" id="end_datetime_<?php echo $task['id']; ?>" class="border-solid border-slate-20 border-2 rounded" value="<?php echo !empty($task['task_end_date']) ? date('Y-m-d\TH:i', strtotime($task['task_end_date'])) : ''; ?>" />
              </div>
              <!-- Dropdown-menu om gebruiker toe te wijzen -->
              <form action="update_task.php" method="post" id="assign_form_<?php echo $task['id']; ?>" class="field-container" onsubmit="submitForm(event, <?php echo $task['id']; ?>)">
                <select name="user_id" id="task_<?php echo $task['id']; ?>" class="border-solid border-slate-20 border-2 rounded">
                  <option value="">Assign User</option>
                  <?php foreach ($workers as $worker) : ?>
                    <option value="<?php echo htmlspecialchars($worker['id']); ?>"><?php echo htmlspecialchars($worker['firstname'] . ' ' . $worker['lastname']); ?></option>
                  <?php endforeach; ?>
                </select>
                <!-- Hidden input voor taak-ID -->
                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                <div class="save-button-container">
                  <input type="submit" class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" value="Save">
                </div>
              </form>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
        <!-- TIME OFF REQUESTS -->
        <div class="body add-hub-managers" id="time-off-requests">
          <div class="index_title">
            <h2>Time Off Requests</h2>
          </div>

          <?php if (!empty($popupMessage)) : ?>
            <div class="popup-message"><?php echo htmlspecialchars($popupMessage); ?></div>
          <?php endif; ?>

          <ul id="task-details time-off-details">
            <?php foreach ($timeOffRequests as $request) : ?>
              <li class="task-item add-hub-managers">
                <div id="task-details time-off-details">
                  <div><strong>Employee:</strong> <?php echo htmlspecialchars($request['firstname'] . ' ' . $request['lastname'] . ' (' . $request['email'] . ')'); ?></div>
                  <div><strong>Start Date:</strong> <?php echo htmlspecialchars($request['start_date']); ?></div>
                  <div><strong>End Date:</strong> <?php echo htmlspecialchars($request['end_date']); ?></div>
                  <div><strong>Reason:</strong> <?php echo htmlspecialchars($request['reason']); ?></div>
                  <div><strong>Comments:</strong> <?php echo htmlspecialchars($request['comments']); ?></div>
                  <div><strong>Status:</strong> <?php echo htmlspecialchars($request['status']); ?></div>
                </div>
                <form action="" method="post">
                  <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                  <input type="hidden" name="action" value="updateStatus">
                  <div class="field-container" id="extra">
                    <label for="status_<?php echo $request['id']; ?>" class="text-slate-700">Update Status</label>
                    <select name="status" id="status_<?php echo $request['id']; ?>" class="border-solid border-slate-20 border-2 rounded">
                      <option value="requested" <?php echo $request['status'] === 'requested' ? 'selected' : ''; ?>>Requested</option>
                      <option value="approved" <?php echo $request['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                      <option value="denied" <?php echo $request['status'] === 'denied' ? 'selected' : ''; ?>>Denied</option>
                    </select>
                  </div>
                  <div class="save-button-container">
                    <input type="submit" class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" value="Save">
                  </div>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <!-- EINDE TIME OFF REQUESTS -->
    </div>
  </div>

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

        function submitForm(event, taskId) {
            event.preventDefault(); // Voorkom standaard formulierverzending

            // Verkrijg het formulier element
            var form = document.getElementById("assign_form_" + taskId);
            
            // Maak een FormData object van het formulier
            var formData = new FormData(form);

            // Verstuur de data via fetch
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                // Voeg hier code toe om de UI te updaten na een succesvolle bewerking, bijvoorbeeld:
                alert('Task updated successfully!');
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>

</html>
