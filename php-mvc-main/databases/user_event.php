
<?php
//25/2/2026 11:03
//ต้องใช้ Database ตัวใหม่ที่ Export ให้
//หรือเข้าไปปรับเองที่ user_event ลบ ueid แล้วตั้งค่าให้ eid และ uid เป็น Primary key
//ป้องกันการป้อนข้อมูลซ้ำของ User

function addUserEvent(
    int $eid,
    int $uid,
): int|string {

    global $conn;

    $sql = "INSERT INTO user_event
        (eid, uid)
        VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) return $conn->error;

    $stmt->bind_param(
        "ii",
        $eid,
        $uid
    );

    try {
        // พยายามรันคำสั่ง Insert
        if ($stmt->execute()) {
            return $conn->insert_id ?: true; 
        }
    } catch (mysqli_sql_exception $e) {
        // ถ้าเกิด Error และ Error code คือ 1062 (ข้อมูลซ้ำ)
        if ($e->getCode() === 1062) {
            return false;
        }
        // ถ้าเป็น Error อื่นๆ ให้โยน Error ออกไปตามปกติ
        throw $e;
    }
    return $stmt->error;
}

//ยังไม่เคยลอง Test
function getUserEvent(
    ?string $eid = null,
    ?string $uid = null,
    ?string $status = null
): mysqli_result
{
    global $conn;

    $sql = "
        SELECT *
        FROM user_event WHERE 1=1
    ";

    $params = [];
    $types = "";

    if ($eid) {
        $sql .= " AND eid = ?";
        $params[] = $eid;
        $types .= "i";
    }

    if ($uid) {
        $sql .= " AND uid = ?";
        $params[] = $uid;
        $types .= "i";
    }

    if ($status) {
        $sql .= " AND status LIKE ?";
        $params[] = "%$status%";
        $types .= "s";
    }

    $sql .= "ORDER BY eid DESC";

    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

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

