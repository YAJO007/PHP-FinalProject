<?php
if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$registrations = $registrations ?? [];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การลงทะเบียนของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen p-4 sm:p-8 font-sans text-black flex">

    <div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            flex flex-col overflow-hidden 
            max-w-7xl mx-auto w-full">

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
                           rounded-lg font-bold shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1
                           hover:shadow-none transition-all duration-150">
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

        <div class="p-8 bg-purple-100 border-b-2 border-black">
            <div class="bg-purple-200 border-2 border-black rounded-xl p-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">

                <h2 class="text-4xl font-black mb-6 text-purple-900">
                    <i class="fa-solid fa-users"></i> การลงทะเบียนของฉัน
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-list text-2xl text-blue-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">ทั้งหมด</p>
                        <p class="text-3xl font-black text-blue-600"><?php echo count($registrations); ?></p>
                    </div>

                    <div class="bg-green-200 border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-check-circle text-2xl text-green-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">อนุมัติ</p>
                        <p class="text-3xl font-black text-green-600">
                            <?php 
                            $approved = 0;
                            foreach ($registrations as $reg) {
                                if ($reg['registration_status'] === 'Approved') $approved++;
                            }
                            echo $approved;
                            ?>
                        </p>
                    </div>

                    <div class="bg-yellow-200 border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-clock text-2xl text-yellow-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">รอการอนุมัติ</p>
                        <p class="text-3xl font-black text-yellow-600">
                            <?php 
                            $pending = 0;
                            foreach ($registrations as $reg) {
                                if ($reg['registration_status'] === 'Pending') $pending++;
                            }
                            echo $pending;
                            ?>
                        </p>
                    </div>

                    <div class="bg-red-200 border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px rgba(0,0,0,1)] text-center">
                        <i class="fa-solid fa-times-circle text-2xl text-red-600 mb-2"></i>
                        <p class="text-gray-700 font-bold text-sm">ปฏิเสธ</p>
                        <p class="text-3xl font-black text-red-600">
                            <?php 
                            $rejected = 0;
                            foreach ($registrations as $reg) {
                                if ($reg['registration_status'] === 'Rejected') $rejected++;
                            }
                            echo $rejected;
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 bg-purple-100 p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php if (empty($registrations)): ?>
                    <div class="col-span-full text-center py-12">
                        <div class="bg-white border-2 border-black rounded-xl p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                            <i class="fa-solid fa-users text-6xl text-gray-400 mb-4"></i>
                            <p class="text-xl font-bold text-gray-600">ยังไม่มีการลงทะเบียน</p>
                            <p class="text-gray-500 mt-2">ไปที่ค้นหากิจกรรมที่สนใจและลงทะเบียน</p>
                            <a href="event" class="inline-block mt-4">
                                <button class="px-6 py-2 bg-purple-600 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                                    ค้นหากิจกรรม
                                </button>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($registrations as $registration): ?>
                        <div class="bg-white border-2 border-black rounded-xl 
                            p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                            hover:scale-105 hover:-translate-y-2 transition-all">

                            <div class="bg-purple-300 h-40 rounded-lg mb-4 overflow-hidden">
                                <img src="img/<?= htmlspecialchars($registration['image_path']) ?>" 
                                     class="w-full h-full object-cover" 
                                     alt="<?= htmlspecialchars($registration['title']) ?>">
                            </div>

                            <h3 class="font-bold text-lg mb-2 text-purple-800">
                                <?= htmlspecialchars($registration['title']) ?>
                            </h3>

                            <p class="text-sm text-gray-700 mb-3 line-clamp-2">
                                <?= htmlspecialchars($registration['Details']) ?>
                            </p>

                            <div class="text-xs text-gray-600 mb-3 space-y-1">
                                <p><i class="fa-regular fa-calendar"></i> 
                                    เริ่ม: <?= htmlspecialchars($registration['start_date']) ?></p>
                                <p><i class="fa-regular fa-calendar-check"></i> 
                                    สิ้นสุด: <?= htmlspecialchars($registration['end_date']) ?></p>
                                <p><i class="fa-regular fa-users"></i> 
                                    รับสมัคร: <?= htmlspecialchars($registration['max_participants']) ?> คน</p>
                            </div>

                            <div class="mb-4">
                                <?php
                                $status = $registration['registration_status'] ?? '';
                                $has_attended = $registration['has_attended'] ?? false;
                                $statusBg = '';
                                $statusBorder = '';
                                $statusIcon = '';
                                $statusText = '';

                                if ($has_attended) {
                                    $statusBg = 'bg-blue-100';
                                    $statusBorder = 'border-blue-500';
                                    $statusIcon = '<i class="fa-solid fa-check-double"></i>';
                                    $statusText = 'เข้าร่วมงานแล้ว';
                                } else {
                                    switch ($status) {
                                        case 'Approved':
                                            $statusBg = 'bg-green-100';
                                            $statusBorder = 'border-green-500';
                                            $statusIcon = '<i class="fa-solid fa-check-circle"></i>';
                                            $statusText = 'ได้รับการอนุมัติ';
                                            break;
                                        case 'Pending':
                                            $statusBg = 'bg-yellow-100';
                                            $statusBorder = 'border-yellow-500';
                                            $statusIcon = '<i class="fa-solid fa-clock"></i>';
                                            $statusText = 'รอการอนุมัติ';
                                            break;
                                        case 'Rejected':
                                            $statusBg = 'bg-red-100';
                                            $statusBorder = 'border-red-500';
                                            $statusIcon = '<i class="fa-solid fa-times-circle"></i>';
                                            $statusText = 'ไม่ได้รับการอนุมัติ';
                                            break;
                                        default:
                                            $statusBg = 'bg-gray-50';
                                            $statusBorder = 'border-gray-400';
                                            $statusIcon = '<i class="fa-solid fa-question-circle"></i>';
                                            $statusText = $status;
                                    }
                                }
                                ?>
                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border <?= $statusBg ?> <?= $statusBorder ?> shadow-sm">
                                    <span class="text-lg"><?= $statusIcon ?></span>
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">สถานะการลงทะเบียน</p>
                                        <p class="font-bold text-sm"><?= $statusText ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <a href="detail?eid=<?= (int)$registration['eid'] ?>" class="flex-1">
                                        <button class="w-full px-4 py-2 bg-purple-600 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all text-sm">
                                            <i class="fa-solid fa-eye"></i> ดูรายละเอียด
                                        </button>
                                    </a>

                                    <?php if ($status === 'Pending'): ?>
                                        <form action="cancel_registration" method="POST" class="flex-1">
                                            <input type="hidden" name="eid" value="<?= (int)$registration['eid'] ?>">
                                            <button type="submit" 
                                                    class="w-full px-4 py-2 bg-red-500 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all text-sm"
                                                    onclick="return confirm('ยืนยันการยกเลิกการลงทะเบียน?')">
                                                <i class="fa-solid fa-times"></i> ยกเลิก
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <?php if ($status === 'Approved' && !$has_attended): ?>
                                    <button onclick="generateOTP(<?= (int)$registration['eid'] ?>)" 
                                            class="w-full px-4 py-2 bg-green-500 text-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all text-sm">
                                        <i class="fa-solid fa-key"></i> รับ OTP เช็คชื่อ
                                    </button>
                                <?php elseif ($has_attended): ?>
                                    <div class="w-full px-4 py-2 bg-blue-100 border-2 border-blue-500 rounded-lg font-bold text-center text-sm text-blue-800">
                                        <i class="fa-solid fa-check-double"></i> คุณได้เช็คชื่อเข้าร่วมงานแล้ว
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

        <?php if (!empty($rejection_history)): ?>
        <div class="p-8 bg-purple-100 border-t-2 border-black">
            <div class="bg-purple-200 border-2 border-black rounded-xl p-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">
                <h2 class="text-4xl font-black mb-6 text-purple-900">
                    <i class="fa-solid fa-times-circle"></i> ประวัติการถูกปฏิเสธ
                </h2>

                <div class="space-y-4">
                    <?php foreach ($rejection_history as $rejection): ?>
                        <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-red-800 mb-1">
                                        <i class="fa-solid fa-calendar-times"></i> 
                                        <?= htmlspecialchars($rejection['title']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fa-solid fa-clock"></i> 
                                        สถานะ: ถูกปฏิเสธ
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        <i class="fa-solid fa-comment"></i> 
                                        เหตุผล: <?= htmlspecialchars($rejection['rejection_reason']) ?>
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <a href="detail?eid=<?= (int)$rejection['eid'] ?>" class="px-3 py-1 bg-purple-600 text-white border border-black rounded text-sm hover:bg-purple-700">
                                        ดูกิจกรรม
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div id="otpModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white border-4 border-black rounded-2xl p-8 max-w-md w-full mx-4 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            <div class="text-center">
                <div class="text-6xl mb-4">🔑</div>
                <h3 class="text-3xl font-black text-purple-800 mb-4">รหัส OTP ของคุณ</h3>
                <div id="otpDisplay" class="text-5xl font-black text-green-600 mb-4 tracking-widest bg-green-100 border-2 border-black rounded-lg py-4">
                    ------
                </div>
                <p class="text-sm text-gray-600 mb-2">แสดงรหัสนี้ให้ผู้จัดงานเพื่อเช็คชื่อเข้าร่วมกิจกรรม</p>
                <p class="text-xs text-red-600 font-bold mb-6">⏱️ รหัสนี้จะหมดอายุใน <span id="otpTimer">5:00</span> นาที</p>
                <button onclick="closeOTPModal()" 
                        class="w-full px-6 py-3 bg-purple-600 text-white border-2 border-black rounded-lg font-bold hover:scale-105 transition-all">
                    ปิด
                </button>
            </div>
        </div>
    </div>

    <script>
        let timerInterval;

        function generateOTP(eid) {
            fetch('generate_otp?eid=' + eid + '&ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('otpDisplay').textContent = data.otp;
                        document.getElementById('otpModal').classList.remove('hidden');
                        startTimer(data.expires_in);
                    } else {
                        alert('ไม่สามารถสร้าง OTP ได้');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('เกิดข้อผิดพลาด');
                });
        }

        function closeOTPModal() {
            document.getElementById('otpModal').classList.add('hidden');
            if (timerInterval) {
                clearInterval(timerInterval);
            }
        }

        function startTimer(seconds) {
            if (timerInterval) {
                clearInterval(timerInterval);
            }

            let remaining = seconds;
            const timerElement = document.getElementById('otpTimer');

            timerInterval = setInterval(() => {
                remaining--;
                const minutes = Math.floor(remaining / 60);
                const secs = remaining % 60;
                timerElement.textContent = `${minutes}:${secs.toString().padStart(2, '0')}`;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    timerElement.textContent = 'หมดอายุ';
                    document.getElementById('otpDisplay').textContent = 'EXPIRED';
                    document.getElementById('otpDisplay').classList.add('text-red-600');
                    document.getElementById('otpDisplay').classList.remove('text-green-600');
                }
            }, 1000);
        }
    </script>

</body>

</html>
