<?php

declare(strict_types=1);

// ฟังก์ชันสำหรับแสดงมุมมอง (view) โดยรับชื่อเทมเพลตและข้อมูลที่ต้องการส่งไปยังเทมเพลต
function renderView(string $template, array $data = []): void
{
    // ให้ตัวแปรจาก $data ใช้งานในเทมเพลตได้โดยตรง
    if (!empty($data) && is_array($data)) {
        extract($data, EXTR_SKIP);
    }
    include TEMPLATES_DIR . '/' . $template . '.php';
}
