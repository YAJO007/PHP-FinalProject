<?php

// File-based attendance storage (persists across sessions)

/**
 * Get the path to the attendance file for an event.
 */
function getAttendanceFilePath(int $eventId): string
{
    return __DIR__ . "/../storage/attendance_{$eventId}.json";
}

/**
 * Load all attendance records for an event from file.
 */
function loadAttendance(int $eventId): array
{
    $file = getAttendanceFilePath($eventId);
    if (!file_exists($file)) {
        return [];
    }
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

/**
 * Save attendance records for an event to file.
 */
function saveAttendance(int $eventId, array $records): bool
{
    $storageDir = __DIR__ . '/../storage';
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0755, true);
    }
    return file_put_contents(getAttendanceFilePath($eventId), json_encode($records)) !== false;
}

/**
 * Check if a user has already checked in to an event.
 */
function isUserCheckedIn(int $userId, int $eventId): bool
{
    $records = loadAttendance($eventId);
    return isset($records[$userId]);
}

/**
 * Record a user's attendance for an event.
 */
function recordAttendance(int $eventId, int $userId, string $otpCode): bool
{
    $records = loadAttendance($eventId);
    $records[$userId] = [
        'event_id'     => $eventId,
        'user_id'      => $userId,
        'otp_used'     => $otpCode,
        'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'checked_in_at' => date('Y-m-d H:i:s'),
    ];
    return saveAttendance($eventId, $records);
}

/**
 * Get the number of users who have checked in to an event.
 */
function getAttendanceCount(int $eventId): int
{
    return count(loadAttendance($eventId));
}

/**
 * Get all attendance records for an event.
 */
function getAttendedUsers(int $eventId): array
{
    return array_values(loadAttendance($eventId));
}
