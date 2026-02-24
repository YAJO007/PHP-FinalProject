<?php
// เทมเพลต detail ใช้ตัวแปร $event ที่ส่งมาจาก route
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

// ตัวอย่างการเลือกภาพหลัก
$mainImage = !empty($event['images']) ? $event['images'][0] : 'img/event1.jpg';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title'] ?? 'รายละเอียดกิจกรรม'); ?></title>
</head>
<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen flex items-center justify-center p-6">

<div class="bg-white border-2 border-black rounded-[24px]
            shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]
            max-w-5xl w-full overflow-hidden">

    <!-- Header -->
    <div class="bg-purple-300 border-b-2 border-black px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-black text-purple-900">รายละเอียดกิจกรรม</h1>
        <a href="event" class="px-4 py-1 bg-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
            ✖ ปิด
        </a>
    </div>

    <!-- Content -->
    <div class="p-8 bg-purple-100 grid md:grid-cols-2 gap-8">

        <!-- Image -->
        <div class="bg-purple-300 border-2 border-black rounded-xl shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            <img src="<?php echo htmlspecialchars($mainImage); ?>" class="w-full h-full object-cover" alt="<?php echo htmlspecialchars($event['title'] ?? ''); ?>">
        </div>

        <!-- Info -->
        <div class="space-y-4">
            <h2 class="text-3xl font-black text-purple-800"><?php echo htmlspecialchars($event['title'] ?? ''); ?></h2>

            <p class="text-gray-800 font-medium">
                <?php echo nl2br(htmlspecialchars($event['Details'] ?? '')); ?>
            </p>

            <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <p>📅 วันที่เริ่ม: <?php echo htmlspecialchars($event['start_date'] ?? ''); ?></p>
                <p>📅 วันที่สิ้นสุด: <?php echo htmlspecialchars($event['end_date'] ?? ''); ?></p>
                <p>👤 รับสมัคร: <?php echo htmlspecialchars($event['max_participants'] ?? ''); ?> คน</p>
                <p>🟢 สถานะ: <?php echo htmlspecialchars($event['status'] ?? ''); ?></p>
            </div>

            <!-- Button -->
            <button class="px-6 py-3 bg-purple-600 text-white border-2 border-black rounded-lg font-bold
                           shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                ขอเข้าร่วมกิจกรรม
            </button>
        </div>

    </div>
</div>

</body>
</html>