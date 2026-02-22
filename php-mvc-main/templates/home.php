<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหากิจกรรม</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 
             min-h-screen p-4 sm:p-8 font-sans text-black flex">

<div class="bg-white border-2 border-black rounded-[24px] 
            shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] 
            flex flex-col overflow-hidden 
            max-w-7xl mx-auto w-full">

    <!-- ===== TOP NAV ===== -->
<div class="flex justify-between items-center 
            border-b-2 border-black 
            bg-purple-300 px-6 py-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-4 flex-wrap">

        <!-- ปุ่มเข้าสู่ระบบ (ย้ายมาไว้ซ้ายสุด) -->
         <a href="login">
        <button class="px-6 py-2 bg-purple-600 text-white 
                       border-2 border-black rounded-lg font-bold 
                       shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]
                       hover:translate-x-1 hover:translate-y-1 
                       hover:shadow-none transition-all duration-150">
            เข้าสู่ระบบ
        </button>
        </a>

        <button class="px-6 py-2 bg-white border-2 border-black 
                       rounded-lg font-bold hover:bg-purple-100">
            กิจกรรมของฉัน
        </button>

        <button class="px-6 py-2 bg-purple-500 text-white 
                       border-2 border-black rounded-lg font-bold">
            สร้างกิจกรรม
        </button>

        <button class="px-6 py-2 bg-white border-2 border-black 
                       rounded-lg font-bold hover:bg-purple-100">
            โปรไฟล์
        </button>

    </div>

    <!-- RIGHT SIDE (เมนูไอคอน) -->
    <button class="w-10 h-10 flex items-center justify-center 
                   bg-purple-600 text-white 
                   border-2 border-black rounded-md
                   hover:rotate-12 transition-all">
        ☰
    </button>
</div>


    <!-- ===== SEARCH SECTION ===== -->
    <div class="p-8 bg-purple-100 border-b-2 border-black">

        <div class="bg-purple-200 border-2 border-black 
                    rounded-xl p-6 
                    shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]">

            <h2 class="text-4xl font-black mb-6 text-purple-900">
                ค้นหากิจกรรม
            </h2>

            <!-- search bar -->
            <div class="flex gap-3 mb-6">
                <input type="text" placeholder="ค้นหากิจกรรม..."
                       class="flex-1 px-4 py-3 border-2 border-black 
                              rounded-lg bg-white font-medium
                              focus:ring-4 focus:ring-purple-400
                              transition-all">

                <button class="px-5 bg-purple-600 text-white
                               border-2 border-black rounded-lg font-bold
                               hover:scale-110 transition-all">
                    🔍
                </button>
            </div>

            <!-- date filter -->
            <div class="flex flex-wrap gap-6 items-center">

                <div class="flex items-center gap-3">
                    <label class="font-bold text-purple-900">วันที่เริ่ม:</label>
                    <input type="date"
                           class="px-4 py-2 border-2 border-black 
                                  rounded-lg bg-purple-500 text-white
                                  focus:ring-4 focus:ring-purple-300
                                  transition-all">
                </div>

                <div class="flex items-center gap-3">
                    <label class="font-bold text-purple-900">วันที่สิ้นสุด:</label>
                    <input type="date"
                           class="px-4 py-2 border-2 border-black 
                                  rounded-lg bg-white
                                  focus:ring-4 focus:ring-purple-300
                                  transition-all">
                </div>

            </div>
        </div>
    </div>


    <!-- ===== CARD SECTION ===== -->
    <div class="flex-1 bg-purple-100 p-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            <!-- Card -->
            <div class="bg-white border-2 border-black rounded-xl 
                        p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                        hover:scale-105 hover:-translate-y-2
                        transition-all duration-200">

                <div class="bg-purple-300 h-40 rounded-lg mb-6"></div>

                <h3 class="font-bold text-lg mb-2 text-purple-800">
                    ชื่อกิจกรรม
                </h3>

                <p class="text-sm text-gray-700">
                    รายละเอียดกิจกรรม...
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white border-2 border-black rounded-xl 
                        p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                        hover:scale-105 hover:-translate-y-2
                        transition-all duration-200">

                <div class="bg-purple-300 h-40 rounded-lg mb-6"></div>

                <h3 class="font-bold text-lg mb-2 text-purple-800">
                    ชื่อกิจกรรม
                </h3>

                <p class="text-sm text-gray-700">
                    รายละเอียดกิจกรรม...
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white border-2 border-black rounded-xl 
                        p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                        hover:scale-105 hover:-translate-y-2
                        transition-all duration-200">

                <div class="bg-purple-300 h-40 rounded-lg mb-6"></div>

                <h3 class="font-bold text-lg mb-2 text-purple-800">
                    ชื่อกิจกรรม
                </h3>

                <p class="text-sm text-gray-700">
                    รายละเอียดกิจกรรม...
                </p>
            </div>

        </div>

    </div>

</div>

</body>
</html>