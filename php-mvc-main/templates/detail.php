<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

$mainImage = !empty($event['main_image'])
    ? 'uploads/' . $event['main_image']
    : 'img/event1.jpg';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen flex items-center justify-center p-6">

<div class="bg-white border-2 border-black rounded-[24px]
            shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]
            max-w-5xl w-full overflow-hidden">

    <!-- HEADER -->
    <div class="bg-purple-300 border-b-2 border-black px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-black text-purple-900">รายละเอียดกิจกรรม</h1>
        <a href="event"
           class="px-4 py-1 bg-white border-2 border-black rounded-lg font-bold">
            ✖ ปิด
        </a>
    </div>

    <!-- CONTENT -->
    <div class="p-8 bg-purple-100 grid md:grid-cols-2 gap-8">

        <!-- IMAGE -->
        <div class="bg-purple-300 border-2 border-black rounded-xl overflow-hidden
                    shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
            <img src="<?= htmlspecialchars($mainImage) ?>"
                 class="w-full h-full object-cover"
                 alt="<?= htmlspecialchars($event['title']) ?>">
        </div>

        <!-- INFO -->
        <div class="space-y-4">

            <h2 class="text-3xl font-black text-purple-800">
                <?= htmlspecialchars($event['title']) ?>
            </h2>

            <p class="text-gray-800">
                <?= nl2br(htmlspecialchars($event['Details'])) ?>
            </p>

            <!-- BASIC INFO -->
            <div class="bg-white border-2 border-black rounded-lg p-4">
                <p>📅 วันที่เริ่ม: <?= htmlspecialchars($event['start_date']) ?></p>
                <p>📅 วันที่สิ้นสุด: <?= htmlspecialchars($event['end_date']) ?></p>
                <p>👤 รับสมัคร: <?= htmlspecialchars($event['max_participants']) ?> คน</p>
                <p>🟢 สถานะ: <?= htmlspecialchars($event['status']) ?></p>
            </div>

            <!-- ADDRESS -->
            <?php if (!empty($event['address'])): ?>
                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <p class="font-bold mb-1">📍 สถานที่</p>
                    <p><?= htmlspecialchars($event['address']['Address_line']) ?></p>
                    <p>
                        <?= htmlspecialchars($event['address']['district']) ?>,
                        <?= htmlspecialchars($event['address']['province']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- REQUIREMENTS -->
            <?php if (!empty($event['requirements'])): ?>
                <div class="bg-white border-2 border-black rounded-lg p-4">
                    <p class="font-bold mb-2">📌 เงื่อนไขการเข้าร่วม</p>
                    <ul class="list-disc ml-6 space-y-1">
                        <?php foreach ($event['requirements'] as $req): ?>
                            <li><?= htmlspecialchars($req['requirement']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- JOIN BUTTON -->
            <button class="px-6 py-3 bg-purple-600 text-white border-2 border-black
                           rounded-lg font-bold
                           shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                ขอเข้าร่วมกิจกรรม
            </button>

        </div>
    </div>
</div>

</body>
</html>