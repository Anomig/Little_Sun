<?php
session_start();

include_once(__DIR__ . "/classes/db.php");
include_once(__DIR__ . "/classes/HubManager.php");



function loginAsManager($username, $password, $conn)
{
  $sql = "SELECT * FROM hub_managers WHERE email = :username";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['admin_logged_in'] = true; // hier ook
    return true;
  } else {
    return false;
  }
}

function logoutAsManager()
{
  unset($_SESSION['admin_logged_in']); //moeten we dit nog aanpassen?
}

$pdo = Db::getConnection();
$hubManager = new HubManager($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (loginAsManager($username, $password, $pdo)) {
      header("Location: manager_index.php"); //gaat naar index pagina voor managers
      exit();
    } else {
      $error_message = "Invalid email or password.";
    }
  }
}
?><!DOCTYPE html>
<html>

<head>
  <title>Manager 🔵 - Login</title>
</head>

<body>
  <?php include_once("nav.inc.php"); ?>

  <h1>Welcome, manager 🔵! Please log in</h1>

  <div class="bg-slate-100 p-1">
    <form action="" method="post">
      <?php if (isset($error_message)) : ?>
        <div class="error"><?php echo $error_message; ?></div>
      <?php endif; ?>
      <div class="p-3">
        <label for="email" class="text-slate-700">Email</label>
        <input type="text" name="username" id="email" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-4">
        <label for="password" class="text-slate-700">Password</label>
        <input type="password" name="password" id="password" class="border-solid border-slate-20 border-2 rounded" />
      </div>

      <div class="p-2">
        <input type="hidden" name="action" value="login" />
        <input class="cursor-pointer p-2 rounded text-white font-bold bg-green-600" type="submit" value="Login" />
      </div>
    </form>
  </div>

</body>

</html>