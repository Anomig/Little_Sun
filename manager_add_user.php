<?php
include_once(__DIR__ . "/classes/data.php");
include_once(__DIR__ . "/classes/HubUser.php");

$pdo = Data::getConnection();
$hubUser = new HubUser($pdo);

$tasks = []; // Array om locaties op te slaan

try {
    // Query om locaties op te halen
    $stmt = $pdo->query("SELECT id, task_name, task_description FROM hub_tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}
// Variabelen voor foutmelding en popup-melding
$error = "";
$popupMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formuliergegevens ophalen
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  // $profile_picture = $_POST['profile_picture'];
  $hub_task = $_POST['hub_task'];

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
          // $popupMessage = "New user added!";
      }
  } catch (PDOException $e) {
      $error = "There has been an error, please reload the page.";
  }
}
}
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Little Sun ☀️</title>
  <link rel="stylesheet" href="styles/normalize.css">
  <link rel="stylesheet" href="styles/nav.css">
  <link rel="stylesheet" href="styles/style.css">
  <script>
        // JavaScript voor de popup-melding en redirect
        window.onload = function() {
            <?php if (!empty($popupMessage)) : ?>
                alert("<?php echo $popupMessage; ?>");
                window.location.href = "admin_dashboard.php"; // Redirect naar het admin dashboard
            <?php endif; ?>
        };
    </script>
</head>

<body>
  <?php include_once("manager.nav.inc.php"); ?>


  <div class="index_title">
    <h1>Add new users! </h1>
  </div>


  <?php if (!empty($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="bg-slate-100 p-1">
        <form action="" method="post">
            <div class="p-2">
                <label for="firstname" class="text-slate-700">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-2">
                <label for="lastname" class="text-slate-700">Lastname</label>
                <input type="text" name="lastname" id="lastname" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-3">
                <label for="email" class="text-slate-700">Email</label>
                <input type="text" name="email" id="email" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-4">
                <label for="password" class="text-slate-700">Password</label>
                <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
            </div>

            <div class="p-6">
                <label for="hub_task" class="text-slate-700">Hub task</label>
                <select name="hub_task" id="hub_task" class="border-solid border-slate-20 border-2 rounded">
                    <option value="">Select a task</option> <!-- Standaard 'niet-actieve' optie toegevoegd -->
                    <?php foreach ($tasks as $task) : ?>
                        <option value="<?php echo htmlspecialchars($task['id']); ?>">
                            <?php echo htmlspecialchars($task['task_name'] . ', ' . $task['task_description']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="p-2">
                <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Add Hub Manager" />
            </div>
        </form>
    </div>

    <div class="flex flex-row flex-wrap gap-1 p-2">
</body>
</html>
