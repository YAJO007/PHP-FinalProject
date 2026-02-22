<?php
function addEvent($title,
    $max_participants,
    $start_date,
    $end_date,
    $status,
    $category,
    $details,
    $creator_email)
{
    global $conn;

    $sql = "INSERT INTO events
            (title, max_participants, start_date, end_date, status, category, details, creator_email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";   
        

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $bind = $stmt->bind_param(
        "sissssss",
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $category,
        $details,
        $creator_email
    );

    if ($bind === false) {
        $stmt->close();
        return 'DB bind failed: ' . $stmt->error;
    }

    try {
        $exec = $stmt->execute();
        if ($exec === false) {
            $err = $stmt->error;
            $stmt->close();
            return 'DB execute failed: ' . $err;
        }
        $stmt->close();
        return true;
    } catch (mysqli_sql_exception $e) {
        $stmt->close();
        return "DB ERROR: " . $e->getMessage();
    }
}