<?php
require 'db.php'; // Laad de databaseverbinding in

$display_query = "SELECT id, task_name, task_start_date, task_end_date FROM hub_tasks";
$results = Db::getConnection()->query($display_query); // Gebruik de PDO-verbinding van db.php
$count = $results->rowCount();

if ($count > 0) {
    $data_arr = array();
    $i = 1;
    while ($data_row = $results->fetch(PDO::FETCH_ASSOC)) {
        $data_arr[$i]['id'] = $data_row['id'];
        $data_arr[$i]['title'] = $data_row['task_name'];
        $data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['task_start_date']));
        $data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['task_end_date']));
        $data_arr[$i]['color'] = '#' . substr(uniqid(), -6); // 'green'; pass colour name
        $data_arr[$i]['url'] = 'https://www.shinerweb.com';
        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'
    );
}
echo json_encode($data);
?>
