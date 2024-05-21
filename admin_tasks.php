<?php

//NIET MEER NODIG

require_once(__DIR__ . "/classes/Data.php");

// Functie om een taak toe te voegen
function addTask($name, $description)
{
    $conn = Data::getConnection();
    $sql = "INSERT INTO hub_tasks (task_name, task_description) VALUES (:task_name, :task_description)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_name', $name);
    $stmt->bindParam(':task_description', $description);
    return $stmt->execute();
}

// Functie om een taak te bewerken
function editTask($id, $name, $description)
{
    $conn = Data::getConnection();
    $sql = "UPDATE hub_tasks SET task_name = :task_name, task_description = :task_description WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':task_name', $name);
    $stmt->bindParam(':task_description', $description);
    return $stmt->execute();
}

// Functie om een taak te verwijderen
function deleteTask($task_id)
{
    $conn = Data::getConnection();
    $sql = "DELETE FROM hub_tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $task_id);
    return $stmt->execute();
}

try {
    $conn = Data::getConnection();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add_task':
                    $name = $_POST['task_name'];
                    $description = $_POST['task_description'];
                    if (addTask($name, $description)) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Er is een fout opgetreden bij het toevoegen van de taak.<br>";
                    }
                    break;
                case 'edit_task':
                    $id = $_POST['task_id'];
                    $name = $_POST['edit_task_name'];
                    $description = $_POST['edit_task_description'];
                    if (editTask($id, $name, $description)) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Er is een fout opgetreden bij het bewerken van de taak.<br>";
                    }
                    break;
                case 'delete_task':
                    $task_id = $_POST['task_id'];
                    if (deleteTask($task_id)) {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        echo "Er is een fout opgetreden bij het verwijderen van de taak.<br>";
                    }
                    break;
            }
        }
    }

    $sql = "SELECT * FROM hub_tasks";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/nav.css">
    <link rel="stylesheet" href="styles/locations.css">
</head>
<body>
    <?php include_once("admin.nav.inc.php"); ?>
    <div class="content">
        <h3>Add New Task</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required><br>
            <label for="task_description">Task Description:</label>
            <textarea id="task_description" name="task_description" required></textarea><br>
            <input type="hidden" name="action" value="add_task">
            <button type="submit">Add Task</button>
        </form>

        <h3>Existing Tasks</h3>
        <?php foreach ($tasks as $task) : ?>
            <div class="location">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($task['task_name']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($task['task_description']); ?></p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                    <input type="hidden" name="action" value="edit_task">
                    <label for="edit_task_name_<?php echo $task['id']; ?>">Task Name:</label>
                    <input type="text" id="edit_task_name_<?php echo $task['id']; ?>" name="edit_task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>"><br>
                    <label for="edit_task_description_<?php echo $task['id']; ?>">Task Description:</label>
                    <textarea id="edit_task_description_<?php echo $task['id']; ?>" name="edit_task_description"><?php echo htmlspecialchars($task['task_description']); ?></textarea><br>
                    <button type="submit">Save</button>
                </form>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                    <input type="hidden" name="action" value="delete_task">
                    <button type="submit">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
