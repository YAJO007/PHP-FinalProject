<?php
// databases/event.php

function addEvent(
    int $uid,
    string $title,
    int $max_participants,
    string $start_date,
    string $end_date,
    string $status,
    string $details,
    string $create_at
): int|string {

    global $conn;

    $sql = "INSERT INTO event
            (uid, title, max_participants, start_date, end_date, status, Details, create_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $conn->error;
    }

    $stmt->bind_param(
        "isisssss",
        $uid,
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $details,
        $create_at
    );

    if ($stmt->execute()) {
        return $conn->insert_id; // ✅ คืน event_id
    }

    return $stmt->error;
}

function getEvents($start_date = null, $end_date = null, $search = null): mysqli_result
{
    global $conn;
    
    // 1. ตั้งต้น SQL และตัวแปรเก็บ Parameter
    $sql = "SELECT  e.*,
                    MIN(image_path) as image_path
            FROM event e
            LEFT JOIN event_img img ON e.eid = img.eid 
            WHERE 1=1";
    $params = [];
    $types = "";

    // 2. ตรวจสอบและต่อเงื่อนไข (ใช้ && $start_date !== '' เพื่อกันกรณีค่าว่างจาก Form)
    if (!empty($start_date)) {
        $sql .= " AND start_date >= ?";
        $params[] = $start_date;
        $types .= "s";
    }

    if (!empty($end_date)) {
        $sql .= " AND start_date <= ?"; // หรือ end_date แล้วแต่โครงสร้างตาราง
        $params[] = $end_date;
        $types .= "s";
    }

    if (!empty($search)) {
        $sql .= " AND title LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    $sql .= " GROUP BY e.eid ORDER BY e.start_date DESC";

    // 3. เตรียม Statement
    $stmt = $conn->prepare($sql);
    
    // 4. ถ้ามีเงื่อนไข ให้ Bind Parameter
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    // 5. ถ้าไม่มีเงื่อนไขเลย ให้ Query ตรงๆ
    return $conn->query($sql);
}

function getEventById(int $eid): ?array
{
    global $conn;

    $sql = "SELECT e.*, 
                   GROUP_CONCAT(img.image_path) AS images
            FROM event e
            LEFT JOIN event_img img ON e.eid = img.eid
            WHERE e.eid = ?
            GROUP BY e.eid";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $eid);
    if (!$stmt->execute()) {
        return null;
    }

    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}