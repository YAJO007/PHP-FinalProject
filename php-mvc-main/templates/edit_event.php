<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรมที่ต้องการแก้ไข";
    return;
}

$start_date = isset($event['start_date']) ? date('Y-m-d\\TH:i', strtotime($event['start_date'])) : '';
$end_date = isset($event['end_date']) ? date('Y-m-d\\TH:i', strtotime($event['end_date'])) : '';
$show_success = isset($_GET['success']) && $_GET['success'] === '1';
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

            <?php if ($show_success): ?>
                <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50">
                    <i class="fa-solid fa-check-circle"></i>
                    <span>บันทึกสำเร็จ! รูปภาพถูกอัพโหลดแล้ว</span>
                </div>
            <?php endif; ?>

            <div class="bg-white border-2 border-black rounded-[24px]
                    shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                    p-8 w-full max-w-xl">

                <div class="flex items-center gap-3 mb-6">
                    <img src="/LOGO/LOGOCAT.png" class="w-12 bg-white p-1 border-2 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    <h1 class="text-3xl font-black text-purple-800">แก้ไขกิจกรรม</h1>
                </div>

                <p class="text-sm text-gray-700 mb-6">อัปเดตข้อมูลกิจกรรมของคุณ</p>
                
                <!-- DEBUG: Show image count -->
                <div class="bg-yellow-100 border-2 border-yellow-400 px-3 py-2 rounded text-sm text-yellow-800 mb-4">
                    <?php echo "รูปภาพปัจจุบัน: " . count($event['images'] ?? []) . " รูป"; ?>
                </div>

                <form method="POST" action="edit_event"
                    class="space-y-5" enctype="multipart/form-data">

                    <input type="hidden" name="eid" value="<?php echo htmlspecialchars($event['eid']); ?>">
                    <input type="hidden" name="action" value="update">

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
                        
                        <!-- Display existing images -->
                        <?php 
                        $images = $event['images'] ?? [];
                        error_log("DEBUG template: Found " . count($images) . " images for event " . $event['eid']);
                        if (!empty($images)) {
                            echo '<div class="mb-4 p-3 border-2 border-gray-300 rounded-lg bg-gray-50">';
                            echo '<p class="text-sm text-gray-600 mb-3 font-bold">รูปภาพปัจจุบัน:</p>';
                            echo '<div class="space-y-3" id="existing-images-container">';
                            
                            foreach ($images as $image) {
                                echo '<div class="relative border-2 border-gray-400 rounded-lg overflow-hidden bg-white">';
                                echo '  <div class="flex items-start gap-3 p-2">';
                                echo '    <input type="checkbox" name="delete_images[]" value="' . htmlspecialchars($image) . '" class="mt-1 w-5 h-5 cursor-pointer">';
                                echo '    <div class="flex-1">';
                                echo '      <img src="/img/' . htmlspecialchars($image) . '" alt="Event Image" class="w-24 h-24 object-cover border-2 border-gray-300 rounded">';
                                echo '      <p class="text-xs text-gray-500 mt-1 break-all">' . htmlspecialchars($image) . '</p>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            
                            echo '</div>';
                            echo '<p class="text-xs text-red-600 mt-2"><i class="fa-solid fa-info-circle"></i> เลือกรูปที่ต้องการลบ แล้วคลิค "บันทึก"</p>';
                            echo '</div>';
                        }
                        ?>
                        
                        <!-- Upload new images -->
                        <div class="mt-3">
                            <button type="button" class="block w-full px-4 py-3 border-2 border-dashed border-purple-400 rounded-lg bg-purple-50 cursor-pointer hover:bg-purple-100 transition-all text-center" onclick="document.getElementById('images_input').click()">
                                <i class="fa-solid fa-cloud-arrow-up"></i> อัพโหลดรูปภาพใหม่
                            </button>
                            <input type="file" name="images" id="images_input" accept="image/*" multiple style="display: none;">
                            <p class="text-xs text-gray-600 mt-2" id="filename-display">ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB ต่อรูป</p>
                            <div id="image-preview-container" class="mt-3 grid grid-cols-3 gap-2 hidden">
                                <!-- Preview images here -->
                            </div>
                        </div>

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

                    <!-- Handle delete_images action -->
                    <script>
                        const form = document.querySelector('form');
                        form.addEventListener('submit', function(e) {
                            const checkboxes = document.querySelectorAll('input[name="delete_images[]"]:checked');
                            const newImages = document.getElementById('images_input').files.length;
                            
                            // If deleting images, set action
                            if (checkboxes.length > 0 && newImages === 0) {
                                const actionInput = document.querySelector('input[name="action"]');
                                if (actionInput) {
                                    actionInput.value = 'delete_images';
                                }
                            }
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide success notification and refresh page
        const successNotif = document.querySelector('[class*="bg-green-500"]');
        if (successNotif) {
            setTimeout(() => {
                // Reload page to show newly uploaded images
                location.reload();
            }, 1500);
        }

        // Handle multiple image input display
        const imagesInput = document.getElementById('images_input');
        const filenameDisplay = document.getElementById('filename-display');
        const previewContainer = document.getElementById('image-preview-container');
        
        if (!imagesInput) {
            console.error('File input not found!');
        } else {
            console.log('File input found, ready for upload');
        }
        
        imagesInput.addEventListener('change', function() {
            console.log('Files selected:', this.files.length);
            previewContainer.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                previewContainer.classList.remove('hidden');
                let totalSize = 0;
                let validFiles = 0;
                
                console.log('Processing', this.files.length, 'selected files');
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const fileSize = file.size / 1024 / 1024;
                    console.log(`File ${i}:`, file.name, `(${fileSize.toFixed(2)} MB)`);
                    
                    // Check file size
                    if (fileSize > 5) {
                        continue; // Skip files larger than 5MB
                    }
                    
                    validFiles++;
                    totalSize += fileSize;
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'relative border-2 border-purple-300 rounded overflow-hidden';
                        preview.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover">
                            <p class="text-xs text-gray-600 p-1 bg-purple-50 truncate">${file.name}</p>
                        `;
                        previewContainer.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                }
                
                filenameDisplay.textContent = `✓ เลือก ${validFiles} รูป (รวม ${totalSize.toFixed(2)} MB)`;
            } else {
                previewContainer.classList.add('hidden');
                filenameDisplay.textContent = 'ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB ต่อรูป';
            }
        });
    </script>

</body>
</html>