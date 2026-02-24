<?php
// databases/event.php

function addEvent(
    int $uid,
    string $title,
    int $max_participants,
    string $start_date,
    string $end_date,
    string $status,
    string $details
): int|string {

    global $conn;

    $sql = "INSERT INTO event
        (uid, title, max_participants, start_date, end_date, status, details, create_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param(
        "isissss",
        $uid,
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $details
    );

    if ($stmt->execute()) {
        return $conn->insert_id;
    }

    return $stmt->error;
}

function getEvents(
    ?string $start_date = null,
    ?string $end_date = null,
    ?string $search = null
): mysqli_result {

    global $conn;

    $sql = "
        SELECT e.*,
               MIN(img.image_path) AS image_path,
               CASE
                   WHEN e.start_date > CURDATE() THEN 'กำลังจะมาถึง'
                   WHEN e.end_date < CURDATE() THEN 'จบแล้ว'
                   ELSE 'กำลังดำเนินอยู่'
               END AS event_status
        FROM event e
        LEFT JOIN event_img img ON e.eid = img.eid
        WHERE 1=1
    ";

    $params = [];
    $types = "";

    if ($start_date) {
        $sql .= " AND e.start_date >= ?";
        $params[] = $start_date;
        $types .= "s";
    }

    if ($end_date) {
        $sql .= " AND e.start_date <= ?";
        $params[] = $end_date;
        $types .= "s";
    }

    if ($search) {
        $sql .= " AND e.title LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }

    $sql .= " GROUP BY e.eid ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

function getEventByUserId(int $uid): mysqli_result
{
    global $conn;

    $sql = "SELECT 
    e.*,
    MIN(img.image_path) AS image_path,
    CASE
        WHEN e.start_date > CURDATE() THEN 'กำลังจะมาถึง'
        WHEN e.end_date < CURDATE() THEN 'จบแล้ว'
        ELSE 'กำลังดำเนินอยู่'
        END AS status
        FROM event e
        LEFT JOIN event_img img ON e.eid = img.eid
        WHERE e.uid = ?
        GROUP BY e.eid
        ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $uid);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventById(int $eid): ?array
{
    global $conn;

    $sql = "
        SELECT e.*,
               (
                   SELECT img.image_path
                   FROM event_img img
                   WHERE img.eid = e.eid
                   LIMIT 1
               ) AS image_path
        FROM event e
        WHERE e.eid = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}

function updateEvent(
    int $eid,
    string $title,
    int $max_participants,
    string $start_date,
    string $end_date,
    string $details
): bool|string {
    global $conn;

    $sql = "UPDATE event 
            SET title = ?, 
                max_participants = ?, 
                start_date = ?, 
                end_date = ?, 
                Details = ?
            WHERE eid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $conn->error;
    }

    $stmt->bind_param(
        "sisssi",
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $details,
        $eid
    );

    if ($stmt->execute()) {
        return true;
    }
    return $stmt->error;
}

function deleteEvent(int $eid): bool|string
{
    global $conn;

    // First delete related images
    $sql1 = "DELETE FROM event_img WHERE eid = ?";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1) {
        $stmt1->bind_param("i", $eid);
        $stmt1->execute();
    }

    // Delete user_event entries
    $sql2 = "DELETE FROM user_event WHERE eid = ?";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2) {
        $stmt2->bind_param("i", $eid);
        $stmt2->execute();
    }

    // Finally delete event
    $sql = "DELETE FROM event WHERE eid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $conn->error;
    }

    $stmt->bind_param("i", $eid);
    if ($stmt->execute()) {
        return true;
    }
    return $stmt->error;
}

/**
 * Get event participants with their request status
 */
function getEventParticipants(int $eid): mysqli_result
{
    global $conn;
    
    $sql = "SELECT u.uid, u.first_name, u.last_name, u.email, u.phone_number, 
                   ue.status
            FROM user_event ue
            JOIN user u ON ue.uid = u.uid
            WHERE ue.eid = ?
            ORDER BY ue.status, u.first_name ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Approve a participant request
 */
function approveParticipant(int $eid, int $uid): bool|string
{
    global $conn;
    
    $status = 'อนุมัติ';
    $sql = "UPDATE user_event SET status = ? WHERE eid = ? AND uid = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $conn->error;
    }
    
    $stmt->bind_param("sii", $status, $eid, $uid);
    if ($stmt->execute()) {
        return true;
    }
    return $stmt->error;
}

/**
 * Reject a participant request
 */
function rejectParticipant(int $eid, int $uid): bool|string
{
    global $conn;
    
    $sql = "DELETE FROM user_event WHERE eid = ? AND uid = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return $conn->error;
    }
    
    $stmt->bind_param("ii", $eid, $uid);
    if ($stmt->execute()) {
        return true;
    }
    return $stmt->error;
}

function updateEventStatus(): void
{
    global $conn;

    $sql = "
        UPDATE event
        SET status = CASE
            WHEN start_date > CURDATE() THEN 'กำลังจะมาถึง'
            WHEN end_date < CURDATE() THEN 'จบแล้ว'
            ELSE 'กำลังดำเนินอยู่'
        END
    ";

    $conn->query($sql);
}