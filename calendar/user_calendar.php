<!DOCTYPE html>
<html>

<head>
    <title>How to create dynamic task calendar in HTML and PHP</title>
    <!-- CSS for full calendar -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS for full calendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- bootstrap css and js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5 align="center"></h5>
                <div id="calendar"></div> <!-- Controleer of de juiste ID "calendar" wordt gebruikt -->
            </div>
        </div>
    </div>
    <!-- Start popup dialog box -->
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="task_start_date">Task Start</label>
                                    <input type="date" name="task_start_date" id="task_start_date" class="form-control onlydatepicker" placeholder="Task start date">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="task_end_date">Task End</label>
                                    <input type="date" name="task_end_date" id="task_end_date" class="form-control" placeholder="Task end date">
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
    <!-- End popup dialog box -->

    <script>
        $(document).ready(function() {
            display_tasks();
        });

        function display_tasks() {
            $.ajax({
                url: 'display_task.php',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var events = [];

                        if (Array.isArray(response.data)) {
                            events = response.data.map(function(item) {
                                return {
                                    id: item.id,
                                    title: item.title,
                                    start: item.start,
                                    end: item.end,
                                    color: item.color,
                                    url: item.url
                                };
                            });
                            console.log(events);
                            console.log("yo");
                        } else {
                            // Als response.data geen array is, voeg het enkele object toe aan events
                            events.push({
                                id: response.data.id,
                                title: response.data.title,
                                start: response.data.start,
                                end: response.data.end,
                                color: response.data.color,
                                url: response.data.url
                            });
                            console.log("hier");

                            events.push({
                                id: 2222,
                                title: "yoyo",
                                start: new Date(),
                                end: new Date(),
                                color: "red",
                                url: "#"
                            });
                        }

                        $('#calendar').fullCalendar({
                            defaultView: 'month',
                            editable: true,
                            selectable: true,
                            selectHelper: true,
                            events: events,
                            select: function(start, end) {
                                $('#task_start_date').val(moment(start).format('YYYY-MM-DD'));
                                $('#task_end_date').val(moment(end).format('YYYY-MM-DD'));
                                $('#task_entry_modal').modal('show');
                            },
                            eventClick: function(calEvent, jsEvent, view) {
                                alert('Event: ' + calEvent.title);
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
            var task_name = $("#task_name").val();
            var task_start_date = $("#task_start_date").val();
            var task_end_date = $("#task_end_date").val();

            console.log("Task Name:", task_name);
            console.log("Task Start Date:", task_start_date);
            console.log("Task End Date:", task_end_date);

            if (task_name === "" || task_start_date === "" || task_end_date === "") {
                alert("Please enter all required details.");
                return false;
            }

            $.ajax({
                url: "save_task.php",
                type: "POST",
                dataType: 'json',
                data: {
                    task_name: task_name,
                    task_start_date: task_start_date,
                    task_end_date: task_end_date
                },
                success: function(response) {
                    $('#task_entry_modal').modal('hide');
                    if (response.status === true) {
                        alert(response.msg);
                        location.reload();
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
    </script>
</body>

</html>