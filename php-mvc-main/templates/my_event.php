<?php 
$events = $events ?? [];
$stats = $stats ?? ['total' => 0, 'upcoming' => 0, 'running' => 0, 'finished' => 0]; ?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen p-4 flex">
    <div class="bg-white border-2 border-black rounded-[24px] shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] flex flex-col max-w-7xl mx-auto w-full"> <!-- NAV -->
        <div class="flex justify-between items-center border-b-2 border-black bg-purple-300 px-6 py-4">
            <div class="flex gap-4 flex-wrap"> <a href="event"><button class="px-6 py-2 bg-purple-500 text-white border-2 border-black rounded-lg font-bold">ค้นหา</button></a> <a href="my_event"><button class="px-6 py-2 bg-white border-2 border-black rounded-lg font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">กิจกรรมของฉัน</button></a> <a href="create_event"><button class="px-6 py-2 bg-purple-500 text-white border-2 border-black rounded-lg font-bold">สร้างกิจกรรม</button></a> <a href="profile"><button class="px-6 py-2 bg-white border-2 border-black rounded-lg font-bold">โปรไฟล์</button></a> </div>
        </div> <!-- DASHBOARD -->
        <div class="p-8 bg-purple-100 border-b-2 border-black">
            <div class="bg-purple-200 border-2 border-black rounded-xl p-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                <h2 class="text-3xl font-black mb-6 text-purple-900">🎮 กิจกรรมของฉัน</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white border-2 border-black p-4 rounded-lg">
                        <p class="font-bold">ทั้งหมด</p>
                        <p class="text-3xl font-black text-purple-600"><?= $stats['total'] ?></p>
                    </div>
                    <div class="bg-green-200 border-2 border-black p-4 rounded-lg">
                        <p class="font-bold">กำลังจะมาถึง</p>
                        <p class="text-3xl font-black"><?= $stats['upcoming'] ?></p>
                    </div>
                    <div class="bg-yellow-200 border-2 border-black p-4 rounded-lg">
                        <p class="font-bold">กำลังดำเนินอยู่</p>
                        <p class="text-3xl font-black"><?= $stats['running'] ?></p>
                    </div>
                    <div class="bg-red-200 border-2 border-black p-4 rounded-lg">
                        <p class="font-bold">จบแล้ว</p>
                        <p class="text-3xl font-black"><?= $stats['finished'] ?></p>
                    </div>
                </div>
            </div>
        </div> <!-- EVENT CARDS -->
        <div class="flex-1 bg-purple-100 p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> <?php if (empty($events)): ?> <p class="text-gray-600 font-bold">ไม่มีข้อมูลกิจกรรม</p> <?php else: ?> <?php foreach ($events as $e): ?> <div class="bg-white border-2 border-black rounded-xl p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:scale-105 transition-all">
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 h-32 rounded-lg mb-4 flex items-center justify-center text-white font-black"> 🎮 EVENT </div>
                            <h3 class="font-bold text-lg text-purple-800"><?= htmlspecialchars($e['title']) ?></h3>
                            <p class="text-sm"><?= htmlspecialchars($e['detail']) ?></p> <a href="activity?id=<?= $e['eid'] ?>"> <button class="mt-4 bg-purple-600 text-white px-4 py-2 border-2 border-black rounded-lg"> ดู </button> </a>
                        </div> <?php endforeach; ?> <?php endif; ?> </div>
        </div>
    </div>
</body>

</html>