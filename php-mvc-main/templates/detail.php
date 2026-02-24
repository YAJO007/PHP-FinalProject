<?php
// เทมเพลต detail ใช้ตัวแปร $event ที่ส่งมาจาก route
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title'] ?? 'รายละเอียดกิจกรรม'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white border-2 border-black rounded-[24px]
            shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]
            max-w-5xl w-full overflow-hidden">

        <div class="bg-purple-300 border-b-2 border-black px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-black text-purple-900">รายละเอียดกิจกรรม</h1>
            <a href="event" class="px-4 py-1 bg-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                ✖ ปิด
            </a>
        </div>

        <div class="p-8 bg-purple-100 grid md:grid-cols-2 gap-8">

            <div class="bg-purple-300 border-2 border-black rounded-xl shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                <img src="img/<?= htmlspecialchars($event['image_path']) ?>" class="w-full h-full object-cover" alt="<?php echo htmlspecialchars($event['title'] ?? ''); ?>">
            </div>

            <div class="space-y-4">
                <h2 class="text-3xl font-black text-purple-800"><?php echo htmlspecialchars($event['title'] ?? ''); ?></h2>

                <p class="text-gray-800 font-medium">
                    <?php echo nl2br(htmlspecialchars($event['Details'] ?? '')); ?>
                </p>

                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <p>📅 วันที่เริ่ม: <?php echo htmlspecialchars($event['start_date'] ?? ''); ?></p>
                    <p>📅 วันที่สิ้นสุด: <?php echo htmlspecialchars($event['end_date'] ?? ''); ?></p>
                    <p>👤 รับสมัคร: <?php echo htmlspecialchars($event['max_participants'] ?? ''); ?> คน</p>
                    <?php
                    $status = $event['status'] ?? '';
                    $statusBg = '';
                    $statusBorder = '';
                    $statusIcon = '';
                    $statusText = '';

                    switch ($status) {
                        case 'Upcoming':
                            $statusBg = 'bg-green-100';
                            $statusBorder = 'border-green-500';
                            $statusIcon = '&#x23F1;';
                            $statusText = 'กำลังจะมาถึง';
                            break;
                        case 'Live':
                            $statusBg = 'bg-yellow-100';
                            $statusBorder = 'border-yellow-500';
                            $statusIcon = '&#x1F534;';
                            $statusText = 'กำลังดำเนินอยู่';
                            break;
                        case 'Completed':
                            $statusBg = 'bg-red-100';
                            $statusBorder = 'border-red-500';
                            $statusIcon = '&#x2713;';
                            $statusText = 'จบแล้ว';
                            break;
                        default:
                            $statusBg = 'bg-gray-50';
                            $statusBorder = 'border-gray-400';
                            $statusIcon = '📋';
                            $statusText = $status;
                    }
                    ?>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 <?= $statusBg ?> <?= $statusBorder ?> shadow-sm">
                        <span class="text-xl"><?= $statusIcon ?></span>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">สถานะ</p>
                            <p class="font-bold text-sm"><?= $statusText ?></p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="grid grid-cols-4 gap-2 pt-2">
                    <button class="px-6 py-3 bg-purple-600 text-white border-2 border-black rounded-lg font-bold
                               shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                               hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-sm">
                        ✋ ร่วม
                    </button>

                </div>
            </div>

        </div>
    </div>


</body>

</html>