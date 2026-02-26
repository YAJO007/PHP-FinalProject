<?php
// routes/verify_otp.php - Verify OTP for event check-in

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

// Get event ID and OTP from POST
$eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
$otp_input = isset($_POST['otp']) ? trim($_POST['otp']) : '';

if ($eid <= 0 || empty($otp_input)) {
    header('Location: manage_event?eid=' . $eid . '&error=invalid_input');
    exit;
}

// Search for matching OTP in session
$found = false;
$participant_info = null;
$participant_uid = null;

// Load user functions
if (!function_exists('getUserById')) {
    require_once DATABASES_DIR . '/user.php';
}

if (!function_exists('markAsAttended')) {
    require_once DATABASES_DIR . '/user_event.php';
}

if (!function_exists('hasAttended')) {
    require_once DATABASES_DIR . '/user_event.php';
}

// Check all OTP sessions for this event
foreach ($_SESSION as $key => $value) {
    if (strpos($key, "otp_{$eid}_") === 0 && is_array($value)) {
        // Check if OTP matches and not expired
        if ($value['code'] === $otp_input && $value['expires'] > time()) {
            // Extract user ID from key
            $parts = explode('_', $key);
            $participant_uid = (int)end($parts);
            
            // Check if already attended
            if (hasAttended($participant_uid, $eid)) {
                $_SESSION['checkin_error'] = 'ผู้เข้าร่วมท่านนี้เช็คชื่อเข้าร่วมงานแล้ว';
                header('Location: manage_event?eid=' . $eid . '&error=already_attended');
                exit;
            }
            
            // Get user info
            $participant_info = getUserById($participant_uid);
            $found = true;
            
            // Clear the used OTP
            unset($_SESSION[$key]);
            break;
        }
    }
}

if ($found && $participant_info && $participant_uid) {
    // Mark as attended
    markAsAttended($participant_uid, $eid);
    
    // Success - redirect with participant info
    $_SESSION['checkin_success'] = [
        'name' => $participant_info['first_name'] . ' ' . $participant_info['last_name'],
        'email' => $participant_info['email'],
        'time' => date('H:i:s')
    ];
    header('Location: manage_event?eid=' . $eid . '&checkin=success');
} else {
    // Failed - OTP not found or expired
    header('Location: manage_event?eid=' . $eid . '&error=invalid_otp');
}
exit;

