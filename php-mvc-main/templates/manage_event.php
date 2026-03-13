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

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                    <i class="fa-solid fa-user-plus text-2xl text-purple-600 mb-2"></i>
                    <p class="text-gray-700 font-bold text-sm">รับสมัครสูงสุด</p>
                    <p class="text-3xl font-black text-purple-600"><?php echo htmlspecialchars($event['max_participants']); ?></p>
                </div>

                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                    <i class="fa-solid fa-users text-2xl text-blue-600 mb-2"></i>
                    <p class="text-gray-700 font-bold text-sm">ทั้งหมด</p>
                    <p class="text-3xl font-black text-blue-600"><?php echo count($participants); ?></p>
                    <p class="text-xs text-gray-500 mt-1"><?php 
                        if ($event['max_participants'] > 0) {
                            $percentage = round((count($participants) / $event['max_participants']) * 100);
                            echo $percentage . '%';
                        }
                    ?></p>
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
                    <p class="text-xs text-gray-500 mt-1"><?php 
                        if (count($participants) > 0) {
                            $percentage = round(($approved / count($participants)) * 100);
                            echo $percentage . '%';
                        }
                    ?></p>
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
                    <p class="text-xs text-gray-500 mt-1"><?php 
                        if ($approved > 0) {
                            $percentage = round(($attended / $approved) * 100);
                            echo $percentage . '%';
                        }
                    ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                    <i class="fa-solid fa-clock text-2xl text-yellow-600 mb-2"></i>
                    <p class="text-gray-700 font-bold text-sm">รอการอนุมัติ</p>
                    <p class="text-3xl font-black text-yellow-600">
                        <?php 
                        $pending = 0;
                        foreach ($participants as $p) {
                            if ($p['status'] === 'Pending') $pending++;
                        }
                        echo $pending;
                        ?>
                    </p>
                </div>

                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                    <i class="fa-solid fa-times-circle text-2xl text-red-600 mb-2"></i>
                    <p class="text-gray-700 font-bold text-sm">ปฏิเสธ</p>
                    <p class="text-3xl font-black text-red-600">
                        <?php 
                        $rejected = 0;
                        foreach ($participants as $p) {
                            if ($p['status'] === 'Rejected') $rejected++;
                        }
                        echo $rejected;
                        ?>
                    </p>
                </div>

                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                    <i class="fa-solid fa-user-slash text-2xl text-orange-600 mb-2"></i>
                    <p class="text-gray-700 font-bold text-sm">ยังไม่เข้าร่วม</p>
                    <p class="text-3xl font-black text-orange-600">
                        <?php 
                        $not_attended = $approved - $attended;
                        echo max(0, $not_attended);
                        ?>
                    </p>
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
                                    $status_class = $p['status'] === 'Approved' ? 'bg-green-200' : ($p['status'] === 'Pending' ? 'bg-yellow-200' : 'bg-red-200');
                                    $status_text = $p['status'] === 'Approved' ? '<i class="fa-solid fa-check-circle"></i> อนุมัติ' : ($p['status'] === 'Pending' ? '<i class="fa-solid fa-clock"></i> รอการอนุมัติ' : '<i class="fa-solid fa-times-circle"></i> ปฏิเสธ');
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
                                            <?php if ($p['status'] === 'Pending'): ?>
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
                            <!-- OTP Verification for Event Creator -->
                            <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                                <h3 class="font-bold text-lg mb-3 text-purple-800">
                                    <i class="fa-solid fa-shield-halved"></i> ยืนยันตัวตนผู้จัดงาน
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">กรอกรหัส OTP เพื่อยืนยันว่าคุณเป็นผู้จัดงาน</p>
                                <form action="verify_creator_otp" method="POST" class="mt-3">
                                    <input type="hidden" name="eid" value="<?= $eid ?>">
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               name="otp" 
                                               maxlength="6" 
                                               pattern="[0-9]{6}"
                                               placeholder="กรอก OTP 6 หลัก"
                                               required
                                               class="flex-1 px-3 py-2 border-2 border-black rounded-lg font-bold text-center tracking-widest focus:ring-2 focus:ring-blue-300">
                                        <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                                            <i class="fa-solid fa-shield-check"></i> ยืนยัน
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
