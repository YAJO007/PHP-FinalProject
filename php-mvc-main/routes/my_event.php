<?php

updateEventStatus();

$user_id = getUseridbyEmail($_SESSION['email']);
$result = getEventByUserId($user_id);

// นับสถานะ
$total = 0;
$upcoming = 0;
$ongoing = 0;
$finished = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total++;

        switch ($row['status']) {
            case 'Upcoming':
                $upcoming++;
                break;
            case 'Live':
                $ongoing++;
                break;
            case 'Completed':
                $finished++;
                break;
        }
    }

    // reset pointer เพื่อเอาไปใช้ loop แสดง card ต่อ
    $result->data_seek(0);
}

renderView('my_event', [
    'result'   => $result,
    'total'    => $total,
    'upcoming' => $upcoming,
    'ongoing'  => $ongoing,
    'finished' => $finished
]);
