<?php
// routes/generate_otp.php - Generate OTP for approved event registration

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

// Get user ID
if (!function_exists('getUseridbyEmail')) {
    require_once DATABASES_DIR . '/user.php';
}

if (!function_exists('getUserRegistrationStatus')) {
    require_once DATABASES_DIR . '/user_event.php';
}

if (!function_exists('hasAttended')) {
    require_once DATABASES_DIR . '/user_event.php';
}

$user_id = getUseridbyEmail($_SESSION['email']);
if (!$user_id) {
    $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้";
    header('Location: login');
    exit;
}

// Get event ID
$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    header('Location: my_registrations');
    exit;
}

// Check if already attended
if (hasAttended($user_id, $eid)) {
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'คุณได้เช็คชื่อเข้าร่วมงานแล้ว'
        ]);
        exit;
    }
    $_SESSION['error'] = "คุณได้เช็คชื่อเข้าร่วมงานแล้ว";
    header('Location: my_registrations');
    exit;
}

// Check if user is approved for this event
$status = getUserRegistrationStatus($user_id, $eid);
if ($status !== 'Approved') {
    $_SESSION['error'] = "คุณยังไม่ได้รับการอนุมัติสำหรับกิจกรรมนี้";
    header('Location: my_registrations');
    exit;
}

// Generate 6-digit OTP
$otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

// Store OTP in session with expiration (5 minutes)
$otp_key = "otp_{$eid}_{$user_id}";
$_SESSION[$otp_key] = [
    'code' => $otp,
    'expires' => time() + 300 // 5 minutes
];

// Return OTP as JSON for AJAX or redirect with OTP
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'otp' => $otp,
        'expires_in' => 300
    ]);
    exit;
}

// Redirect back with OTP in session
$_SESSION['generated_otp'] = $otp;
$_SESSION['otp_eid'] = $eid;
header('Location: my_registrations?otp_generated=1');
exit;
