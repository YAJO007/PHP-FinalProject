<?php

// Create OTP table if not exists
function createOtpTable(): bool|string
{
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS event_otp (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT NOT NULL,
        otp_code VARCHAR(6) NOT NULL,
        expires_at TIMESTAMP NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_event_id (event_id),
        INDEX idx_expires (expires_at)
    )";
    
    $result = $conn->query($sql);
    if (!$result) {
        return 'Error creating OTP table: ' . $conn->error;
    }
    
    return true;
}

// Save OTP to database
function saveEventOtp(int $eventId, string $otpCode, int $expiresInSeconds = 600): bool|string
{
    global $conn;
    
    // Clean up old OTPs for this event first
    $cleanupSql = "DELETE FROM event_otp WHERE event_id = ? OR expires_at < NOW()";
    $stmt = $conn->prepare($cleanupSql);
    if (!$stmt) {
        return 'Prepare cleanup failed: ' . $conn->error;
    }
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    
    // Insert new OTP
    $sql = "INSERT INTO event_otp (event_id, otp_code, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND))";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return 'Prepare insert failed: ' . $conn->error;
    }
    
    $stmt->bind_param("isi", $eventId, $otpCode, $expiresInSeconds);
    $result = $stmt->execute();
    
    if (!$result) {
        return 'Insert failed: ' . $stmt->error;
    }
    
    return true;
}

// Get valid OTP for event
function getEventOtp(int $eventId): ?array
{
    global $conn;
    
    $sql = "SELECT otp_code, expires_at, created_at FROM event_otp 
            WHERE event_id = ? AND expires_at > NOW() 
            ORDER BY created_at DESC LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return null;
    }
    
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $row = $result->fetch_assoc();
    return [
        'code' => $row['otp_code'],
        'expires' => strtotime($row['expires_at']),
        'created' => strtotime($row['created_at'])
    ];
}

// Verify OTP
function verifyEventOtp(int $eventId, string $otpCode): bool
{
    global $conn;
    
    $sql = "SELECT id FROM event_otp 
            WHERE event_id = ? AND otp_code = ? AND expires_at > NOW() 
            LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("is", $eventId, $otpCode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

// Clean up expired OTPs
function cleanupExpiredOtps(): bool
{
    global $conn;
    
    $sql = "DELETE FROM event_otp WHERE expires_at < NOW()";
    $result = $conn->query($sql);
    
    return $result !== false;
}

?>
