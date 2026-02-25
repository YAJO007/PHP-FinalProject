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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
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
                    <?php if (!empty($event['address'])): ?>
                        <p>📍 สถานที่: 
                            <?php 
                            $address_parts = [];
                            if (!empty($event['address']['Address_line'])) $address_parts[] = htmlspecialchars($event['address']['Address_line']);
                            if (!empty($event['address']['district'])) $address_parts[] = htmlspecialchars($event['address']['district']);
                            if (!empty($event['address']['province'])) $address_parts[] = htmlspecialchars($event['address']['province']);
                            echo implode(', ', $address_parts);
                            ?>
                        </p>
                    <?php endif; ?>
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
                            $statusBorder = 'border-yellow-500';
                            $statusIcon = '<i class="fa-solid fa-hourglass-start"></i>';
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
                            $statusIcon = '<i class="fa-solid fa-clipboard"></i>';
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

                <?php if (!empty($event['requirements'])): ?>
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <h3 class="font-bold text-lg mb-3 text-purple-800">
                            <i class="fa-solid fa-list-check"></i> ความต้องการ
                        </h3>
                        <div class="space-y-2">
                            <?php foreach ($event['requirements'] as $requirement): ?>
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-check-circle text-green-600 mt-1"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($requirement) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php 
                // Check if user is logged in
                $is_logged_in = isset($_SESSION['email']);
                $user_id = $is_logged_in ? getUseridbyEmail($_SESSION['email']) : null;
                $is_registered = $user_id ? isUserRegistered($user_id, (int)$event['eid']) : false;
                $registration_status = $user_id ? getUserRegistrationStatus($user_id, (int)$event['eid']) : null;
                ?>
                
                <!-- Registration Status -->
                <?php if ($is_logged_in && $is_registered): ?>
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <div class="flex items-center gap-2">
                            <?php if ($registration_status === 'Approved'): ?>
                                <i class="fa-solid fa-check-circle text-green-600"></i>
                                <span class="text-green-700 font-bold">ได้รับการอนุมัติให้เข้าร่วมกิจกรรมแล้ว</span>
                            <?php elseif ($registration_status === 'Pending'): ?>
                                <i class="fa-solid fa-clock text-yellow-600"></i>
                                <span class="text-yellow-700 font-bold">รอการอนุมัติจากผู้จัดงาน</span>
                            <?php elseif ($registration_status === 'Rejected'): ?>
                                <i class="fa-solid fa-times-circle text-red-600"></i>
                                <span class="text-red-700 font-bold">ไม่ได้รับการอนุมัติ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Buttons -->
                <div class="grid grid-cols-4 gap-2 pt-2 max-w-3xl">
                    <?php if (!$is_logged_in): ?>
                        <a href="login" class="col-span-4">
                            <button class="w-full px-6 py-3 bg-orange-500 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all
                                       text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-sign-in-alt"></i>
                                เข้าสู่ระบบเพื่อลงทะเบียน
                            </button>
                        </a>
                    <?php elseif (!$is_registered): ?>
                        <form action="register_event" method="POST" class="col-span-4">
                            <input type="hidden" name="eid" value="<?= (int)$event['eid'] ?>">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-purple-600 text-white border-2 border-black rounded-lg font-bold
                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                       hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all
                       text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                ลงทะเบียน
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="col-span-4">
                            <button class="w-full px-6 py-3 bg-gray-400 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       text-sm flex items-center justify-center gap-2 whitespace-nowrap cursor-not-allowed"
                                       disabled>
                                <i class="fa-solid fa-check"></i>
                                ลงทะเบียนแล้ว
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>


</body>

</html>