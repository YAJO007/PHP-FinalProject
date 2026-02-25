<?php
// routes/my_registrations.php - Show user's event registrations

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

// Get user ID
if (!function_exists('getUseridbyEmail')) {
    require_once DATABASES_DIR . '/user.php';
}

if (!function_exists('getEvents')) {
    require_once DATABASES_DIR . '/event.php';
}

if (!function_exists('isUserRegistered')) {
    require_once DATABASES_DIR . '/user_event.php';
}

if (!function_exists('getUserRegistrationStatus')) {
    require_once DATABASES_DIR . '/user_event.php';
}

if (!function_exists('getUserRejectionHistory')) {
    require_once DATABASES_DIR . '/event.php';
}

$user_id = getUseridbyEmail($_SESSION['email']);
if (!$user_id) {
    $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้";
    header('Location: login');
    exit;
}

// Get all events the user has registered for
$registrations = [];
$all_events = getEvents(); // Get all events

if ($all_events && $all_events->num_rows > 0) {
    while ($event = $all_events->fetch_assoc()) {
        // Check if user is registered for this event
        if (isUserRegistered($user_id, (int)$event['eid'])) {
            $event['registration_status'] = getUserRegistrationStatus($user_id, (int)$event['eid']);
            $registrations[] = $event;
        }
    }
}

// Get rejection history
$rejection_history = getUserRejectionHistory($user_id);

// Render the my_registrations template
renderView('my_registrations', [
    'registrations' => $registrations,
    'rejection_history' => $rejection_history
]);

?>
