<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

$participants = isset($participants_data) ? $participants_data : [];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถิติกิจกรรม - <?php echo htmlspecialchars($event['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen p-4 sm:p-8 font-sans text-black">

    <div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            max-w-6xl mx-auto">

        <div class="border-b-2 border-black bg-purple-300 px-6 py-4 flex justify-between items-center rounded-t-[22px]">
            <div>
                <h1 class="text-3xl font-black text-purple-900"><i class="fa-solid fa-chart-bar"></i> สถิติกิจกรรม</h1>
                <p class="text-sm text-purple-800 mt-1"><?php echo htmlspecialchars($event['title']); ?></p>
            </div>
            <a href="my_event">
                <button class="px-4 py-1 bg-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                    <i class="fa-solid fa-times"></i> ปิด
                </button>
            </a>
        </div>

        <div class="p-6 bg-purple-100 space-y-8">

            <!-- Main Statistics Section -->
            <div>
                <h2 class="text-xl font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line"></i> ภาพรวมสถิติ
                </h2>
                
                <!-- Registration Progress Visualization -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6 mb-4">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-700 flex items-center gap-2">
                                <i class="fa-solid fa-percentage"></i> อัตราการเข้าร่วม
                            </span>
                            <span class="text-sm font-bold text-gray-700">
                                <?php 
                                $max_participants = $event['max_participants'];
                                $current_participants = count($participants);
                                $registration_rate = $max_participants > 0 ? ($current_participants / $max_participants) * 100 : 0;
                                echo round($registration_rate) . '%';
                                ?>
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-12 overflow-hidden border border-gray-300">
                            <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-full rounded-full flex items-center justify-center text-white font-bold transition-all duration-500 ease-out relative"
                                 style="width: <?php echo $registration_rate; ?>%">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-sm">
                                        <?php echo $current_participants; ?> / <?php echo $max_participants; ?> คน
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Indicators -->
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="text-green-700 font-bold text-sm">ที่เหลือ</div>
                                <div class="text-green-900 font-black text-lg">
                                    <?php echo max(0, $max_participants - $current_participants); ?>
                                </div>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="text-blue-700 font-bold text-sm">ลงทะเบียนแล้ว</div>
                                <div class="text-blue-900 font-black text-lg">
                                    <?php echo $current_participants; ?>
                                </div>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                <div class="text-purple-700 font-bold text-sm">เต็ม</div>
                                <div class="text-purple-900 font-black text-lg">
                                    <?php echo $registration_rate >= 100 ? '✓' : '-'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-user-plus text-2xl text-purple-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">รับสมัครสูงสุด</p>
                        <p class="text-3xl font-black text-purple-600"><?php echo htmlspecialchars($event['max_participants']); ?></p>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-purple-500 h-full rounded-full" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-users text-2xl text-blue-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">ทั้งหมด</p>
                        <p class="text-3xl font-black text-blue-600"><?php echo count($participants); ?></p>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-blue-500 h-full rounded-full transition-all duration-500" 
                                 style="width: <?php echo $max_participants > 0 ? (count($participants) / $max_participants) * 100 : 0; ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-check-circle text-2xl text-green-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">อนุมัติ</p>
                        <p class="text-3xl font-black text-green-600">
                            <?php 
                            $approved = 0;
                            foreach ($participants as $p) {
                                if ($p['status'] === 'Approved') $approved++;
                            }
                            echo $approved;
                            ?>
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-green-500 h-full rounded-full transition-all duration-500" 
                                 style="width: <?php echo count($participants) > 0 ? ($approved / count($participants)) * 100 : 0; ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-check-double text-2xl text-blue-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">เข้าร่วมงานแล้ว</p>
                        <p class="text-3xl font-black text-blue-600">
                            <?php 
                            $attended = isset($attended_count) ? $attended_count : 0;
                            echo $attended;
                            ?>
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                            <div class="bg-blue-500 h-full rounded-full transition-all duration-500" 
                                 style="width: <?php echo $approved > 0 ? ($attended / $approved) * 100 : 0; ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Statistics Section -->
            <div>
                <h2 class="text-xl font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-tasks"></i> สถานะการลงทะเบียน
                </h2>
                
                <!-- Progress Bar Visualization -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6 mb-4">
                    <div class="space-y-4">
                        <?php 
                        $pending = 0;
                        $rejected = 0;
                        foreach ($participants as $p) {
                            if ($p['status'] === 'Pending') $pending++;
                            if ($p['status'] === 'Rejected') $rejected++;
                        }
                        $total_status = count($participants);
                        ?>
                        
                        <!-- Overall Progress -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-700 flex items-center gap-2">
                                    <i class="fa-solid fa-chart-pie"></i> ภาพรวมการลงทะเบียน
                                </span>
                                <span class="text-sm font-bold text-gray-700">
                                    <?php echo $total_status; ?> คนทั้งหมด
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-10 overflow-hidden border border-gray-300 flex">
                                <?php if ($approved > 0): ?>
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-full flex items-center justify-center text-white font-bold text-xs transition-all duration-500 ease-out"
                                         style="width: <?php echo $total_status > 0 ? ($approved / $total_status) * 100 : 0; ?>%"
                                         title="อนุมัติ <?php echo $approved; ?> คน">
                                        <?php if ($approved / $total_status > 0.1): ?>
                                            อนุมัติ <?php echo $approved; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($pending > 0): ?>
                                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-full flex items-center justify-center text-white font-bold text-xs transition-all duration-500 ease-out"
                                         style="width: <?php echo $total_status > 0 ? ($pending / $total_status) * 100 : 0; ?>%"
                                         title="รอการอนุมัติ <?php echo $pending; ?> คน">
                                        <?php if ($pending / $total_status > 0.1): ?>
                                            รออนุมัติ <?php echo $pending; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($rejected > 0): ?>
                                    <div class="bg-gradient-to-r from-red-400 to-red-600 h-full flex items-center justify-center text-white font-bold text-xs transition-all duration-500 ease-out"
                                         style="width: <?php echo $total_status > 0 ? ($rejected / $total_status) * 100 : 0; ?>%"
                                         title="ปฏิเสธ <?php echo $rejected; ?> คน">
                                        <?php if ($rejected / $total_status > 0.1): ?>
                                            ปฏิเสธ <?php echo $rejected; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Legend -->
                            <div class="flex flex-wrap gap-4 text-xs">
                                <div class="flex items-center gap-1">
                                    <div class="w-3 h-3 bg-green-500 rounded"></div>
                                    <span class="text-gray-600">อนุมัติ (<?php echo $approved; ?>)</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                                    <span class="text-gray-600">รอการอนุมัติ (<?php echo $pending; ?>)</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                                    <span class="text-gray-600">ปฏิเสธ (<?php echo $rejected; ?>)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <!-- Gender Statistics Section -->
            <div>
                <h2 class="text-xl font-bold text-purple-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-diversity"></i> สถิติตามเพศ
                </h2>
                
                <!-- Bar Chart Visualization -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <div class="space-y-6">
                        <?php 
                        $male_count = isset($gender_stats['ชาย']) ? $gender_stats['ชาย'] : 0;
                        $female_count = isset($gender_stats['หญิง']) ? $gender_stats['หญิง'] : 0;
                        $other_count = isset($gender_stats['อื่นๆ']) ? $gender_stats['อื่นๆ'] : 0;
                        $total_gender = $male_count + $female_count + $other_count;
                        ?>
                        
                        <!-- Male Bar -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-blue-700 flex items-center gap-2">
                                    <i class="fa-solid fa-mars"></i> เพศชาย
                                </span>
                                <span class="text-sm font-bold text-gray-700">
                                    <?php echo $male_count; ?> คน 
                                    <?php if ($total_gender > 0): ?>
                                        (<?php echo round(($male_count / $total_gender) * 100); ?>%)
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-10 overflow-hidden border border-gray-300">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-full rounded-full flex items-center justify-center text-white font-bold transition-all duration-500 ease-out"
                                     style="width: <?php echo $total_gender > 0 ? ($male_count / $total_gender) * 100 : 0; ?>%">
                                    <?php if ($male_count > 0): ?>
                                        <?php echo $male_count; ?> คน
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Female Bar -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-pink-700 flex items-center gap-2">
                                    <i class="fa-solid fa-venus"></i> เพศหญิง
                                </span>
                                <span class="text-sm font-bold text-gray-700">
                                    <?php echo $female_count; ?> คน 
                                    <?php if ($total_gender > 0): ?>
                                        (<?php echo round(($female_count / $total_gender) * 100); ?>%)
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-10 overflow-hidden border border-gray-300">
                                <div class="bg-gradient-to-r from-pink-400 to-pink-600 h-full rounded-full flex items-center justify-center text-white font-bold transition-all duration-500 ease-out"
                                     style="width: <?php echo $total_gender > 0 ? ($female_count / $total_gender) * 100 : 0; ?>%">
                                    <?php if ($female_count > 0): ?>
                                        <?php echo $female_count; ?> คน
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Other Bar -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-purple-700 flex items-center gap-2">
                                    <i class="fa-solid fa-genderless"></i> อื่นๆ
                                </span>
                                <span class="text-sm font-bold text-gray-700">
                                    <?php echo $other_count; ?> คน 
                                    <?php if ($total_gender > 0): ?>
                                        (<?php echo round(($other_count / $total_gender) * 100); ?>%)
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-10 overflow-hidden border border-gray-300">
                                <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-full rounded-full flex items-center justify-center text-white font-bold transition-all duration-500 ease-out"
                                     style="width: <?php echo $total_gender > 0 ? ($other_count / $total_gender) * 100 : 0; ?>%">
                                    <?php if ($other_count > 0): ?>
                                        <?php echo $other_count; ?> คน
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Gender Summary -->
                        <?php if ($total_gender > 0): ?>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-center text-sm text-gray-700">
                                <span class="font-medium">ภาพรวม:</span> 
                                มีผู้เข้าร่วมที่ได้รับการอนุมัติทั้งหมด <?php echo $total_gender; ?> คน
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-center text-sm text-gray-500">
                                ยังไม่มีข้อมูลสถิติเพศสำหรับผู้เข้าร่วมที่ได้รับการอนุมัติ
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Participants Table Section -->
            <div>
                <h2 class="text-xl font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-users"></i> รายชื่อผู้ร่วมกิจกรรม
                </h2>
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">

                <?php if (empty($participants)): ?>
                    <div class="p-12 text-center text-gray-600">
                        <div class="mb-4">
                            <i class="fa-solid fa-user-xmark text-6xl text-gray-400"></i>
                        </div>
                        <p class="text-xl font-bold mb-2">ยังไม่มีผู้ขอเข้าร่วม</p>
                        <p class="text-sm text-gray-500">ผู้เข้าร่วมที่ลงทะเบียนจะแสดงที่นี่</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px]">
                            <thead class="bg-gradient-to-r from-purple-300 to-purple-400 border-b-2 border-black">
                                <tr>
                                    <th class="px-6 py-4 text-left font-bold text-purple-900">ลำดับ</th>
                                    <th class="px-6 py-4 text-left font-bold text-purple-900">ชื่อ-นามสกุล</th>
                                    <th class="px-6 py-4 text-left font-bold text-purple-900">อีเมล</th>
                                    <th class="px-6 py-4 text-left font-bold text-purple-900">เบอร์โทร</th>
                                    <th class="px-6 py-4 text-left font-bold text-purple-900">สถานะ</th>
                                    <th class="px-6 py-4 text-center font-bold text-purple-900">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php 
                                $index = 1;
                                foreach ($participants as $p): 
                                    $status_class = $p['status'] === 'Approved' ? 'bg-green-100 text-green-800 border-green-300' : ($p['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800 border-yellow-300' : 'bg-red-100 text-red-800 border-red-300');
                                    $status_text = $p['status'] === 'Approved' ? '<i class="fa-solid fa-check-circle"></i> อนุมัติ' : ($p['status'] === 'Pending' ? '<i class="fa-solid fa-clock"></i> รอการอนุมัติ' : '<i class="fa-solid fa-times-circle"></i> ปฏิเสธ');
                                ?>
                                    <tr class="hover:bg-purple-50 transition-colors duration-150">
                                        <td class="px-6 py-4 font-bold text-gray-700"><?php echo $index++; ?></td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900"><?php echo htmlspecialchars($p['first_name'] . ' ' . ($p['last_name'] ?? '')); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($p['email']); ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($p['phone_number']); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-2 rounded-lg font-bold text-sm border <?= $status_class ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if ($p['status'] === 'Pending'): ?>
                                                <div class="flex gap-2 justify-center">
                                                    <a href="manage_event?eid=<?php echo htmlspecialchars($event['eid']); ?>&action=approve&uid=<?php echo htmlspecialchars($p['uid']); ?>" class="inline-block">
                                                        <button class="px-4 py-2 bg-green-500 text-white border-2 border-green-600 rounded-lg font-bold text-sm hover:bg-green-600 transition-colors duration-150 shadow-sm">
                                                            <i class="fa-solid fa-check mr-1"></i> อนุมัติ
                                                        </button>
                                                    </a>
                                                    <a href="manage_event?eid=<?php echo htmlspecialchars($event['eid']); ?>&action=reject&uid=<?php echo htmlspecialchars($p['uid']); ?>" onclick="return confirm('ยืนยันการปฏิเสธ?')" class="inline-block">
                                                        <button class="px-4 py-2 bg-red-500 text-white border-2 border-red-600 rounded-lg font-bold text-sm hover:bg-red-600 transition-colors duration-150 shadow-sm">
                                                            <i class="fa-solid fa-times mr-1"></i> ปฏิเสธ
                                                        </button>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-gray-400 text-sm font-medium">-</div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Action Tools Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-6">
                
                <!-- OTP Check-in -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> เช็คชื่อด้วย OTP
                    </h3>
                    
                    <?php if (isset($_GET['checkin']) && $_GET['checkin'] === 'success' && isset($_SESSION['checkin_success'])): ?>
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 mb-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="text-3xl">✅</div>
                                <div>
                                    <p class="font-black text-green-800 text-lg">เช็คชื่อสำเร็จ!</p>
                                    <p class="text-sm text-green-700">เวลา: <?= htmlspecialchars($_SESSION['checkin_success']['time']) ?></p>
                                </div>
                            </div>
                            <div class="border-t-2 border-green-300 pt-2 mt-2">
                                <p class="font-bold text-gray-800"><?= htmlspecialchars($_SESSION['checkin_success']['name']) ?></p>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($_SESSION['checkin_success']['email']) ?></p>
                            </div>
                        </div>
                        <?php unset($_SESSION['checkin_success']); ?>
                    <?php endif; ?>

                    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_otp'): ?>
                        <div class="bg-red-100 border-2 border-red-500 rounded-lg p-4 mb-4">
                            <p class="font-bold text-red-800">❌ รหัส OTP ไม่ถูกต้องหรือหมดอายุ</p>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error']) && $_GET['error'] === 'already_attended'): ?>
                        <div class="bg-orange-100 border-2 border-orange-500 rounded-lg p-4 mb-4">
                            <p class="font-bold text-orange-800">⚠️ ผู้เข้าร่วมท่านนี้เช็คชื่อเข้าร่วมงานแล้ว</p>
                        </div>
                    <?php endif; ?>

                    <form action="verify_otp" method="POST" class="space-y-4">
                        <input type="hidden" name="eid" value="<?php echo htmlspecialchars($event['eid']); ?>">
                        
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-800">กรอกรหัส OTP (6 หลัก)</label>
                            <input type="text" 
                                   name="otp" 
                                   maxlength="6" 
                                   pattern="[0-9]{6}"
                                   placeholder="000000"
                                   required
                                   class="w-full px-4 py-3 text-2xl font-bold text-center tracking-widest
                                          border-2 border-black rounded-lg
                                          focus:ring-4 focus:ring-purple-300 transition-all">
                        </div>
                        
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-green-500 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                            <i class="fa-solid fa-check-circle"></i> ยืนยันเช็คชื่อ
                        </button>
                    </form>

                    <div class="mt-4 p-3 bg-purple-50 border border-purple-300 rounded-lg">
                        <p class="text-xs text-gray-600">
                            <i class="fa-solid fa-info-circle"></i> 
                            ผู้เข้าร่วมที่ได้รับการอนุมัติสามารถสร้าง OTP จากหน้า "ดูการลงทะเบียน" 
                            และนำมาให้คุณกรอกเพื่อเช็คชื่อเข้าร่วมกิจกรรม
                        </p>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-file-lines"></i> รายละเอียดกิจกรรม
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-bold text-gray-600">วันเริ่ม:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($event['start_date']); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-bold text-gray-600">วันสิ้นสุด:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($event['end_date']); ?></span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-bold text-gray-600">สถานะ:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($event['status']); ?></span>
                        </div>
                        <div class="pt-2">
                            <p class="font-bold text-gray-600 mb-2">คำอธิบาย:</p>
                            <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($event['Details'])); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Management Tools -->
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-gear"></i> เครื่องมือจัดการ
                    </h3>
                    <div class="space-y-3">
                        <a href="edit_event?eid=<?php echo htmlspecialchars($event['eid']); ?>" class="block">
                            <button class="w-full px-4 py-3 bg-blue-500 text-white border-2 border-blue-600 rounded-lg font-bold hover:bg-blue-600 transition-colors duration-150 shadow-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-edit"></i> แก้ไขกิจกรรม
                            </button>
                        </a>
                        <a href="detail?eid=<?php echo htmlspecialchars($event['eid']); ?>" class="block">
                            <button class="w-full px-4 py-3 bg-purple-600 text-white border-2 border-purple-700 rounded-lg font-bold hover:bg-purple-700 transition-colors duration-150 shadow-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-eye"></i> ดูรายละเอียด
                            </button>
                        </a>
                        <div class="pt-2 border-t border-gray-200">
                            <div class="text-xs text-gray-500 text-center">
                                <i class="fa-solid fa-info-circle"></i> 
                                คุณสามารถจัดการกิจกรรมได้จากหน้านี้
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
