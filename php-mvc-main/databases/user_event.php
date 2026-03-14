<?php

function registerEvent(int $uid, int $eid): bool|string
{
    global $conn;

    $check = "SELECT uid FROM user_event WHERE uid = ? AND eid = ?";
    $chk = $conn->prepare($check);
    $chk->bind_param("ii", $uid, $eid);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        return "คุณได้ลงทะเบียนเข้าร่วมกิจกรรมนี้แล้ว";
    }

    $sql = "INSERT INTO user_event (uid, eid, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return 'DB prepare failed: ' . $conn->error;

    $stmt->bind_param("ii", $uid, $eid);
    return $stmt->execute() ? true : ('DB execute failed: ' . $stmt->error);
}

function isUserReg(int $uid, int $eid): bool
{
    global $conn;

    $sql = "SELECT uid FROM user_event WHERE uid = ? AND eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();

    return $stmt->get_result()->num_rows > 0;
}

function getUserRegStatus(int $uid, int $eid): ?string
{
    global $conn;

    $sql = "SELECT status FROM user_event WHERE uid = ? AND eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $uid, $eid);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();
    return $row ? $row['status'] : null;
}
