<?php

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['email'])) {
    header('Location: /login');
    exit;
}

// ตรวจสอบว่าเป็น POST request หรือไม่
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /my_registrations');
    exit;
}

// รับข้อมูลจากฟอร์ม
$eid = $_POST['eid'] ?? null;
$user_email = $_SESSION['email'];

if (!$eid) {
    header('Location: /my_registrations');
    exit;
}

// ดึงข้อมูลผู้ใช้
$userId = getUseridbyEmail($user_email);
if (!$userId) {
    header('Location: /my_registrations');
    exit;
}

try {
    // เรียกฟังก์ชันยกเลิกการลงทะเบียน
    $result = cancelRegistration($userId, (int)$eid);
    
    if ($result === true) {
        // ยกเลิกสำเร็จ ไปหน้า my_registrations
        header('Location: /my_registrations');
        exit;
    } else {
        // มีข้อผิดพลาด
        header('Location: /my_registrations?error=' . urlencode($result));
        exit;
    }
} catch (Exception $e) {
    // มีข้อผิดพลาด
    header('Location: /my_registrations?error=' . urlencode('เกิดข้อผิดพลาด: ' . $e->getMessage()));
    exit;
}
