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

function getEventImages(int $eid): array
{
    global $conn;
    
    $sql = "SELECT image_path FROM event_img WHERE eid = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return [];
    }
    
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    
    $images = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
    }
    
    $stmt->close();
    return $images;
}