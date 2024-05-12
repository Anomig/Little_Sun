<?php
require 'db.php';

// Controleer of alle vereiste POST-variabelen zijn ingesteld
if(isset($_POST['task_name'], $_POST['task_start_date'], $_POST['task_end_date'])) {
    // Haal de POST-variabelen op
    $task_name = $_POST['task_name'];
    $task_start_date = $_POST['task_start_date']; 
    $task_end_date = $_POST['task_end_date']; 
    
    // Controleer of de ingevoerde datums geldig zijn
    if (strtotime($task_start_date) && strtotime($task_end_date)) {
        try {
            // Bereid de SQL-query voor
            $insert_query = "INSERT INTO hub_tasks (task_name, task_start_date, task_end_date) VALUES (?, ?, ?)";
            $stmt = Db::getConnection()->prepare($insert_query);

            // Voer de query uit met de opgegeven waarden
            $stmt->execute([$task_name, $task_start_date, $task_end_date]);

            // Geef een succesvolle respons terug
            $data = [
                'status' => true,
                'msg' => 'Taak succesvol toegevoegd!'
            ];
        } catch(PDOException $e) {
            // Geef een foutmelding terug als er een fout optreedt bij het uitvoeren van de query
            $data = [
                'status' => false,
                'msg' => 'Er is een fout opgetreden bij het toevoegen van de taak: ' . $e->getMessage()
            ];
        }
    } else {
        // Ongeldige datums
        $data = [
            'status' => false,
            'msg' => 'Ongeldige datumformaat.'
        ];
    }
} else {
    // Niet alle vereiste velden zijn ingevuld
    $data = [
        'status' => false,
        'msg' => 'Niet alle vereiste velden zijn ingevuld.'
    ];
}

// Geef de JSON-respons terug
echo json_encode($data);
?>
