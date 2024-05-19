<?php
require 'data.php';

$assigned_to = $_POST['assigned_to'];
$location_id = $_POST['location'];

if (isset($_POST['task_name'], $_POST['task_description'], $_POST['task_start_date'], $_POST['task_end_date'], $_POST['assigned_to'], $_POST['location'])) {
    $task_id = isset($_POST['task_id']) ? $_POST['task_id'] : null;
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_start_date = $_POST['task_start_date'];
    $task_end_date = $_POST['task_end_date'];
    $assigned_to = $_POST['assigned_to'];
    $location_id = $_POST['location'];
    
    if (strtotime($task_start_date) && strtotime($task_end_date)) {
        try {
            if ($task_id) {
                // Update existing task
                $query = "UPDATE hub_tasks SET task_name = ?, task_description = ?, task_start_date = ?, task_end_date = ?, assigned_to = ?, hub_location_id = ? WHERE id = ?";
                $stmt = Data::getConnection()->prepare($query);
                $stmt->execute([$task_name, $task_description, $task_start_date, $task_end_date, $assigned_to, $location_id, $task_id]);
            } else {
                // Insert new task
                $query = "INSERT INTO hub_tasks (task_name, task_description, task_start_date, task_end_date, assigned_to, hub_location_id) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = Data::getConnection()->prepare($query);
                $stmt->execute([$task_name, $task_description, $task_start_date, $task_end_date, $assigned_to, $location_id]);
            }
            $data = [
                'status' => true,
                'msg' => 'Task successfully saved!'
            ];
        } catch (PDOException $e) {
            $data = [
                'status' => false,
                'msg' => 'Error saving task: ' . $e->getMessage()
            ];
        }
    } else {
        $data = [
            'status' => false,
            'msg' => 'Invalid date format.'
        ];
    }
} else {
    $data = [
        'status' => false,
        'msg' => 'Not all required fields are filled.'
    ];
}

echo json_encode($data);
?>
