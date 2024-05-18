<?php
require_once(__DIR__ . "/classes/data.php");

// Connect to the database
try {
    $conn = Data::getConnection();
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Process form submission to add a new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task_type"])) {
    $task_name = $_POST["task_name"];
    $task_description = $_POST["task_description"];

    try {
        // Add the new task to the database
        $sql = "INSERT INTO `hub_tasks` (`task_name`, `task_description`) VALUES (:task_name, :task_description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task_name', $task_name);
        $stmt->bindParam(':task_description', $task_description);
        $stmt->execute();
        echo "New task successfully added.";
        // Redirect to prevent form resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Process form submission to delete a task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_task"])) {
    $task_id = $_POST["task_id"];

    try {
        // Delete the selected task from the database
        $sql = "DELETE FROM `hub_tasks` WHERE `id` = :task_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->execute();
        echo "Task successfully deleted.";
        // Redirect to prevent form resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <h2>Add New Task</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="task_name">Task Name:</label>
        <input type="text" id="task_name" name="task_name" required><br>
        <label for="task_description">Task Description:</label>
        <textarea id="task_description" name="task_description" required></textarea><br>
        <button type="submit" name="add_task_type">Add Task</button>
    </form>

    <h2>Tasks</h2>
    <ul>
        <?php
        try {
            // Fetch all tasks from the database
            $sql = "SELECT * FROM `hub_tasks`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the tasks and add a button to delete them
            foreach ($tasks as $task) {
                echo "<li>" . $task["task_name"] . " - " . $task["task_description"] . " <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'><input type='hidden' name='task_id' value='" . $task["id"] . "'><button type='submit' name='delete_task'>Delete</button></form></li>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </ul>
</body>
</html>
