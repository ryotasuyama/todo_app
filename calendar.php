<?php
require 'db.php';

// データベースからタスクを取得
$stmt = $pdo->query('SELECT * FROM tasks');
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー表示</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                editable: false,
                events: <?php
                        $eventList = [];
                        foreach ($tasks as $task) {
                            if ($task['due_date']) {
                                $eventList[] = [
                                    'title' => htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'),
                                    'start' => htmlspecialchars($task['due_date'], ENT_QUOTES, 'UTF-8'),
                                    'allDay' => true
                                ];
                            }
                        }
                        echo json_encode($eventList);
                        ?>
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">タスクカレンダー</h1>
        <a href="index.php" class="btn btn-primary mt-3">戻る</a>
        <div id='calendar'></div>
    </div>
</body>

</html>