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
    $_SESSION['admin_logged_in'] = true;
    session_regenerate_id(true); // Regenerate session ID to prevent session fixation
    return true;
  } else {
    return false;
  }
}

function logoutAsManager()
{
  session_unset();
  session_destroy();
}

$pdo = Db::getConnection();
$hubManager = new HubManager($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['action'] === 'login') {
    $username = $_POST['email']; // Changed to match the form field name
    $password = $_POST['password'];

    if (loginAsManager($username, $password, $pdo)) {
      header("Location: manager_index.php"); // Redirect to manager's index page
      exit();
    } else {
      $error_message = "Invalid email or password.";
    }
  }
}
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Little Sun</title>
  <link rel="stylesheet" href="styles/login.css">
</head>

<body>

  <div class="logo"><img src="images/little_sun_logo.png" alt=""></div>

  <div class="loginContainer">
    <div class="formContainer form--login">
      <form action="" method="post">
        <h2 class="form__title">Log in ☀️</h2>

        <?php if (isset($error_message)) : ?> <!-- Changed to match the PHP variable -->
          <div class="form__error">
            <p><?php echo htmlspecialchars($error_message); ?></p> <!-- Display error message -->
          </div>
        <?php endif; ?>

        <div class="form__field">
          <label for="email">Email</label>
          <input type="text" name="email" required> <!-- Added required attribute for better UX -->
        </div>
        <div class="form__field">
          <label for="password">Password</label>
          <input type="password" name="password" required> <!-- Added required attribute for better UX -->
        </div>

        <div class="form__field">
          <input type="hidden" name="action" value="login"> <!-- Added hidden input for action -->
          <input type="submit" value="Log in" class="btn btn--primary">
        </div>
      </form>
    </div>
  </div>
</body>

</html>
