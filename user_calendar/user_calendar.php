<?php
include_once(__DIR__ . "/data.php");
include_once(__DIR__ . "/../classes/Calendar.php");
$pdo = Data::getConnection();
$calendar = new Calendar($pdo);
$employees = [];
$locations = [];
try {
    // Query om werknemers op te halen
    $stmt = $pdo->query("SELECT id, firstname, lastname FROM employees");
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}
try {
    // Query om locaties op te halen
    $stmt = $pdo->query("SELECT * FROM hub_location");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>How to create dynamic task calendar in HTML and PHP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/nav.css">
</head>

<body>
    <?php include_once("user.nav.inc.php"); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5 align="center"></h5>
                <div class="btn-group" role="group" aria-label="Calendar View">
                    <button type="button" class="btn" onclick="changeView('month')">Month</button>
                    <button type="button" class="btn" onclick="changeView('agendaWeek')">Week</button>
                    <button type="button" class="btn" onclick="changeView('agendaDay')">Day</button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="task_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="task_name">Task Name</label>
                                    <input type="text" name="task_name" id="task_name" class="form-control" placeholder="Enter your task name">
                                    <input type="hidden" id="task_id" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="task_description">Description</label>
                                    <textarea name="task_description" id="task_description" class="form-control" placeholder="Enter task description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="task_start_date">Task Start</label>
                                    <input type="datetime-local" name="task_start_date" id="task_start_date" class="form-control" placeholder="Task start date">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="task_end_date">Task End</label>
                                    <input type="datetime-local" name="task_end_date" id="task_end_date" class="form-control" placeholder="Task end date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="assigned_to">Assign To</label>
                                    <select name="assigned_to" id="assigned_to" class="form-control">
                                        <?php foreach ($employees as $employee) : ?>
                                            <option value="<?php echo $employee['id']; ?>"><?php echo $employee['firstname'] . ' ' . $employee['lastname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <select name="location" id="location" class="form-control">
                                        <?php foreach ($locations as $location) : ?>
                                            <option value="<?php echo $location['id']; ?>"><?php echo $location['name'] . ', ' . $location['country']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_task()">Save Task</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Task Details Modal -->
    <div class="modal fade" id="task_details_modal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Task Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Task Name:</strong> <span id="details_task_name"></span></p>
                    <p><strong>Description:</strong> <span id="details_task_description"></span></p>
                    <p><strong>Start Date:</strong> <span id="details_task_start_date"></span></p>
                    <p><strong>End Date:</strong> <span id="details_task_end_date"></span></p>
                    <p><strong>Assigned To:</strong> <span id="details_assigned_to"></span></p>
                    <p><strong>Location:</strong> <span id="details_location"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            display_tasks();
        });

        function display_tasks() {
            $.ajax({
                url: 'user_display_task.php',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var events = [];
                        if (Array.isArray(response.data)) {
                            events = response.data.map(function(item) {
                                return {
                                    id: item.id,
                                    title: item.title,
                                    description: item.description,
                                    start: item.start,
                                    end: item.end,
                                    color: item.color,
                                    url: item.url,
                                    assigned_to: item.assigned_to,
                                    location: item.location
                                };
                            });
                            console.log(events);
                        }

                        $('#calendar').fullCalendar({
                            defaultView: 'month',
                            editable: true,
                            selectable: true,
                            selectHelper: true,
                            events: events,
                            select: function(start, end) {
                                $('#task_id').val('');
                                $('#task_name').val('');
                                $('#task_description').val('');
                                $('#task_start_date').val(moment(start).format('YYYY-MM-DDTHH:mm'));
                                $('#task_end_date').val(moment(end).format('YYYY-MM-DDTHH:mm'));
                                $('#assigned_to').val('');
                                $('#location').val('');
                                $('#task_entry_modal').modal('show');
                            },
                            eventClick: function(calEvent, jsEvent, view) {
                                $('#details_task_name').text(calEvent.title);
                                $('#details_task_description').text(calEvent.description);
                                $('#details_task_start_date').text(moment(calEvent.start).format('YYYY-MM-DD HH:mm'));
                                $('#details_task_end_date').text(moment(calEvent.end).format('YYYY-MM-DD HH:mm'));
                                $('#details_assigned_to').text(calEvent.assigned_to);
                                $('#details_location').text(calEvent.location);
                                $('#task_details_modal').modal('show');
                            }
                        });

                    } else {
                        alert('Error occurred: ' + response.msg);
                    }
                },
                error: function(xhr, status) {
                    console.error('Error occurred while fetching tasks: ' + status);
                }
            });
        }

        function save_task() {
            var task_id = $("#task_id").val();
            var task_name = $("#task_name").val();
            var task_description = $("#task_description").val();
            var task_start_date = $("#task_start_date").val();
            var task_end_date = $("#task_end_date").val();
            var assigned_to = $("#assigned_to").val();
            var selected_location = $("#location").val(); // Geselecteerde locatie

            if (task_name === "" || task_start_date === "" || task_end_date === "" || selected_location === "") {
                alert("Please enter all required details.");
                return false;
            }

            $.ajax({
                url: "user_save_task.php",
                type: "POST",
                dataType: 'json',
                data: {
                    task_name: task_name,
                    task_description: task_description,
                    task_start_date: task_start_date,
                    task_end_date: task_end_date,
                    assigned_to: assigned_to,
                    location: selected_location // Geselecteerde locatie toevoegen aan de gegevens
                },
                success: function(response) {
                    $('#task_entry_modal').modal('hide');
                    if (response.status === true) {
                        alert(response.msg);
                        window.location.reload();
                    } else {
                        alert(response.msg);
                    }
                },
                error: function(xhr, status) {
                    console.error('Error occurred while saving task: ' + status);
                }
            });
            return false;
        }

        function changeView(view) {
            $('#calendar').fullCalendar('changeView', view);
        }
    </script>
</body>

</html>