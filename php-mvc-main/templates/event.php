<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหากิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen p-4 sm:p-8 font-sans text-black flex">

    <div class="bg-white border-2 border-black rounded-[24px]
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]
            flex flex-col overflow-hidden
            max-w-7xl mx-auto w-full">

        <!-- ===== TOP NAV ===== -->
        <div class="flex justify-between items-center
                border-b-2 border-black
                bg-purple-300 px-6 py-4">

            <!-- LEFT -->
            <div class="flex items-center gap-4 flex-wrap">
                <button class="px-6 py-2 bg-purple-600 text-white
                           border-2 border-black rounded-lg font-bold
                           shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1
                           hover:shadow-none transition-all duration-150">
                    ค้นหา
                </button>

                <a href="my_event">
                    <button class="px-6 py-2 bg-white border-2 border-black
                           rounded-lg font-bold hover:scale-110 transition-all">
                        กิจกรรมของฉัน
                    </button>
                </a>

                <a href="create_event">
                    <button class="px-6 py-2 bg-purple-500 text-white
                           border-2 border-black rounded-lg font-bold
                           hover:scale-110 transition-all">
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

            <!-- RIGHT -->
            <a href="home">
                <button class="px-6 py-2 bg-red-500 text-white
                           border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                    ออกจากระบบ
                </button>
            </a>
        </div>

        <!-- ===== SEARCH SECTION ===== -->
        <div class="p-8 bg-purple-100 border-b-2 border-black">
            <div class="bg-purple-200 border-2 border-black
                    rounded-xl p-6
                    shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">

                <h2 class="text-4xl font-black mb-6 text-purple-900">
                    ค้นหากิจกรรม
                </h2>

                <!-- Search -->
                <form action="event" method="get">
                    <div class="flex gap-3 mb-6">
                        <input type="text" placeholder="ค้นหากิจกรรม..." name="search"
                            class="flex-1 px-4 py-3 border-2 border-black
                              rounded-lg bg-white font-medium
                              focus:ring-4 focus:ring-purple-400">

                        <button type="submit" class="px-5 bg-purple-600 text-white
                               border-2 border-black rounded-lg font-bold
                               hover:scale-110 transition-all">
                            <i class="fa-solid fa-search"></i>
                        </button>

                    </div>

                    <!-- Date Filter -->
                    <div class="flex flex-wrap gap-6 items-center">

                        <div class="flex items-center gap-3">
                            <label class="font-bold text-purple-900">วันที่เริ่ม:</label>
                            <input type="date" name="start_date"
                                class="px-4 py-2 border-2 border-black
                                  rounded-lg bg-purple-500 text-white
                                  focus:ring-4 focus:ring-purple-300">
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="font-bold text-purple-900">วันที่สิ้นสุด:</label>
                            <input type="date" name="end_date"
                                class="px-4 py-2 border-2 border-black
                                  rounded-lg bg-white
                                  focus:ring-4 focus:ring-purple-300">
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- ===== CARD SECTION ===== -->
        <div class="flex-1 bg-purple-100 p-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <?php if (isset($data['result']) && $data['result']->num_rows > 0): ?>
                    <?php while ($event = $data['result']->fetch_assoc()): ?>

                        <div class="bg-white border-2 border-black rounded-xl
                    p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                    hover:scale-105 hover:-translate-y-2 transition-all">

                            <div class="bg-purple-300 h-40 rounded-lg mb-6 overflow-hidden">
                                <img src="img/<?= htmlspecialchars($event['image_path']) ?>"
                                    class="w-full h-full object-cover"
                                    alt="<?= htmlspecialchars($event['title']) ?>">
                            </div>

                            <h3 class="font-bold text-lg mb-2 text-purple-800">
                                <?= htmlspecialchars($event['title']) ?>
                            </h3>

                            <p class="text-sm text-gray-700 mb-3">
                                <?= htmlspecialchars($event['Details']) ?>
                            </p>

                            <!-- Participant Count -->
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fa-solid fa-users text-purple-600"></i>
                                <span class="text-sm font-bold text-purple-800">
                                    เข้าร่วมแล้ว: <?= (int)($event['approved_count'] ?? 0) ?> / <?= (int)($event['max_participants'] ?? 0) ?> คน
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                <?php 
                                $approved = (int)($event['approved_count'] ?? 0);
                                $max = (int)($event['max_participants'] ?? 1);
                                $percentage = min(($approved / $max) * 100, 100);
                                ?>
                                <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: <?= $percentage ?>%"></div>
                            </div>

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

                            <a href="detail?eid=<?= (int)$event['eid'] ?>">
                                <button class="px-5 bg-purple-600 text-white py-2 mt-4
                               border-2 border-black rounded-lg font-bold
                               hover:scale-110 transition-all">
                                    ดูรายละเอียด
                                </button>
                            </a>

                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-700">ไม่พบกิจกรรม</p>
                <?php endif; ?>

            </div>
        </div>

</body>

</html>