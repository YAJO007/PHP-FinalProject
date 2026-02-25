<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    
    if ($eid <= 0) {
        $_SESSION['error'] = "ข้อมูลกิจกรรมไม่ถูกต้อง";
        header('Location: event');
        exit;
    }
    
    // Get user ID
    if (!function_exists('getUseridbyEmail')) {
        require_once DATABASES_DIR . '/user.php';
    }
    
    $uid = getUseridbyEmail($_SESSION['email']);
    
    if (!$uid) {
        $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้";
        header('Location: event');
        exit;
    }
    
    // Load user_event functions
    if (!function_exists('registerForEvent')) {
        require_once DATABASES_DIR . '/ีuser_event.php';
    }
    
    // Register for event
    $result = registerForEvent($uid, $eid);
    
    if ($result === true) {
        $_SESSION['success'] = "ลงทะเบียนเข้าร่วมกิจกรรมสำเร็จแล้ว กรุณารอการอนุมัติจากผู้จัดงาน";
    } else {
        $_SESSION['error'] = $result;
    }
    
    header('Location: detail?eid=' . $eid);
    exit;
} else {
    // Redirect if not POST request
    header('Location: event');
    exit;
}

?>
