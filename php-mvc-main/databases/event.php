<?php
// databases/event.php

function addEvent(
    int $user_id,
    string $title,
    int $max_participants,
    string $start_date,
    string $end_date,
    string $status,
    string $details,
    string $creator_at
) {
    global $conn;
    $creator_at = date('Y-m-d H:i:s');
    $sql = "INSERT INTO event
            (uid, title, max_participants, start_date, end_date, status, details, creator_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param(
        "isisssss",
        $user_id,
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $details,
        $creator_at
    );

    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }

    $stmt->close();
    return true;
}

function getEvents(): mysqli_result
{
    global $conn;
    return $conn->query("SELECT * FROM event ORDER BY start_date DESC");
}