<?php

function addEvent(
    int $uid,
    string $title,
    int $maxP,
    string $sDate,
    string $eDate,
    string $sts,
    string $det
): int|string {
    global $conn;

    $sql = "INSERT INTO event (uid, title, max_participants, start_date, end_date, status, details, create_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param("isissss", $uid, $title, $maxP, $sDate, $eDate, $sts, $det);
    return $stmt->execute() ? $conn->insert_id : $stmt->error;
}

function getEvents(
    ?string $sDate = null,
    ?string $eDate = null,
    ?string $search = null
): mysqli_result {
    global $conn;

    $sql = "SELECT e.*, MIN(img.image_path) AS image_path,
            (SELECT COUNT(*) FROM user_event ue WHERE ue.eid = e.eid AND ue.status = 'Approved') AS approved_count,
            CASE
                WHEN e.start_date > CURDATE() THEN 'Upcoming'
                WHEN e.end_date < CURDATE() THEN 'Completed'
                ELSE 'Live'
            END AS event_status
            FROM event e
            LEFT JOIN event_img img ON e.eid = img.eid
            WHERE 1=1";

    $params = [];
    $types = "";

    if ($sDate) {
        $sql .= " AND e.start_date >= ?";
        $params[] = $sDate;
        $types .= "s";
    }
    if ($eDate) {
        $sql .= " AND e.start_date <= ?";
        $params[] = $eDate;
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

function getEventByUser(int $uid): mysqli_result
{
    global $conn;

    $sql = "SELECT e.*, MIN(img.image_path) AS image_path,
            CASE
                WHEN e.start_date > CURDATE() THEN 'Upcoming'
                WHEN e.end_date < CURDATE() THEN 'Completed'
                ELSE 'Live'
            END AS status
            FROM event e
            LEFT JOIN event_img img ON e.eid = img.eid
            WHERE e.uid = ?
            GROUP BY e.eid
            ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    return $stmt->get_result();
}

function getEventById(int $eid): ?array
{
    global $conn;

    $sql = "SELECT e.*,
            (SELECT img.image_path FROM event_img img WHERE img.eid = e.eid LIMIT 1) AS image_path
            FROM event e
            WHERE e.eid = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc() ?: null;
}

function updateEvent(
    int $eid,
    string $title,
    int $maxP,
    string $sDate,
    string $eDate,
    string $det
): bool|string {
    global $conn;

    $sql = "UPDATE event SET title = ?, max_participants = ?, start_date = ?, end_date = ?, details = ? WHERE eid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param("sisssi", $title, $maxP, $sDate, $eDate, $det, $eid);
    return $stmt->execute() ? true : $stmt->error;
}

function deleteEvent(int $eid): bool|string
{
    global $conn;

    $imgs = "DELETE FROM event_img WHERE eid = ?";
    $reg = "DELETE FROM user_event WHERE eid = ?";
    $evt = "DELETE FROM event WHERE eid = ?";

    foreach ([$imgs, $reg, $evt] as $sql) {
        $s = $conn->prepare($sql);
        if ($s) {
            $s->bind_param("i", $eid);
            $s->execute();
        }
    }

    return true;
}

function getEventParticipants(int $eid): mysqli_result
{
    global $conn;

    $sql = "SELECT u.uid, u.first_name, u.last_name, u.email, u.phone_number, ue.status
            FROM user_event ue
            JOIN user u ON ue.uid = u.uid
            WHERE ue.eid = ?
            ORDER BY ue.status, u.first_name ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    return $stmt->get_result();
}

function approveParticipant(int $eid, int $uid): bool|string
{
    global $conn;

    $sts = 'Approved';
    $sql = "UPDATE user_event SET status = ? WHERE eid = ? AND uid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param("sii", $sts, $eid, $uid);
    return $stmt->execute() ? true : $stmt->error;
}

function rejectParticipant(int $eid, int $uid): bool|string
{
    global $conn;

    $sts = 'Rejected';
    $sql = "UPDATE user_event SET status = ? WHERE eid = ? AND uid = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return 'DB prepare failed: ' . $conn->error;

    $stmt->bind_param("sii", $sts, $eid, $uid);
    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }

    $stmt->close();
    return true;
}

function getRejectionHistory(int $uid): array
{
    global $conn;

    $sql = "SELECT e.title, e.eid, ue.status
            FROM user_event ue
            JOIN event e ON ue.eid = e.eid
            WHERE ue.uid = ? AND ue.status = 'Rejected'
            ORDER BY ue.eid DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();

    $rejects = [];
    while ($row = $stmt->get_result()->fetch_assoc()) {
        $rejects[] = [
            'title' => $row['title'],
            'eid' => $row['eid'],
            'rejection_date' => 'N/A',
            'rejection_reason' => 'Rejected by organizer'
        ];
    }

    return $rejects;
}

function cancelReg(int $uid, int $eid): bool|string
{
    global $conn;

    $sql = "DELETE FROM user_event WHERE uid = ? AND eid = ? AND status = 'Pending'";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param("ii", $uid, $eid);
    return $stmt->execute() ? true : $stmt->error;
}

function updateEventStatus(): void
{
    global $conn;

    $sql = "UPDATE event
            SET status = CASE
                WHEN start_date > CURDATE() THEN 'Upcoming'
                WHEN end_date < CURDATE() THEN 'Completed'
                ELSE 'Live'
            END";

    $conn->query($sql);
}