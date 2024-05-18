<?php
require 'db.php'; // Zorg ervoor dat db.php in dezelfde directory staat

try {
    // Query om taken op te halen
    $display_query = "SELECT id, task_name, task_start_date, task_end_date FROM hub_tasks";
    $results = Db::getConnection()->query($display_query);

    // Check of er resultaten zijn
    if ($results->rowCount() > 0) {
        $data_arr = array();
        $i = 0;
        while ($data_row = $results->fetch(PDO::FETCH_ASSOC)) {
            $data_arr[$i]['id'] = $data_row['id'];
            $data_arr[$i]['title'] = $data_row['task_name'];
            $data_arr[$i]['start'] = $data_row['task_start_date'];
            $data_arr[$i]['end'] = $data_row['task_end_date'];
            $data_arr[$i]['color'] = '#' . substr(uniqid(), -6); // Voeg een willekeurige kleur toe
            $data_arr[$i]['url'] = '#'; // Voeg eventueel een URL toe
            $i++;
        }

        // Succesvolle respons
        $data = array(
            'status' => true,
            'msg' => 'Tasks fetched successfully!',
            'data' => $data_arr
        );
    } else {
        // Geen taken gevonden
        $data = array(
            'status' => false,
            'msg' => 'No tasks found.'
        );
    }
} catch (PDOException $e) {
    // Fout bij het uitvoeren van de query
    $data = array(
        'status' => false,
        'msg' => 'Database error: ' . $e->getMessage()
    );
}

// JSON-respons
echo json_encode($data);
?>
