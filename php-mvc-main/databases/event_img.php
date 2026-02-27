<?php

function addImg(int $eid, string $path): bool|string
{
    global $conn;

    $sql = "INSERT INTO event_img (eid, image_path) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("is", $eid, $path);
    return $stmt->execute() ? true : ('DB execute failed: ' . $stmt->error);
}

function getImgs(int $eid): array
{
    global $conn;

    $sql = "SELECT image_path FROM event_img WHERE eid = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $eid);
    $stmt->execute();

    $res = $stmt->get_result();
    $imgs = [];
    while ($row = $res->fetch_assoc()) {
        $imgs[] = $row['image_path'];
    }

    return $imgs;
}