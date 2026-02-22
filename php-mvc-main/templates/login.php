<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e3f0fb] min-h-screen flex items-center justify-center p-4 font-sans text-black">

    <div class="bg-white rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.08)] w-full max-w-[400px] p-8 md:p-10">
        
        <div class="text-center mb-8">
            <h1 class="text-5xl font-black tracking-tight mb-2">login</h1>
            <p class="text-gray-800 text-sm font-medium">เพื่อเข้าลงทะเบียนกิจกรรม</p>
        </div>

        <form action="login" method="post" class="space-y-5">
            
            <div>
                <label for="email" class="block text-sm font-bold mb-1">อีเมล</label>
                <input type="email" name="email" id="email" placeholder="Email..." required 
                       class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
            </div>

            <div>
                <div class="flex justify-between items-end mb-1">
                    <label for="password" class="block text-sm font-bold">รหัสผ่าน</label>
                    <a href="#" class="text-xs font-bold text-gray-600 underline hover:text-black">Forgot your password?</a>
                </div>
                <input type="password" name="password" id="password" placeholder="Password..." required 
                       class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-[#528af5] hover:bg-[#3b73eb] text-black font-bold text-lg py-3 rounded-lg border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-[0px_0px_0px_0px_rgba(0,0,0,1)] active:translate-y-[4px] active:translate-x-[4px] transition-all">
                    เข้าสู่ระบบ
                </button>
            </div>
        </form>

        <p class="mt-8 text-center text-xs font-bold text-gray-700">
            Don't have an account? <a href="/register" class="underline hover:text-black">Sign up</a>
        </p>
        
    </div>

</body>
</html>