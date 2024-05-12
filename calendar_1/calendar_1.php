<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Calendar</title>
    <style>
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    border-collapse: collapse;
    width: 100%;
}

.calendar-header {
    font-weight: bold;
}

.calendar-cell {
    border: 1px solid #ccc;
    padding: 10px;
}

.date {
    font-weight: bold;
}

.task {
    margin-top: 5px;
}

    </style>
</head>
<body>
    <h1>Task Calendar</h1>
    <div id="calendar"></div>

    <script>
	function createCalendar(tasks, viewMode, startDate) {
    const calendarDiv = document.getElementById('calendar');

    // Reset de kalenderdiv
    calendarDiv.innerHTML = '';

    // Definieer de weergavemodi
    const viewModes = {
        monthly: 'monthly',
        weekly: 'weekly',
        daily: 'daily'
    };

    // Bepaal het start- en einddatumbereik op basis van de weergavemodus
    let endDate = new Date(startDate);
    switch (viewMode) {
        case viewModes.monthly:
            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
            break;
        case viewModes.weekly:
            endDate.setDate(startDate.getDate() + 6);
            break;
        case viewModes.daily:
            endDate = new Date(startDate);
            break;
        default:
            console.error('Ongeldige weergavemodus');
            return;
    }

    // Maak de kop van de kalender met de dagen van de week
    if (viewMode !== viewModes.daily) {
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        let headerRow = '<div class="calendar-header">';
        daysOfWeek.forEach(day => {
            headerRow += `<div class="calendar-cell">${day}</div>`;
        });
        headerRow += '</div>';
        calendarDiv.innerHTML += headerRow;
    }

    // Loop door elke dag in het opgegeven bereik en toon de taken
    for (let date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 1)) {
        let dayCell = '<div class="calendar-cell">';
        if (viewMode === viewModes.daily) {
            dayCell += `<div class="date">${date.toDateString()}</div>`;
        } else {
            dayCell += `<div class="date">${date.getDate()}</div>`;
        }

        // Filter taken die op deze dag beginnen
        const tasksForDay = tasks.filter(task => {
            const taskStartDate = new Date(task.task_start_date);
            return taskStartDate.toDateString() === date.toDateString();
        });

        // Voeg taken toe aan de dagcel
        tasksForDay.forEach(task => {
            dayCell += `<div class="task">${task.task_name}</div>`;
        });

        dayCell += '</div>';

        // Voeg de dagcel toe aan de kalenderdiv
        calendarDiv.innerHTML += dayCell;
    }
}

    </script>
</body>
</html>
