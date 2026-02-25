<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างกิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 
             min-h-screen p-4 sm:p-8 font-sans text-black flex">

    <!-- MAIN CONTAINER -->
    <div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            flex flex-col overflow-hidden 
            max-w-7xl mx-auto w-full">

        <!-- ===== NAVBAR (เหมือนหน้า event) ===== -->
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
                <button class="px-6 py-2 bg-purple-600 text-white 
                               border-2 border-black rounded-lg font-bold 
                               shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                               hover:translate-x-1 hover:translate-y-1 
                               hover:shadow-none transition-all">
                    สร้างกิจกรรม
                </button>

                <a href="profile">
                    <button class="px-6 py-2 bg-white border-2 border-black rounded-lg font-bold hover:bg-purple-100 hover:scale-110 transition-all">
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

        <!-- ===== CONTENT ZONE (เปลี่ยนเฉพาะตรงนี้) ===== -->
        <div class="flex-1 bg-purple-100 p-10 flex justify-center">

            <!-- FORM BOX -->
            <div class="bg-white border-2 border-black rounded-[24px]
                    shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                    p-8 w-full max-w-xl">

                <!-- HEADER -->
                <div class="flex items-center gap-3 mb-6">
                    <img src="/LOGO/LOGOCAT.png" class="w-12 bg-white p-1 border-2 border-black rounded-xl shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    <h1 class="text-3xl font-black text-purple-800">สร้างกิจกรรมใหม่</h1>
                </div>

                <p class="text-sm text-gray-700 mb-6">กรอกข้อมูลกิจกรรมของคุณ</p>

                <form method="POST" action="create_event"
                    enctype="multipart/form-data"
                    class="space-y-5">

                    <div>
                        <label class="font-bold">ชื่อกิจกรรม</label>
                        <input name="title" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <div>
                        <label class="font-bold">รายละเอียดกิจกรรม</label>
                        <textarea name="detail" rows="3" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold">เริ่มกิจกรรม</label>
                            <input type="datetime-local" name="start_date" required
                                class="w-full px-3 py-2 border-2 border-black rounded-lg
                       shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        </div>

                        <div>
                            <label class="font-bold">จบกิจกรรม</label>
                            <input type="datetime-local" name="end_date" required
                                class="w-full px-3 py-2 border-2 border-black rounded-lg
                       shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                        </div>
                    </div>

                    <div>
                        <label class="font-bold">จังหวัด</label>
                        <input type="text" name="province" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                     shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>
                    <div>
                        <label class="font-bold">เขต/อำเภอ</label>
                        <input type="text" name="district" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                     shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>
                    <div>
                        <label class="font-bold">รายละเอียดที่อยู่</label>
                        <input type="text" name="address" placeholder="ตึก IT ชั้น 4 ห้อง ***" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                     shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>
                    <div>
                        <label class="font-bold">ข้อกำหนดเพิ่มเติม</label>
                        <input type="text" name="requirement" placeholder="เช่น ต้องมีความรู้พื้นฐานด้านคอมพิวเตอร์, การแต่งกาย" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                     shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>
                    <div>
                        <label class="font-bold">จำนวนผู้เข้าร่วม</label>
                        <input type="number" name="max_participants" min="1" required
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <div>
                        <label class="font-bold">รูปภาพกิจกรรม</label>
                        <input type="file" name="image"
                            accept="image/jpeg,image/png"
                            class="w-full px-4 py-2 border-2 border-black rounded-lg
                   shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 bg-purple-600 text-white font-bold py-3
                   border-2 border-black rounded-lg
                   shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                   hover:translate-x-1 hover:translate-y-1
                   hover:shadow-none transition-all">
                            สร้างกิจกรรม
                        </button>

                        <button type="reset"
                            class="flex-1 bg-white font-bold py-3
                   border-2 border-black rounded-lg
                   shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                   hover:bg-purple-100">
                            รีเซ็ต
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</body>

</html>