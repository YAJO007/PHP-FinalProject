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
                    <h3 class="text-xl font-black text-purple-800 mb-4">🔑 เช็คชื่อด้วย OTP</h3>
                    
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

</body>
</html>
