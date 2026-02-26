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

        <div class="flex justify-between items-center
                border-b-2 border-black
                bg-purple-300 px-6 py-4">

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
                    <button class="px-6 py-2 bg-white
                               border-2 border-black rounded-lg font-bold
                               shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                               hover:translate-x-1 hover:translate-y-1
                               hover:shadow-none transition-all duration-150">
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

       <?php
        $user = null;
        if (isset($data['result']) && $data['result']->num_rows === 1) {
            $user = $data['result']->fetch_assoc();
        }
        ?>

        <div class="flex-1 bg-purple-100 p-6 sm:p-10 flex justify-center items-start">
            <div class="bg-white border-2 border-black rounded-2xl
                p-8 w-full max-w-3xl
                shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative">

                <h2 class="text-3xl sm:text-4xl font-black mb-8 text-purple-900 text-center uppercase tracking-wide border-b-2 border-black pb-4">
                    โปรไฟล์ของฉัน
                </h2>

                <div class="flex flex-col items-center justify-center mb-8 gap-4">
                    <div class="w-32 h-32 bg-purple-300 rounded-full
                        border-4 border-black
                        shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                        flex items-center justify-center text-6xl font-bold overflow-hidden">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <?php if ($user): ?>
                        <p class="text-2xl font-black uppercase text-gray-800 bg-purple-200 px-4 py-1 border-2 border-black rounded-lg shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <?= htmlspecialchars($user['user_name']) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <?php if ($user): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg mt-6">
                        
                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">ชื่อ</label>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($user['first_name']) ?></div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">นามสกุล</label>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($user['last_name']) ?></div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] md:col-span-2">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">อีเมล</label>
                            <div class="font-bold text-gray-900 truncate"><?= htmlspecialchars($user['email']) ?></div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">วันเกิด</label>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($user['date_of_birth']) ?></div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">เพศ</label>
                            <div class="font-bold text-gray-900 uppercase">
                                <?php 
                                    if($user['gender'] == 'male') echo 'ชาย <i class="fa-solid fa-mars"></i>';
                                    elseif($user['gender'] == 'female') echo 'หญิง <i class="fa-solid fa-venus"></i>';
                                    elseif($user['gender'] == 'other') echo 'อื่นๆ';
                                    else echo htmlspecialchars($user['gender']);
                                ?>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">เบอร์โทรศัพท์</label>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($user['phone_number']) ?></div>
                        </div>

                        <div class="bg-purple-50 p-4 border-2 border-black rounded-xl shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xs font-bold text-purple-800 uppercase mb-1">โรคประจำตัว</label>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($user['congenital_disease'] ?: 'ไม่มี') ?></div>
                        </div>

                    </div>

                    <div class="mt-10 flex justify-center gap-4 border-t-2 border-black pt-6 flex-wrap">
                        <a href="edit_profile">
                            <button class="px-8 py-3 bg-blue-400 text-black border-2 border-black rounded-xl font-black text-lg shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-blue-500 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                <i class="fa-solid fa-edit"></i> แก้ไขโปรไฟล์
                            </button>
                        </a>
                        <a href="logout">
                            <button class="px-8 py-3 bg-red-400 text-black border-2 border-black rounded-xl font-black text-lg shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-red-500 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                ออกจากระบบ
                            </button>
                        </a>
                    </div>

                <?php else: ?>
                    <div class="text-center p-8 border-2 border-dashed border-red-500 rounded-xl bg-red-50 mt-6">
                        <p class="text-2xl font-bold text-red-600 mb-2">ไม่พบข้อมูลผู้ใช้</p>
                        <p class="text-gray-600">กรุณาเข้าสู่ระบบใหม่อีกครั้ง</p>
                        <a href="/logout">
                            <button class="mt-4 px-6 py-2 bg-white text-black border-2 border-black rounded-lg font-bold shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                กลับไปหน้า Login
                            </button>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>

</html>