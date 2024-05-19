<?php
require 'data.php'; // Zorg ervoor dat db.php in dezelfde directory staat

try {
    // Query om taken op te halen
    // Query om taken op te halen
    $display_query = "SELECT ht.id, ht.task_name, ht.task_description, ht.task_start_date, ht.task_end_date, ht.assigned_to, ht.hub_location_id, e.firstname AS assigned_to_firstname, e.lastname AS assigned_to_lastname, hl.name AS location_name, hl.country AS location_country FROM hub_tasks ht LEFT JOIN employees e ON ht.assigned_to = e.id LEFT JOIN hub_location hl ON ht.hub_location_id = hl.id";

    $results = Data::getConnection()->query($display_query);

    // Check of er resultaten zijn
    if ($results->rowCount() > 0) {
        $data_arr = array();
        $i = 0;
        while ($data_row = $results->fetch(PDO::FETCH_ASSOC)) {
            $data_arr[$i]['id'] = $data_row['id'];
            $data_arr[$i]['title'] = $data_row['task_name'];
            $data_arr[$i]['description'] = $data_row['task_description']; // Beschrijving toegevoegd
            $data_arr[$i]['start'] = $data_row['task_start_date'];
            
            // Haal einddatum op en voeg een uur toe
            $end_date = new DateTime($data_row['task_end_date']);
            $end_date->modify('+1 hour');
            $data_arr[$i]['end'] = $end_date->format('Y-m-d H:i:s');
            
            $data_arr[$i]['color'] = '#' . substr(uniqid(), -6); // Voeg een willekeurige kleur toe
            $data_arr[$i]['url'] = '#'; // Voeg eventueel een URL toe
            $data_arr[$i]['assigned_to'] = $data_row['assigned_to_firstname'] . ' ' . $data_row['assigned_to_lastname']; // Toegewezen persoon toegevoegd
            $data_arr[$i]['location'] = $data_row['location_name'] . ', ' . $data_row['location_country']; // Locatie toegevoegd
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