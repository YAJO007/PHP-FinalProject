<?php
$events = $events ?? [];
$stats  = $stats ?? ['total' => 0, 'upcoming' => 0, 'running' => 0, 'finished' => 0];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กิจกรรมของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 
             min-h-screen p-4 sm:p-8 font-sans text-black flex">

    <div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            flex flex-col overflow-hidden 
            max-w-7xl mx-auto w-full">

        <!-- ===== TOP NAV ===== -->
        <div class="flex justify-between items-center border-b-2 border-black bg-purple-300 px-6 py-4">

            <div class="flex items-center gap-4 flex-wrap">
                <a href="event">
                    <button class="px-6 py-2 bg-purple-500 text-white
                           border-2 border-black rounded-lg font-bold
                           hover:scale-110 transition-all">
                        ค้นหา
                    </button>
                </a>

                <a href="my_event">
                    <button class="px-6 py-2 bg-white
                           border-2 border-black rounded-lg font-bold
                           shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1
                           hover:shadow-none transition-all duration-150">
                        กิจกรรมของฉัน
                    </button>
                </a>

                <a href="create_event">
                    <button class="px-6 py-2 bg-purple-500 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                        สร้างกิจกรรม
                    </button>
                </a>

                <a href="profile">
                    <button class="px-6 py-2 bg-white border-2 border-black
                           rounded-lg font-bold hover:scale-110 transition-all">
                        โปรไฟล์
                    </button>
                </a>
                <a href="my_registrations">
                    <button class="px-6 py-2 bg-blue-600 text-white border-2 border-black
                           rounded-lg font-bold hover:scale-110 transition-all">
                        <i class="fa-solid fa-users"></i> ดูการลงทะเบียน
                    </button>
                </a>

            </div>

            <a href="home">
                <button class="px-6 py-2 bg-red-500 text-white
                           border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                    ออกจากระบบ
                </button>
            </a>
        </div>

        <!-- ================= MIDDLE CONTENT ================= -->

        <!-- DASHBOARD -->
        <div class="p-8 bg-purple-100 border-b-2 border-black">
            <div class="bg-purple-200 border-2 border-black rounded-xl p-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">

                <h2 class="text-4xl font-black mb-6 text-purple-900">
                    <i class="fa-solid fa-gamepad"></i> กิจกรรมของฉัน
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div class="bg-white border-2 border-black p-4 rounded-lg text-center">
                        <i class="fa-solid fa-calendar text-2xl text-purple-600 mb-2"></i>
                        <p class="font-bold">ทั้งหมด</p>
                        <p class="text-3xl font-black text-purple-600">
                            <?= $data['total'] ?>
                        </p>
                    </div>

                    <div class="bg-green-200 border-2 border-black p-4 rounded-lg text-center">
                        <i class="fa-regular fa-clock text-2xl text-green-600 mb-2"></i>
                        <p class="font-bold">กำลังจะมาถึง</p>
                        <p class="text-3xl font-black">
                            <?= $data['upcoming'] ?>
                        </p>
                    </div>

                    <div class="bg-yellow-200 border-2 border-black p-4 rounded-lg text-center">
                        <i class="fa-solid fa-hourglass-start text-2xl text-yellow-600 mb-2"></i>
                        <p class="font-bold">กำลังดำเนินอยู่</p>
                        <p class="text-3xl font-black">
                            <?= $data['ongoing'] ?>
                        </p>
                    </div>

                    <div class="bg-red-200 border-2 border-black p-4 rounded-lg text-center">
                        <i class="fa-solid fa-check-circle text-2xl text-red-600 mb-2"></i>
                        <p class="font-bold">จบแล้ว</p>
                        <p class="text-3xl font-black">
                            <?= $data['finished'] ?>
                        </p>
                    </div>

                </div>

            </div>
        </div>

        <!-- GAME CARDS -->
        <div class="flex-1 bg-purple-100 p-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

                <?php if (isset($data['result']) && $data['result']->num_rows > 0): ?>
                    <?php while ($event = $data['result']->fetch_assoc()): ?>

                        <!-- Card -->
                        <div class="bg-white border-2 border-black rounded-xl
                            p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                            hover:scale-105 hover:-translate-y-2 transition-all">

                            <!-- Image -->
                            <div class="bg-purple-300 h-40 rounded-lg mb-6 overflow-hidden">
                                <img
                                    src="img/<?= htmlspecialchars($event['image_path']) ?>"
                                    alt="<?= htmlspecialchars($event['title']) ?>"
                                    class="w-full h-full object-cover">
                            </div>

                            <!-- Title -->
                            <h3 class="font-bold text-lg mb-2 text-purple-800">
                                <?= htmlspecialchars($event['title']) ?>
                            </h3>

                            <!-- Details -->
                            <p class="text-sm text-gray-700 mb-2 line-clamp-3">
                                <?= htmlspecialchars($event['Details']) ?>
                            </p>

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
                                    $statusIcon = '<i class="fa-regular fa-clock"></i>';
                                    $statusText = 'กำลังจะมาถึง';
                                    break;
                                case 'Live':
                                    $statusBg = 'bg-yellow-100';
                                    $statusBorder = 'border-red-500';
                                    $statusIcon = '<i class="fa-solid fa-hourglass-start"></i>';
                                    $statusText = 'กำลังดำเนินอยู่';
                                    break;
                                case 'Completed':
                                    $statusBg = 'bg-red-100';
                                    $statusBorder = 'border-red-500';
                                    $statusIcon = '<i class="fa-solid fa-check-circle"></i>';
                                    $statusText = 'จบแล้ว';
                                    break;
                                default:
                                    $statusBg = 'bg-gray-50';
                                    $statusBorder = 'border-gray-400';
                                    $statusIcon = '<i class="fa-solid fa-clipboard"></i>';
                                    $statusText = $status;
                            }
                            ?>
                            <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border <?= $statusBg ?> <?= $statusBorder ?> shadow-sm">
                                <span class="text-lg"><?= $statusIcon ?></span>
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">สถานะ</p>
                                    <p class="font-bold text-xs"><?= $statusText ?></p>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <a href="manage_event?eid=<?php echo htmlspecialchars($event['eid']); ?>" class="col-span-1">
                                    <button type="button" class="w-full px-6 py-3 bg-indigo-600 text-white border-2 border-black rounded-lg font-bold
                                   shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                   hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-chart-bar"></i>
                                        จัดการ
                                    </button>
                                </a>

                                <a href="edit_event?eid=<?= $event['eid'] ?>">
                                    <button class="px-3 bg-yellow-300 border-2 border-black rounded-lg font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-edit"></i>
                                        แก้ไข
                                    </button>
                                </a>

                                <a href="delete_event?eid=<?= $event['eid'] ?>" onclick="return confirm('ลบกิจกรรมนี้?')">
                                    <button class="px-3 bg-red-400 border-2 border-black rounded-lg font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-trash"></i>
                                        ลบ
                                    </button>
                                </a>
                            </div>

                        </div>

                    <?php endwhile; ?>
                <?php else: ?>

                    <p class="col-span-full text-center text-gray-700 text-lg font-bold">
                        ไม่พบกิจกรรม
                    </p>

                <?php endif; ?>

            </div>
        </div>

    </div>
</body>

</html>