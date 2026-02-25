<?php
// Check if user data is passed
if (!isset($user) || !is_array($user)) {
    echo "ไม่พบข้อมูลผู้ใช้";
    return;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen p-4 sm:p-8 font-sans text-black flex">

    <!-- MAIN CONTAINER -->
    <div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            flex flex-col overflow-hidden 
            max-w-7xl mx-auto w-full">

        <!-- ===== NAVBAR ===== -->
        <div class="flex justify-between items-center
                border-b-2 border-black
                bg-purple-300 px-6 py-4">

            <!-- LEFT -->
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

        <!-- ===== CONTENT ZONE ===== -->
        <div class="flex-1 bg-purple-100 p-10 flex justify-center">

            <!-- FORM BOX -->
            <div class="bg-white border-2 border-black rounded-[24px]
                    shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                    p-8 w-full max-w-2xl">

                <!-- HEADER -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-purple-300 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h1 class="text-3xl font-black text-purple-800">แก้ไขโปรไฟล์</h1>
                </div>

                <p class="text-sm text-gray-700 mb-6">อัปเดตข้อมูลส่วนตัวของคุณ</p>

                <?php 
                // Show success/error messages
                if (isset($_GET['success']) && $_GET['success'] === 'updated') {
                    echo '<div class="bg-green-100 border-2 border-green-500 text-green-800 px-4 py-3 rounded-lg mb-6 font-bold"><i class="fa-solid fa-check"></i> บันทึกข้อมูลสำเร็จ</div>';
                }
                if (isset($_GET['error'])) {
                    echo '<div class="bg-red-100 border-2 border-red-500 text-red-800 px-4 py-3 rounded-lg mb-6 font-bold"><i class="fa-solid fa-times"></i> ' . htmlspecialchars($_GET['error']) . '</div>';
                }
                ?>

                <form method="POST" action="edit_profile" class="space-y-5">

                    <!-- First Name -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">ชื่อ *</label>
                        <input type="text" name="first_name" required 
                               value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>"
                            class="w-full px-4 py-3 border-2 border-black rounded-lg
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]
                                   focus:outline-none focus:shadow-none focus:translate-x-[2px] focus:translate-y-[2px]
                                   transition-all">
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">นามสกุล *</label>
                        <input type="text" name="last_name" required 
                               value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>"
                            class="w-full px-4 py-3 border-2 border-black rounded-lg
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]
                                   focus:outline-none focus:shadow-none focus:translate-x-[2px] focus:translate-y-[2px]
                                   transition-all">
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">อีเมล (ไม่สามารถเปลี่ยน)</label>
                        <input type="email" readonly
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-100
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">วันเกิด *</label>
                        <input type="date" name="date_of_birth" required 
                               value="<?php echo htmlspecialchars($user['date_of_birth'] ?? ''); ?>"
                            class="w-full px-4 py-3 border-2 border-black rounded-lg
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]
                                   focus:outline-none focus:shadow-none focus:translate-x-[2px] focus:translate-y-[2px]
                                   transition-all">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">เพศ *</label>
                        <div class="flex gap-4 flex-wrap">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="male" 
                                       <?php echo ($user['gender'] === 'male') ? 'checked' : ''; ?> required
                                       class="w-5 h-5 border-2 border-black">
                                <span class="font-bold">ชาย <i class="fa-solid fa-mars"></i></span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="female" 
                                       <?php echo ($user['gender'] === 'female') ? 'checked' : ''; ?> required
                                       class="w-5 h-5 border-2 border-black">
                                <span class="font-bold">หญิง <i class="fa-solid fa-venus"></i></span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="other" 
                                       <?php echo ($user['gender'] === 'other') ? 'checked' : ''; ?> required
                                       class="w-5 h-5 border-2 border-black">
                                <span class="font-bold">อื่นๆ</span>
                            </label>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">เบอร์โทรศัพท์ *</label>
                        <input type="tel" name="phone_number" required 
                               value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>"
                            class="w-full px-4 py-3 border-2 border-black rounded-lg
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]
                                   focus:outline-none focus:shadow-none focus:translate-x-[2px] focus:translate-y-[2px]
                                   transition-all">
                    </div>

                    <!-- Congenital Disease -->
                    <div>
                        <label class="font-bold text-gray-800 block mb-2">โรคประจำตัว (ไม่บังคับ)</label>
                        <textarea name="congenital_disease" rows="3"
                            class="w-full px-4 py-3 border-2 border-black rounded-lg
                                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]
                                   focus:outline-none focus:shadow-none focus:translate-x-[2px] focus:translate-y-[2px]
                                   transition-all"><?php echo htmlspecialchars($user['congenital_disease'] ?? ''); ?></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 justify-center mt-8 border-t-2 border-black pt-6">
                        <button type="submit" 
                            class="px-8 py-3 bg-green-400 text-black border-2 border-black rounded-xl font-black text-lg shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-green-500 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                            บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="profile">
                            <button type="button"
                                class="px-8 py-3 bg-gray-300 text-black border-2 border-black rounded-xl font-black text-lg shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:bg-gray-400 hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                                ยกเลิก
                            </button>
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>

</html>
