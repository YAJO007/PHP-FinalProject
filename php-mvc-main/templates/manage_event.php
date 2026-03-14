<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

$participants = isset($participants_data) ? $participants_data : [];
$eid = isset($event['eid']) ? (int)$event['eid'] : 0;
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

        <div class="p-8 bg-purple-100">

            <div class="mb-8">
                <!-- Progress Overview -->
                <div class="bg-gradient-to-r from-purple-400 to-blue-400 border-2 border-black rounded-[24px] p-6 mb-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-black flex items-center gap-2">
                            <i class="fa-solid fa-chart-line"></i> ภาพรวมสถิติ
                        </h2>
                        <div class="text-right">
                            <p class="text-3xl font-black"><?php 
                                if ($event['max_participants'] > 0) {
                                    $percentage = round((count($participants) / $event['max_participants']) * 100);
                                    echo $percentage . '%';
                                } else {
                                    echo '0%';
                                }
                            ?></p>
                        </div>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-4 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-300 to-blue-400 rounded-full transition-all duration-500 shadow-[2px_2px_0px_0px_rgba(0,0,0,0.3)]" 
                             style="width: <?php 
                                if ($event['max_participants'] > 0) {
                                    echo min(100, round((count($participants) / $event['max_participants']) * 100));
                                } else {
                                    echo '0';
                                }
                            ?>%"></div>
                    </div>
                </div>

                <!-- Main Statistics Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="group bg-gradient-to-br from-purple-300 to-purple-400 border-2 border-black rounded-[16px] p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-user-plus text-xl"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-80 font-bold">รับสมัครสูงสุด</p>
                            </div>
                        </div>
                        <p class="text-3xl font-black mb-1"><?php echo htmlspecialchars($event['max_participants']); ?></p>
                        <div class="h-1 bg-white/30 rounded-full"></div>
                    </div>

                    <div class="group bg-gradient-to-br from-blue-300 to-blue-400 border-2 border-black rounded-[16px] p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-80 font-bold">ทั้งหมด</p>
                                <p class="text-sm font-bold"><?php 
                                    if ($event['max_participants'] > 0) {
                                        $percentage = round((count($participants) / $event['max_participants']) * 100);
                                        echo $percentage . '%';
                                    }
                                ?></p>
                            </div>
                        </div>
                        <p class="text-3xl font-black mb-1"><?php echo count($participants); ?></p>
                        <div class="h-1 bg-white/30 rounded-full"></div>
                    </div>

                    <div class="group bg-gradient-to-br from-green-300 to-green-400 border-2 border-black rounded-[16px] p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-check-circle text-xl"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-80 font-bold">อนุมัติ</p>
                                <p class="text-sm font-bold"><?php 
                                    $approved = 0;
                                    foreach ($participants as $p) {
                                        if ($p['status'] === 'Approved') $approved++;
                                    }
                                    if (count($participants) > 0) {
                                        $percentage = round(($approved / count($participants)) * 100);
                                        echo $percentage . '%';
                                    }
                                ?></p>
                            </div>
                        </div>
                        <p class="text-3xl font-black mb-1"><?php echo $approved; ?></p>
                        <div class="h-1 bg-white/30 rounded-full"></div>
                    </div>

                    <div class="group bg-gradient-to-br from-cyan-300 to-cyan-400 border-2 border-black rounded-[16px] p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-user-check text-xl"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-80 font-bold">เข้าร่วมงานแล้ว</p>
                                <p class="text-sm font-bold"><?php 
                                    $attended = getAttendanceCount($eid);
                                    if ($approved > 0) {
                                        $percentage = round(($attended / $approved) * 100);
                                        echo $percentage . '%';
                                    }
                                ?></p>
                            </div>
                        </div>
                        <p class="text-3xl font-black mb-1"><?php echo $attended; ?></p>
                        <div class="h-1 bg-white/30 rounded-full"></div>
                    </div>
                </div>

                <!-- Status Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="group bg-gradient-to-br from-yellow-200 to-yellow-300 border-2 border-black rounded-[12px] p-3 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:rotate-12 transition-transform">
                                <i class="fa-solid fa-clock text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs opacity-90 font-bold">รอการอนุมัติ</p>
                                <p class="text-xl font-black"><?php 
                                    $pending = 0;
                                    foreach ($participants as $p) {
                                        if ($p['status'] === 'Pending') $pending++;
                                    }
                                    echo $pending;
                                ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-red-300 to-red-400 border-2 border-black rounded-[12px] p-3 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:rotate-12 transition-transform">
                                <i class="fa-solid fa-times-circle text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs opacity-90 font-bold">ปฏิเสธ</p>
                                <p class="text-xl font-black"><?php 
                                    $rejected = 0;
                                    foreach ($participants as $p) {
                                        if ($p['status'] === 'Rejected') $rejected++;
                                    }
                                    echo $rejected;
                                ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-orange-200 to-orange-300 border-2 border-black rounded-[12px] p-3 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] text-white transform hover:scale-105 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2 group-hover:rotate-12 transition-transform">
                                <i class="fa-solid fa-user-slash text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs opacity-90 font-bold">ยังไม่เข้าร่วม</p>
                                <p class="text-xl font-black"><?php 
                                    $not_attended = $approved - $attended;
                                    echo max(0, $not_attended);
                                ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gender and Age Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Gender Statistics -->
                <div class="bg-white border-2 border-black rounded-[20px] shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-300 to-purple-300 border-b-2 border-black px-6 py-4">
                        <h3 class="text-xl font-black text-purple-900 flex items-center gap-2">
                            <i class="fa-solid fa-venus-mars"></i> สถิติเพศ
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php
                        $gender_stats = ['Male' => 0, 'Female' => 0, 'Other' => 0];
                        $total_gender = 0;
                        foreach ($participants as $p) {
                            if (!empty($p['gender'])) {
                                $gender = ucfirst(strtolower(trim($p['gender'])));
                                if ($gender === 'Male' || $gender === 'ชาย') {
                                    $gender_stats['Male']++;
                                    $total_gender++;
                                } elseif ($gender === 'Female' || $gender === 'หญิง') {
                                    $gender_stats['Female']++;
                                    $total_gender++;
                                } else {
                                    $gender_stats['Other']++;
                                    $total_gender++;
                                }
                            }
                        }
                        ?>
                        <div class="space-y-4">
                            <?php foreach ($gender_stats as $gender => $count): ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-20 text-sm font-bold text-gray-700">
                                        <?php 
                                        $gender_th = $gender === 'Male' ? 'ชาย' : ($gender === 'Female' ? 'หญิง' : 'อื่นๆ');
                                        echo $gender_th;
                                        ?>
                                    </div>
                                    <div class="flex-1">
                                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                                            <?php 
                                            $percentage = $total_gender > 0 ? round(($count / $total_gender) * 100) : 0;
                                            $bar_color = $gender === 'Male' ? 'from-purple-200 to-purple-300' : 
                                                           ($gender === 'Female' ? 'from-pink-200 to-pink-300' : 'from-indigo-200 to-indigo-300');
                                            ?>
                                            <div class="h-full bg-gradient-to-r <?php echo $bar_color; ?> rounded-full transition-all duration-500 flex items-center justify-end pr-2"
                                                 style="width: <?php echo $percentage; ?>%">
                                                <span class="text-xs font-bold text-white"><?php echo $percentage; ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-12 text-sm font-bold text-gray-700 text-right"><?php echo $count; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Age Group Statistics -->
                <div class="bg-white border-2 border-black rounded-[20px] shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-300 to-cyan-300 border-b-2 border-black px-6 py-4">
                        <h3 class="text-xl font-black text-purple-900 flex items-center gap-2">
                            <i class="fa-solid fa-birthday-cake"></i> สถิติช่วงอายุ
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php
                        $age_groups = [
                            '0-17' => 0,
                            '18-25' => 0,
                            '26-35' => 0,
                            '36-45' => 0,
                            '46-55' => 0,
                            '56+' => 0
                        ];
                        $total_age = 0;
                        foreach ($participants as $p) {
                            if (!empty($p['date_of_birth'])) {
                                $birth_date = new DateTime($p['date_of_birth']);
                                $today = new DateTime();
                                $age = $today->diff($birth_date)->y;
                                
                                if ($age <= 17) $age_groups['0-17']++;
                                elseif ($age <= 25) $age_groups['18-25']++;
                                elseif ($age <= 35) $age_groups['26-35']++;
                                elseif ($age <= 45) $age_groups['36-45']++;
                                elseif ($age <= 55) $age_groups['46-55']++;
                                else $age_groups['56+']++;
                                
                                $total_age++;
                            }
                        }
                        ?>
                        <div class="space-y-3">
                            <?php foreach ($age_groups as $group => $count): ?>
                                <div class="flex items-center gap-3">
                                    <div class="w-20 text-sm font-bold text-gray-700">
                                        <?php echo $group; ?> ปี
                                    </div>
                                    <div class="flex-1">
                                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                                            <?php 
                                            $percentage = $total_age > 0 ? round(($count / $total_age) * 100) : 0;
                                            $colors = [
                                                '0-17' => 'from-purple-200 to-purple-400',
                                                '18-25' => 'from-purple-300 to-purple-500',
                                                '26-35' => 'from-purple-400 to-purple-600',
                                                '36-45' => 'from-purple-500 to-purple-700',
                                                '46-55' => 'from-purple-600 to-purple-800',
                                                '56+' => 'from-purple-700 to-purple-900'
                                            ];
                                            $bar_color = $colors[$group] ?? 'from-gray-400 to-gray-600';
                                            ?>
                                            <div class="h-full bg-gradient-to-r <?php echo $bar_color; ?> rounded-full transition-all duration-500 flex items-center justify-end pr-2"
                                                 style="width: <?php echo $percentage; ?>%">
                                                <span class="text-xs font-bold text-white"><?php echo $percentage; ?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-12 text-sm font-bold text-gray-700 text-right"><?php echo $count; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                
                <div class="bg-purple-400 border-b-2 border-black px-6 py-4">
                    <h2 class="text-2xl font-black text-purple-900"><i class="fa-solid fa-users"></i> รายชื่อผู้ร่วมกิจกรรม</h2>
                </div>

                <?php if (empty($participants)): ?>
                    <div class="p-8 text-center text-gray-600">
                        <p class="text-lg font-bold">ยังไม่มีผู้ขอเข้าร่วม</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-purple-300 border-b-2 border-black">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold">ลำดับ</th>
                                    <th class="px-4 py-3 text-left font-bold">ชื่อ-นามสกุล</th>
                                    <th class="px-4 py-3 text-left font-bold">อีเมล</th>
                                    <th class="px-4 py-3 text-left font-bold">เบอร์โทร</th>
                                    <th class="px-4 py-3 text-left font-bold">สถานะ</th>
                                    <th class="px-4 py-3 text-center font-bold">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $index = 1;
                                foreach ($participants as $p): 
                                    // Check if user has checked in (session-based)
                                    $has_checked_in = isUserCheckedIn($p['uid'], $eid);
                                    
                                    if ($has_checked_in) {
                                        $status_class = 'bg-blue-200';
                                        $status_text = '<i class="fa-solid fa-user-check"></i> เข้าร่วมแล้ว';
                                    } else {
                                        $status_class = $p['status'] === 'Approved' ? 'bg-green-200' : ($p['status'] === 'Pending' ? 'bg-yellow-200' : 'bg-red-200');
                                        $status_text = $p['status'] === 'Approved' ? '<i class="fa-solid fa-check-circle"></i> อนุมัติ' : ($p['status'] === 'Pending' ? '<i class="fa-solid fa-clock"></i> รอการอนุมัติ' : '<i class="fa-solid fa-times-circle"></i> ปฏิเสธ');
                                    }
                                ?>
                                    <tr class="border-b border-gray-300 hover:bg-purple-50 transition-all">
                                        <td class="px-4 py-3 font-bold"><?php echo $index++; ?></td>
                                        <td class="px-4 py-3">
                                            <?php echo htmlspecialchars($p['first_name'] . ' ' . ($p['last_name'] ?? '')); ?>
                                        </td>
                                        <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($p['email']); ?></td>
                                        <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($p['phone_number']); ?></td>
                                        <td class="px-4 py-3">
                                            <span class="<?php echo $status_class; ?> px-3 py-1 rounded-lg font-bold text-sm border border-black">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <?php 
                                            $participant_checked_in = isUserCheckedIn($p['uid'], $eid);
                                            ?>
                                            <?php if ($participant_checked_in): ?>
                                                <span class="px-3 py-1 bg-green-500 text-white rounded-lg font-bold text-sm border border-black">
                                                    <i class="fa-solid fa-check-circle"></i> OTP ถูกต้อง
                                                </span>
                                            <?php elseif ($p['status'] === 'Pending'): ?>
                                                <div class="flex gap-2 justify-center">
                                                    <a href="manage_event?eid=<?php echo htmlspecialchars($event['eid']); ?>&action=approve&uid=<?php echo htmlspecialchars($p['uid']); ?>">
                                                        <button class="px-3 py-1 bg-green-500 text-white border border-black rounded font-bold text-sm hover:scale-105 transition-all">
                                                            <i class="fa-solid fa-check"></i> อนุมัติ
                                                        </button>
                                                    </a>
                                                    <a href="manage_event?eid=<?php echo htmlspecialchars($event['eid']); ?>&action=reject&uid=<?php echo htmlspecialchars($p['uid']); ?>" onclick="return confirm('ยืนยันการปฏิเสธ?')">
                                                        <button class="px-3 py-1 bg-red-500 text-white border border-black rounded font-bold text-sm hover:scale-105 transition-all">
                                                            <i class="fa-solid fa-times"></i> ปฏิเสธ
                                                        </button>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-500 text-sm">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8 grid md:grid-cols-2 gap-6">
                
                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4">🔑 จัดการ OTP สำหรับกิจกรรม</h3>
                    
                    <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 mb-4">
                        <p class="font-bold text-blue-800 mb-2">📋 วิธีใช้งาน:</p>
                        <ol class="text-sm text-gray-700 list-decimal list-inside">
                            <li>ผู้เข้าร่วมคลิก "สร้าง OTP สำหรับกิจกรรม"</li>
                            <li>OTP ใช้ได้ 10 นาที และจะเปลี่ยนทุก 10 นาที</li>
                            <li>ผู้จัดงานกรอก OTP ในหน้ารายละเอียดกิจกรรม</li>
                            <li>ระบบจะบันทึกการเข้าร่วมอัตโนมัติ</li>
                        </ol>
                        
                        <div class="mt-3">
                            <!-- OTP Verification for Participants -->
                            <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                <h3 class="font-bold text-lg mb-3 text-purple-800">
                                    <i class="fa-solid fa-user-check"></i> ยืนยันการเข้าร่วมของผู้เข้าร่วม
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">กรอกรหัส OTP ของผู้เข้าร่วมแสดงให้</p>
                                <form action="verify_event_otp" method="POST" class="mt-3">
                                    <input type="hidden" name="eid" value="<?= $eid ?>">
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               name="otp" 
                                               maxlength="6" 
                                               pattern="[0-9]{6}"
                                               placeholder="กรอก OTP จากผู้เข้าร่วม"
                                               required
                                               class="flex-1 px-3 py-2 border-2 border-black rounded-lg font-bold text-center tracking-widest focus:ring-2 focus:ring-blue-300">
                                        <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                                            <i class="fa-solid fa-check"></i> ยืนยันการเข้าร่วม
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($_GET['otp_generated'])): ?>
                        <div class="bg-green-100 border-2 border-green-500 rounded-lg p-4 mb-4">
                            <p class="font-bold text-green-800">✅ สร้าง OTP สำเร็จแล้ว!</p>
                            <p class="text-sm text-green-700">แสดงรหัสนี้ให้ผู้จัดงานเพื่อกรอกเข้างาน</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4"><i class="fa-solid fa-file-lines"></i> รายละเอียดกิจกรรม</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>วันเริ่ม:</strong> <?php echo htmlspecialchars($event['start_date']); ?></p>
                        <p><strong>วันสิ้นสุด:</strong> <?php echo htmlspecialchars($event['end_date']); ?></p>
                        <p><strong>สถานะ:</strong> <?php echo htmlspecialchars($event['status']); ?></p>
                        <p><strong>คำอธิบาย:</strong></p>
                        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($event['Details'])); ?></p>
                    </div>
                </div>

                <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
                    <h3 class="text-xl font-black text-purple-800 mb-4"><i class="fa-solid fa-gear"></i> การจัดการ</h3>
                    <div class="space-y-3">
                        <a href="edit_event?eid=<?php echo htmlspecialchars($event['eid']); ?>" class="block">
                            <button class="w-full px-4 py-2 bg-blue-500 text-white border-2 border-black rounded-lg font-bold hover:translate-x-1 hover:translate-y-1 transition-all">
                                <i class="fa-solid fa-edit"></i> แก้ไขกิจกรรม
                            </button>
                        </a>
                        <a href="detail?eid=<?php echo htmlspecialchars($event['eid']); ?>" class="block">
                            <button class="w-full px-4 py-2 bg-purple-600 text-white border-2 border-black rounded-lg font-bold hover:translate-x-1 hover:translate-y-1 transition-all">
                                <i class="fa-solid fa-eye"></i> ดูรายละเอียด
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['verified']) && $_GET['verified'] === 'success' && isset($_SESSION['creator_verified'])): ?>
        <div class="fixed top-4 right-4 bg-green-100 border-2 border-green-500 rounded-lg p-4 shadow-lg z-50">
            <div class="flex items-center gap-3">
                <div class="text-2xl">✅</div>
                <div>
                    <p class="font-bold text-green-800">ยืนยันตัวตนสำเร็จ!</p>
                    <p class="text-sm text-green-700">เวลา: <?= htmlspecialchars($_SESSION['creator_verified']['time']) ?></p>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['creator_verified']); ?>
        <script>
            setTimeout(() => {
                window.location.href = window.location.pathname + '?eid=<?= $eid ?>';
            }, 3000);
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['verified']) && $_GET['verified'] === 'success' && isset($_SESSION['participant_verified'])): ?>
        <div class="fixed top-4 right-4 bg-green-100 border-2 border-green-500 rounded-lg p-4 shadow-lg z-50">
            <p class="font-bold text-green-800">✅ ยืนยันการเข้าร่วมสำเร็จ!</p>
            <p class="text-sm text-green-700">ผู้เข้าร่วมได้เข้าร่วมกิจกรรมแล้วเมื่อ <?= $_SESSION['participant_verified']['time'] ?></p>
            <p class="text-xs text-green-600">รหัส OTP: <?= $_SESSION['participant_verified']['otp_used'] ?></p>
        </div>
        <script>
            setTimeout(() => {
                window.location.href = window.location.pathname + '?eid=<?= $eid ?>';
            }, 3000);
        </script>
        <?php unset($_SESSION['participant_verified']); ?>
    <?php endif; ?>

    <?php if (isset($_GET['err']) && $_GET['err'] === 'otp'): ?>
        <div class="fixed top-4 right-4 bg-red-100 border-2 border-red-500 rounded-lg p-4 shadow-lg z-50">
            <p class="font-bold text-red-800">❌ รหัส OTP ไม่ถูกต้องหรือหมดอายุ</p>
        </div>
        <script>
            setTimeout(() => {
                window.location.href = window.location.pathname + '?eid=<?= $eid ?>';
            }, 3000);
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['err']) && $_GET['err'] === 'inv'): ?>
        <div class="fixed top-4 right-4 bg-red-100 border-2 border-red-500 rounded-lg p-4 shadow-lg z-50">
            <p class="font-bold text-red-800">❌ ข้อมูลไม่ครบถ้วน</p>
        </div>
        <script>
            setTimeout(() => {
                window.location.href = window.location.pathname + '?eid=<?= $eid ?>';
            }, 3000);
        </script>
    <?php endif; ?>

</body>

</html>
