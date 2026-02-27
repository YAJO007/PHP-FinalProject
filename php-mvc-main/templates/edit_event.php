<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรมที่ต้องการแก้ไข";
    return;
}

$start_date = isset($event['start_date']) ? date('Y-m-d\\TH:i', strtotime($event['start_date'])) : '';
$end_date = isset($event['end_date']) ? date('Y-m-d\\TH:i', strtotime($event['end_date'])) : '';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 
             min-h-screen p-4 sm:p-8 font-sans text-black flex">

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
                    <button class="px-6 py-2 bg-white border-2 border-black rounded-lg font-bold hover:bg-purple-100 hover:scale-110 transition-all">
                        กิจกรรมของฉัน
                    </button>
                </a>

                <a href="my_registrations">
                    <button class="px-6 py-2 bg-blue-600 text-white border-2 border-black
                           rounded-lg font-bold hover:scale-110 transition-all">
                        <i class="fa-solid fa-users"></i> ดูการลงทะเบียน
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
                    <button class="px-6 py-2 bg-white border-2 border-black rounded-lg font-bold hover:bg-purple-100 hover:scale-110 transition-all">
                        โปรไฟล์
                    </button>
                </a>
            </div>

            <button class="w-10 h-10 flex items-center justify-center 
                       bg-purple-600 text-white border-2 border-black rounded-md hover:scale-110 transition-all">
                ☰
            </button>
        </div>

        <div class="flex-1 bg-purple-100 p-10 flex justify-center">

            <div class="bg-white border-2 border-black rounded-[24px]
                    shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                    p-8 w-full max-w-xl">

                <div class="flex items-center gap-3 mb-6">
                    <img src="/LOGO/LOGOCAT.png" class="w-12 bg-white p-1 border-2 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    <h1 class="text-3xl font-black text-purple-800">แก้ไขกิจกรรม</h1>
                </div>

                <p class="text-sm text-gray-700 mb-6">อัปเดตข้อมูลกิจกรรมของคุณ</p>

                <form method="POST" action="edit_event"
                    class="space-y-5" enctype="multipart/form-data">

                    <input type="hidden" name="eid" value="<?php echo htmlspecialchars($event['eid']); ?>">

                    <div>
                        <label class="font-bold">ชื่อกิจกรรม</label>
                        <input type="text" name="title" required value="<?php echo htmlspecialchars($event['title'] ?? ''); ?>"
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <div>
                        <label class="font-bold">รายละเอียดกิจกรรม</label>
                        <textarea name="detail" rows="3" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]"><?php echo htmlspecialchars($event['Details'] ?? ''); ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold">เริ่มกิจกรรม</label>
                            <input type="datetime-local" name="start_date" required value="<?php echo $start_date; ?>"
                                class="w-full px-3 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        </div>
                        <div>
                            <label class="font-bold">สิ้นสุดกิจกรรม</label>
                            <input type="datetime-local" name="end_date" required value="<?php echo $end_date; ?>"
                                class="w-full px-3 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold">จำนวนผู้เข้าร่วม</label>
                        <input type="number" name="max_participants" required value="<?php echo htmlspecialchars($event['max_participants'] ?? ''); ?>"
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <div>
                        <label class="font-bold">รูปภาพกิจกรรม</label>
                        <?php if (!empty($event['image_path'])): ?>
                            <div class="mb-3 p-3 border-2 border-gray-300 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-600 mb-2">รูปภาพปัจจุบัน:</p>
                                <div class="relative">
                                    <img src="/img/<?php echo htmlspecialchars($event['image_path']); ?>" 
                                         alt="Event Image" 
                                         class="w-full h-48 object-cover border-2 border-black rounded-lg">
                                    <button type="submit" name="action" value="delete_image"
                                        class="absolute top-2 right-2 px-3 py-1 bg-red-500 text-white border-2 border-black rounded-lg font-bold text-sm hover:scale-110 transition-all"
                                        onclick="return confirm('ลบรูปภาพนี้ใช่หรือไม่?')">
                                        <i class="fa-solid fa-trash"></i> ลบ
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <label for="image_input" class="block px-4 py-3 border-2 border-dashed border-purple-400 rounded-lg bg-purple-50 cursor-pointer hover:bg-purple-100 transition-all text-center">
                            <i class="fa-solid fa-cloud-arrow-up"></i> อัพโหลดรูปภาพใหม่
                        </label>
                        <input type="file" name="image" id="image_input" accept="image/*" class="hidden">
                        <p class="text-xs text-gray-600 mt-2" id="filename-display">ฟอร์แมตที่รองรับ: JPG, PNG, GIF (ขนาดสูงสุด 5MB)</p>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-purple-600 text-white
                           border-2 border-black rounded-lg font-bold
                           shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                           hover:translate-x-1 hover:translate-y-1
                           hover:shadow-none transition-all">
                            <i class="fa-solid fa-save"></i> บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="my_event" class="flex-1">
                            <button type="button"
                                class="w-full px-6 py-3 bg-gray-400 text-white
                               border-2 border-black rounded-lg font-bold
                               shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                               hover:translate-x-1 hover:translate-y-1
                               hover:shadow-none transition-all">
                                <i class="fa-solid fa-times"></i> ยกเลิก
                            </button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle image input display
        const imageInput = document.getElementById('image_input');
        const filenameDisplay = document.getElementById('filename-display');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                filenameDisplay.textContent = `✓ เลือกไฟล์: ${fileName} (${fileSize} MB)`;
            }
        });

        // Clear action field when uploading new image
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const imageFile = imageInput.files.length;
            if (imageFile > 0) {
                // Remove the action field to prevent delete_image action
                const actionInput = document.querySelector('input[name="action"]');
                if (actionInput) actionInput.remove();
            }
        });
    </script>

</body>
</html>