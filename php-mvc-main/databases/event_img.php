<?php
// databases/event_img.php

function addImage(int $event_id, string $image_path)
{
    global $conn;

    $sql = "INSERT INTO event_img (eid, image_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("is", $event_id, $image_path);

    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }

    $stmt->close();
    return true;
}