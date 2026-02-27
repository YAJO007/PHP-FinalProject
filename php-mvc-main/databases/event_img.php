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

function getImagePath(int $event_id): ?string
{
    global $conn;

    $sql = "SELECT image_path FROM event_img WHERE eid = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['image_path'] ?? null;
}

function updateImage(int $event_id, string $new_image_path): bool|string
{
    global $conn;

    $sql = "UPDATE event_img SET image_path = ? WHERE eid = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("si", $new_image_path, $event_id);

    if (!$stmt->execute()) {
        return 'DB execute failed: ' . $stmt->error;
    }

    return true;
}

function deleteImage(int $event_id): bool|string
{
    global $conn;

    $sql = "DELETE FROM event_img WHERE eid = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }

    $stmt->bind_param("i", $event_id);

    if (!$stmt->execute()) {
        return 'DB execute failed: ' . $stmt->error;
    }

    return true;
}