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

                    <!-- Cover Image Section (Single Image) -->
                    <div class="bg-purple-50 border-2 border-purple-300 rounded-lg p-4">
                        <h3 class="font-bold text-purple-800 mb-3">
                            <i class="fa-solid fa-image"></i> รูปหน้าปกกิจกรรม (รูปเดียว)
                        </h3>
                        
                        <!-- Display current cover image -->
                        <?php 
                        $images = $event['images'] ?? [];
                        $cover_image = !empty($images) ? $images[0] : null;
                        if ($cover_image) {
                            echo '<div class="mb-4 p-3 border-2 border-purple-200 rounded-lg bg-white">';
                            echo '<p class="text-sm text-purple-600 mb-3 font-bold">รูปหน้าปกปัจจุบัน:</p>';
                            echo '<div class="flex items-start gap-3">';
                            echo '  <input type="checkbox" name="delete_cover_image" value="' . htmlspecialchars($cover_image) . '" class="mt-1 w-5 h-5 cursor-pointer">';
                            echo '  <div class="flex-1">';
                            echo '    <img src="/img/' . htmlspecialchars($cover_image) . '" alt="Cover Image" class="w-32 h-32 object-cover border-2 border-purple-300 rounded">';
                            echo '    <p class="text-xs text-gray-500 mt-1 break-all">' . htmlspecialchars($cover_image) . '</p>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<p class="text-xs text-purple-600 mt-2"><i class="fa-solid fa-info-circle"></i> เลือกเพื่อลบรูปหน้าปก แล้วอัพโหลดรูปใหม่</p>';
                            echo '</div>';
                        } else {
                            echo '<div class="mb-4 p-3 border-2 border-gray-200 rounded-lg bg-gray-50">';
                            echo '<p class="text-sm text-gray-600"><i class="fa-solid fa-info-circle"></i> ยังไม่มีรูปหน้าปก</p>';
                            echo '</div>';
                        }
                        ?>
                        
                        <!-- Upload new cover image -->
                        <div>
                            <button type="button" class="block w-full px-4 py-3 border-2 border-dashed border-purple-400 rounded-lg bg-purple-50 cursor-pointer hover:bg-purple-100 transition-all text-center" onclick="document.getElementById('cover_image_input').click()">
                                <i class="fa-solid fa-cloud-arrow-up"></i> อัพโหลดรูปหน้าปกใหม่ (รูปเดียว)
                            </button>
                            <input type="file" name="cover_image" id="cover_image_input" accept="image/jpeg,image/png,image/gif" style="display: none;">
                            <p class="text-xs text-gray-600 mt-2" id="cover-filename-display">ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB</p>
                            <div id="cover-image-preview-container" class="mt-3 hidden">
                                <!-- Preview image here -->
                            </div>
                        </div>
                    </div>

                    <!-- Additional Images Section (Multiple Images) -->
                    <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                        <h3 class="font-bold text-blue-800 mb-3">
                            <i class="fa-solid fa-images"></i> รูปกิจกรรมเพิ่มเติม (หลายรูป)
                        </h3>
                        
                        <!-- Display current additional images -->
                        <?php 
                        $additional_images = array_slice($images, 1); // Skip first image (cover)
                        if (!empty($additional_images)) {
                            echo '<div class="mb-4 p-3 border-2 border-blue-200 rounded-lg bg-white">';
                            echo '<p class="text-sm text-blue-600 mb-3 font-bold">รูปเพิ่มเติมปัจจุบัน (' . count($additional_images) . ' รูป):</p>';
                            echo '<div class="space-y-2">';
                            foreach ($additional_images as $index => $image) {
                                echo '<div class="flex items-start gap-3 p-2 border border-blue-200 rounded">';
                                echo '  <input type="checkbox" name="delete_additional_images[]" value="' . htmlspecialchars($image) . '" class="mt-1 w-5 h-5 cursor-pointer">';
                                echo '  <div class="flex-1">';
                                echo '    <img src="/img/' . htmlspecialchars($image) . '" alt="Additional Image" class="w-24 h-24 object-cover border-2 border-blue-200 rounded">';
                                echo '    <p class="text-xs text-gray-500 mt-1 break-all">' . htmlspecialchars($image) . '</p>';
                                echo '  </div>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '<p class="text-xs text-blue-600 mt-2"><i class="fa-solid fa-info-circle"></i> เลือกรูปที่ต้องการลบ และ/หรือ เพิ่มรูปใหม่ด้านล่าง</p>';
                            echo '</div>';
                        } else {
                            echo '<div class="mb-4 p-3 border-2 border-gray-200 rounded-lg bg-gray-50">';
                            echo '<p class="text-sm text-gray-600"><i class="fa-solid fa-info-circle"></i> ยังไม่มีรูปเพิ่มเติม</p>';
                            echo '</div>';
                        }
                        ?>
                        
                        <!-- Upload additional images -->
                        <div>
                            <button type="button" class="block w-full px-4 py-3 border-2 border-dashed border-blue-400 rounded-lg bg-blue-50 cursor-pointer hover:bg-blue-100 transition-all text-center" onclick="document.getElementById('additional_images_input').click()">
                                <i class="fa-solid fa-cloud-arrow-up"></i> เพิ่มรูปกิจกรรม (หลายรูป)
                            </button>
                            <input type="file" name="additional_images[]" id="additional_images_input" accept="image/jpeg,image/png,image/gif" multiple style="display: none;">
                            <p class="text-xs text-gray-600 mt-2" id="additional-filename-display">ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB ต่อรูป</p>
                            <div id="additional-images-preview-container" class="mt-3 hidden">
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

                    <!-- Updated form submission handling -->
                    <script>
                        const editForm = document.querySelector('form');
                        editForm.addEventListener('submit', function(e) {
                            const deleteCoverCheckbox = document.querySelector('input[name="delete_cover_image"]:checked');
                            const deleteAdditionalCheckboxes = document.querySelectorAll('input[name="delete_additional_images[]"]:checked');
                            const newCoverImage = document.getElementById('cover_image_input').files.length;
                            const newAdditionalImages = document.getElementById('additional_images_input').files.length;
                            
                            const actionInput = document.querySelector('input[name="action"]');
                            if (actionInput) {
                                if (deleteCoverCheckbox && newCoverImage === 0 && newAdditionalImages === 0 && deleteAdditionalCheckboxes.length === 0) {
                                    actionInput.value = 'delete_cover_image';
                                } else if (deleteAdditionalCheckboxes.length > 0 && newCoverImage === 0 && newAdditionalImages === 0 && !deleteCoverCheckbox) {
                                    actionInput.value = 'delete_additional_images';
                                } else {
                                    actionInput.value = 'update';
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
            location.reload();
        }, 1500);
    }

    // Handle cover image input
    const coverImageInput = document.getElementById('cover_image_input');
    const coverFilenameDisplay = document.getElementById('cover-filename-display');
    const coverPreviewContainer = document.getElementById('cover-image-preview-container');
    
    if (coverImageInput) {
        coverImageInput.addEventListener('change', function() {
            coverPreviewContainer.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                coverPreviewContainer.classList.remove('hidden');
                const file = this.files[0];
                const fileSize = file.size / 1024 / 1024;
                
                if (fileSize > 5) {
                    coverFilenameDisplay.textContent = '❌ ไฟล์ใหญ่เกินไป (สูงสุด 5MB)';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'relative border-2 border-purple-300 rounded overflow-hidden';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover">
                        <p class="text-xs text-gray-600 p-1 bg-purple-50 truncate">${file.name}</p>
                    `;
                    coverPreviewContainer.appendChild(preview);
                    coverFilenameDisplay.textContent = `✓ เลือกรูปหน้าปก: ${file.name} (${fileSize.toFixed(2)} MB)`;
                };
                reader.readAsDataURL(file);
            } else {
                coverPreviewContainer.classList.add('hidden');
                coverFilenameDisplay.textContent = 'ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB';
            }
        });
    }

    // Handle additional images input
    const additionalImagesInput = document.getElementById('additional_images_input');
    const additionalFilenameDisplay = document.getElementById('additional-filename-display');
    const additionalPreviewContainer = document.getElementById('additional-images-preview-container');
    
    if (additionalImagesInput) {
        additionalImagesInput.addEventListener('change', function() {
            additionalPreviewContainer.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                additionalPreviewContainer.classList.remove('hidden');
                let validFiles = 0;
                let totalSize = 0;
                
                Array.from(this.files).forEach((file, index) => {
                    const fileSize = file.size / 1024 / 1024;
                    totalSize += fileSize;
                    
                    if (fileSize > 5) {
                        return;
                    }
                    
                    validFiles++;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'relative border-2 border-blue-300 rounded overflow-hidden mb-2';
                        preview.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover">
                            <p class="text-xs text-gray-600 p-1 bg-blue-50 truncate">${file.name}</p>
                        `;
                        additionalPreviewContainer.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                });
                
                if (validFiles > 0) {
                    additionalFilenameDisplay.textContent = `✓ เลือกรูปเพิ่มเติม: ${validFiles} รูป (รวม ${totalSize.toFixed(2)} MB)`;
                } else {
                    additionalFilenameDisplay.textContent = '❌ ไม่มีรูปที่ถูกต้อง (ไฟล์ใหญ่เกิน 5MB)';
                    additionalPreviewContainer.classList.add('hidden');
                }
            } else {
                additionalPreviewContainer.classList.add('hidden');
                additionalFilenameDisplay.textContent = 'ฟอร์แมตที่รองรับ: JPG, PNG, GIF | สูงสุด 5MB ต่อรูป';
            }
        });
    }

    // Update form submission logic
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const deleteCoverCheckbox = document.querySelector('input[name="delete_cover_image"]:checked');
            const deleteAdditionalCheckboxes = document.querySelectorAll('input[name="delete_additional_images[]"]:checked');
            const newCoverImage = document.getElementById('cover_image_input').files.length;
            const newAdditionalImages = document.getElementById('additional_images_input').files.length;
            
            const actionInput = document.querySelector('input[name="action"]');
            if (actionInput) {
                if (deleteCoverCheckbox && newCoverImage === 0 && newAdditionalImages === 0 && deleteAdditionalCheckboxes.length === 0) {
                    actionInput.value = 'delete_cover_image';
                } else if (deleteAdditionalCheckboxes.length > 0 && newCoverImage === 0 && newAdditionalImages === 0 && !deleteCoverCheckbox) {
                    actionInput.value = 'delete_additional_images';
                } else {
                    actionInput.value = 'update';
                }
            }
        });
    }
</script>