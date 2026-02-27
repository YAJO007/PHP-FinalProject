<?php
if (!isset($event) || !is_array($event)) {
    echo "ไม่พบกิจกรรม";
    return;
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title'] ?? 'รายละเอียดกิจกรรม'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .gallery-container {
            position: relative;
        }
        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease-in-out;
        }
        .main-image.fade-out {
            opacity: 0;
        }
        .main-image.fade-in {
            opacity: 1;
        }
        .thumbnail-carousel {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            overflow-x: auto;
            padding: 5px 0;
        }
        .thumbnail-carousel::-webkit-scrollbar {
            height: 6px;
        }
        .thumbnail-carousel::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .thumbnail-carousel::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        .thumbnail {
            width: 60px;
            height: 60px;
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            object-fit: cover;
        }
        .thumbnail:hover {
            transform: scale(1.05);
            border-color: rgba(0,0,0,0.3);
        }
        .thumbnail.active {
            border-color: #000;
            box-shadow: 0 0 8px rgba(0,0,0,0.4);
        }
        .gallery-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 40px;
            height: 40px;
            background: rgba(0,0,0,0.5);
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .gallery-nav-btn:hover {
            background: rgba(0,0,0,0.8);
        }
        .gallery-nav-btn.prev {
            left: 10px;
        }
        .gallery-nav-btn.next {
            right: 10px;
        }
        .image-counter {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white border-2 border-black rounded-[24px]
            shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]
            max-w-5xl w-full overflow-hidden">

        <div class="bg-purple-300 border-b-2 border-black px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-black text-purple-900">รายละเอียดกิจกรรม</h1>
            <a href="event" class="px-4 py-1 bg-white border-2 border-black rounded-lg font-bold hover:scale-110 transition-all">
                <i class="fa-solid fa-times"></i> ปิด
            </a>
        </div>

        <div class="p-8 bg-purple-100 grid md:grid-cols-2 gap-8">

            <div class="gallery-container bg-purple-100 border-2 border-black rounded-xl shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] overflow-hidden relative">
                <?php 
                $images = $event['images'] ?? [];
                if (empty($images)) {
                    $images = [];
                }
                ?>
                
                <!-- Main Image -->
                <div class="relative w-full h-96">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $index => $image): ?>
                            <img src="img/<?= htmlspecialchars($image) ?>" 
                                 class="main-image absolute inset-0 w-full h-full object-cover transition-opacity duration-300"
                                 alt="<?php echo htmlspecialchars($event['title'] ?? ''); ?>"
                                 data-index="<?= $index ?>"
                                 <?= $index === 0 ? '' : 'style="opacity: 0; display: none;"' ?>>
                        <?php endforeach; ?>
                        
                        <?php if (count($images) > 1): ?>
                            <!-- Navigation Buttons -->
                            <button class="gallery-nav-btn prev" onclick="changeImage(-1)">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button class="gallery-nav-btn next" onclick="changeImage(1)">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                            
                            <!-- Image Counter -->
                            <div class="image-counter">
                                <span id="current-image">1</span> / <span id="total-images"><?= count($images) ?></span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="w-full h-96 flex items-center justify-center bg-gray-300">
                            <div class="text-center">
                                <i class="fa-solid fa-image text-4xl text-gray-500 mb-2"></i>
                                <p class="text-gray-600">ไม่มีรูปภาพ</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($images) && count($images) > 1): ?>
                    <div class="thumbnail-carousel">
                        <?php foreach ($images as $index => $image): ?>
                            <img src="img/<?= htmlspecialchars($image) ?>"
                                 class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
                                 alt="Thumbnail <?= $index + 1 ?>"
                                 onclick="showImage(<?= $index ?>)"
                                 data-index="<?= $index ?>">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="space-y-4">
                <h2 class="text-3xl font-black text-purple-800"><?php echo htmlspecialchars($event['title'] ?? ''); ?></h2>

                <p class="text-gray-800 font-medium">
                    <?php echo nl2br(htmlspecialchars($event['Details'] ?? '')); ?>
                </p>

                <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                    <p><i class="fa-solid fa-calendar"></i> วันที่เริ่ม: <?php echo htmlspecialchars($event['start_date'] ?? ''); ?></p>
                    <p><i class="fa-solid fa-calendar-check"></i> วันที่สิ้นสุด: <?php echo htmlspecialchars($event['end_date'] ?? ''); ?></p>
                    <p><i class="fa-solid fa-users"></i> รับสมัคร: <?php echo htmlspecialchars($event['max_participants'] ?? ''); ?> คน</p>
                    <?php if (!empty($event['address'])): ?>
                        <p><i class="fa-solid fa-map-location-dot"></i> สถานที่: 
                            <?php 
                            $address_parts = [];
                            if (!empty($event['address']['Address_line'])) $address_parts[] = htmlspecialchars($event['address']['Address_line']);
                            if (!empty($event['address']['district'])) $address_parts[] = htmlspecialchars($event['address']['district']);
                            if (!empty($event['address']['province'])) $address_parts[] = htmlspecialchars($event['address']['province']);
                            echo implode(', ', $address_parts);
                            ?>
                        </p>
                    <?php endif; ?>
                    <?php
                    $status = $event['status'] ?? '';
                    $statusBg = '';
                    $statusBorder = '';
                    $statusIcon = '';
                    $statusText = '';

                    switch ($status) {
                        case 'Upcoming':
                            $statusBg = 'bg-green-100';
                            $statusBorder = 'border-green-500';
                            $statusIcon = '<i class="fa-regular fa-clock"></i>';
                            $statusText = 'กำลังจะมาถึง';
                            break;
                        case 'Live':
                            $statusBg = 'bg-yellow-100';
                            $statusBorder = 'border-yellow-500';
                            $statusIcon = '<i class="fa-solid fa-hourglass-start"></i>';
                            $statusText = 'กำลังดำเนินอยู่';
                            break;
                        case 'Completed':
                            $statusBg = 'bg-red-100';
                            $statusBorder = 'border-red-500';
                            $statusIcon = '<i class="fa-solid fa-check-circle"></i>';
                            $statusText = 'จบแล้ว';
                            break;
                        default:
                            $statusBg = 'bg-gray-50';
                            $statusBorder = 'border-gray-400';
                            $statusIcon = '<i class="fa-solid fa-clipboard"></i>';
                            $statusText = $status;
                    }
                    ?>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 <?= $statusBg ?> <?= $statusBorder ?> shadow-sm">
                        <span class="text-xl"><?= $statusIcon ?></span>
                        <div>
                            <p class="text-xs text-gray-600 font-medium">สถานะ</p>
                            <p class="font-bold text-sm"><?= $statusText ?></p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($event['requirements'])): ?>
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <h3 class="font-bold text-lg mb-3 text-purple-800">
                            <i class="fa-solid fa-list-check"></i> ความต้องการ
                        </h3>
                        <div class="space-y-2">
                            <?php foreach ($event['requirements'] as $requirement): ?>
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-check-circle text-green-600 mt-1"></i>
                                    <span class="text-gray-700"><?= htmlspecialchars($requirement) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php 
                $is_logged_in = isset($_SESSION['email']);
                $user_id = $is_logged_in ? getUidByEmail($_SESSION['email']) : null;
                $is_registered = $user_id ? isUserReg($user_id, (int)$event['eid']) : false;
                $registration_status = $user_id ? getUserRegStatus($user_id, (int)$event['eid']) : null;
                $event_status = $event['status'] ?? '';
                $is_completed = ($event_status === 'Completed');
                ?>
                
                <?php if ($is_logged_in && $is_registered): ?>
                    <div class="bg-white border-2 border-black rounded-lg p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <div class="flex items-center gap-2">
                            <?php if ($registration_status === 'Approved'): ?>
                                <i class="fa-solid fa-check-circle text-green-600"></i>
                                <span class="text-green-700 font-bold">ได้รับการอนุมัติให้เข้าร่วมกิจกรรมแล้ว</span>
                            <?php elseif ($registration_status === 'Pending'): ?>
                                <i class="fa-solid fa-clock text-yellow-600"></i>
                                <span class="text-yellow-700 font-bold">รอการอนุมัติจากผู้จัดงาน</span>
                            <?php elseif ($registration_status === 'Rejected'): ?>
                                <i class="fa-solid fa-times-circle text-red-600"></i>
                                <span class="text-red-700 font-bold">ไม่ได้รับการอนุมัติ</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-4 gap-2 pt-2 max-w-3xl">
                    <?php if (!$is_logged_in): ?>
                        <a href="login" class="col-span-4">
                            <button class="w-full px-6 py-3 bg-orange-500 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all
                                       text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-sign-in-alt"></i>
                                เข้าสู่ระบบเพื่อลงทะเบียน
                            </button>
                        </a>
                    <?php elseif ($is_completed): ?>
                        <div class="col-span-4">
                            <button class="w-full px-6 py-3 bg-gray-500 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       text-sm flex items-center justify-center gap-2 whitespace-nowrap cursor-not-allowed"
                                       disabled>
                                <i class="fa-solid fa-calendar-times"></i>
                                กิจกรรมจบแล้ว ไม่สามารถลงทะเบียนได้
                            </button>
                        </div>
                    <?php elseif (!$is_registered): ?>
                        <form action="register_event" method="POST" class="col-span-4">
                            <input type="hidden" name="eid" value="<?= (int)$event['eid'] ?>">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-purple-600 text-white border-2 border-black rounded-lg font-bold
                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                       hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all
                       text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                ลงทะเบียน
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="col-span-4">
                            <button class="w-full px-6 py-3 bg-gray-400 text-white border-2 border-black rounded-lg font-bold
                                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                                       text-sm flex items-center justify-center gap-2 whitespace-nowrap cursor-not-allowed"
                                       disabled>
                                <i class="fa-solid fa-check"></i>
                                ลงทะเบียนแล้ว
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>


</body>

</html>

<script>
let currentImageIndex = 0;
const images = document.querySelectorAll('.main-image');
const thumbnails = document.querySelectorAll('.thumbnail');
const totalImages = images.length;

function showImage(index) {
    if (totalImages === 0) return;
    
    if (index < 0) {
        currentImageIndex = totalImages - 1;
        currentImageIndex = 0;
    } else {
        currentImageIndex = index;
    }

    images.forEach((img, idx) => {
        if (idx === currentImageIndex) {
            img.style.opacity = '1';
        } else {
            img.style.opacity = '0';
            img.style.display = 'none';
        }
    });

    thumbnails.forEach((thumb, idx) => {
        if (idx === currentImageIndex) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });

    const counter = document.getElementById('current-image');
    if (counter) {
        counter.textContent = currentImageIndex + 1;
    }
}

function changeImage(direction) {
    showImage(currentImageIndex + direction);
}

document.addEventListener('keydown', function(event) {
    if (totalImages <= 1) return;
    
    if (event.key === 'ArrowLeft') {
        changeImage(-1);
    } else if (event.key === 'ArrowRight') {
        changeImage(1);
    }
});
</script>