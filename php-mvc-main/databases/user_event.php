<?php

function registerForEvent(int $uid, int $eid): bool|string
{
    global $conn;
    
    // Check if user is already registered
    $check_sql = "SELECT uid FROM user_event WHERE uid = ? AND eid = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $uid, $eid);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        return "คุณได้ลงทะเบียนเข้าร่วมกิจกรรมนี้แล้ว";
    }
    
    // Insert registration
    $sql = "INSERT INTO user_event (uid, eid, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        return 'DB prepare failed: ' . $conn->error;
    }
    
    $stmt->bind_param("ii", $uid, $eid);
    
    if (!$stmt->execute()) {
        $err = $stmt->error;
        $stmt->close();
        return 'DB execute failed: ' . $err;
    }
    
    $stmt->close();
    return true;
}

/**
 * Check if user is registered for an event
 */
function isUserRegistered(int $uid, int $eid): bool
{
    global $conn;
    
    $sql = "SELECT uid FROM user_event WHERE uid = ? AND eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();
    
    return $stmt->get_result()->num_rows > 0;
}

/**
 * Get user's registration status for an event
 */
function getUserRegistrationStatus(int $uid, int $eid): ?string
{
    global $conn;
    
    $sql = "SELECT status FROM user_event WHERE uid = ? AND eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['status'];
    }
    
    return null;
}

/**
 * Mark user as attended for an event (stored in session only)
 */
function markAsAttended(int $uid, int $eid): bool
{
    // Store attendance in session
    if (!isset($_SESSION['attended_events'])) {
        $_SESSION['attended_events'] = [];
    }
    
    $key = "{$eid}_{$uid}";
    $_SESSION['attended_events'][$key] = [
        'eid' => $eid,
        'uid' => $uid,
        'timestamp' => time()
    ];
    
    return true;
}

/**
 * Check if user has attended the event (from session)
 */
function hasAttended(int $uid, int $eid): bool
{
    if (!isset($_SESSION['attended_events'])) {
        return false;
    }
    
    $key = "{$eid}_{$uid}";
    return isset($_SESSION['attended_events'][$key]);
}

/**
 * Get all attended users for an event (from session)
 */
function getAttendedUsers(int $eid): array
{
    if (!isset($_SESSION['attended_events'])) {
        return [];
    }
    
    $attended = [];
    foreach ($_SESSION['attended_events'] as $key => $data) {
        if ($data['eid'] === $eid) {
            $attended[] = $data;
        }
    }
    
    return $attended;
}

?>