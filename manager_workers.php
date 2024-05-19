<?php
session_start();
include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);
$workers = $hubUser->getUsers();
$tasks = $hubUser->getTasks();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_tasks'])) {
  foreach ($workers as $worker) {
      if (isset($_POST['tasks_' . $worker['id']])) {
          $tasks = $_POST['tasks_' . $worker['id']];
          $user_id = $worker['id'];

          // Verwijder oude toewijzingen
          $sql = "DELETE FROM task_assignments WHERE user_id = ?";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$user_id]);

          // Voeg nieuwe toewijzingen toe
          foreach ($tasks as $task_id) {
              $sql = "INSERT INTO task_assignments (task_id, user_id) VALUES (?, ?)";
              $stmt = $pdo->prepare($sql);
              if (!$stmt->execute([$task_id, $user_id])) {
                  echo "Error assigning task: " . $stmt->errorInfo()[2];
              }
          }
      }else {
        // Verwijder alle bestaande toewijzingen als er geen taken zijn geselecteerd
        $user_id = $worker['id'];
        $sql = "DELETE FROM task_assignments WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
    }
  }
  $_SESSION['message'] = "Taken succesvol toegewezen aan de geselecteerde gebruikers.";
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}

// Haal toegewezen taken op
function getAssignedTasks($pdo) {
  $sql = "SELECT * FROM task_assignments";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$assignedTasks = getAssignedTasks($pdo);

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
  <link rel="stylesheet" href="styles/workers.css">
</head>
<body>
  <?php include_once("manager.nav.inc.php"); ?>

  <div class="index_title">
    <h1>Workers in Hub</h1>
  </div>

  <?php
  if (isset($_SESSION['message'])) {
      echo "<div class='success-message'>" . $_SESSION['message'] . "</div>";
      unset($_SESSION['message']);
  }
  ?>

  <form method="post" action="">
    <div class="flex flex-row flex-wrap gap-1 p-2">
      <div class="workers">
        <?php foreach ($workers as $worker) : ?>
          <div class="worker-card">
            <div class="worker-details">
              <div class="worker-name"><?php echo $worker['firstname'] . ' ' . $worker['lastname']; ?></div>
              <div class="worker-email"><?php echo $worker['email']; ?></div>
              <div class="tasks">
                <?php foreach ($tasks as $task) : ?>
                  <div class="task-item">
                    <?php
                    $checked = '';
                    foreach ($assignedTasks as $assignment) {
                        if ($assignment['user_id'] == $worker['id'] && $assignment['task_id'] == $task['id']) {
                            $checked = 'checked';
                            break;
                        }
                    }
                    ?>
                    <input type="checkbox" id="task_<?php echo $worker['id'] . '_' . $task['id']; ?>" name="tasks_<?php echo $worker['id']; ?>[]" value="<?php echo $task['id']; ?>" <?php echo $checked; ?>>
                    <label for="task_<?php echo $worker['id'] . '_' . $task['id']; ?>"><?php echo $task['task_name']; ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <button type="submit" name="assign_tasks">Taken toewijzen</button>
  </form>
</body>
</html>
