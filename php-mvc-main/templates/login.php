<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-sans
             bg-gradient-to-br from-purple-100 via-purple-300 to-purple-600">

    <div class="bg-white/90 backdrop-blur-md
                rounded-3xl
                shadow-[0_20px_60px_rgba(0,0,0,0.15)]
                w-full max-w-[420px]
                p-8 md:p-10
                transition-all duration-300">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-black tracking-tight mb-2 text-purple-700">
                Login
            </h1>
            <p class="text-gray-700 text-sm font-medium">
                เพื่อเข้าลงทะเบียนกิจกรรม
            </p>
        </div>

        <!-- Form -->
        <form action="login" method="post" class="space-y-6">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold mb-2">
                    อีเมล
                </label>
                <input type="email" name="email" id="email" required
                       placeholder="Email..."
                       class="w-full px-4 py-3
                              border-2 border-purple-300
                              rounded-xl
                              outline-none
                              font-medium
                              transition-all duration-200
                              focus:border-purple-600
                              focus:ring-4 focus:ring-purple-200
                              focus:scale-[1.02]" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="block text-sm font-bold">
                        รหัสผ่าน
                    </label>
                    <a href="#"
                       class="text-xs font-semibold text-purple-600
                              hover:text-purple-800 transition">
                        Forgot?
                    </a>
                </div>

                <input type="password" name="password" id="password" required
                       placeholder="Password..."
                       class="w-full px-4 py-3
                              border-2 border-purple-300
                              rounded-xl
                              outline-none
                              font-medium
                              transition-all duration-200
                              focus:border-purple-600
                              focus:ring-4 focus:ring-purple-200
                              focus:scale-[1.02]" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full
                               bg-gradient-to-r
                               from-purple-500
                               via-purple-600
                               to-purple-700
                               text-white
                               font-bold text-lg
                               py-3
                               rounded-xl
                               border-2 border-black
                               shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]
                               transition-all duration-200
                               hover:-translate-y-1
                               hover:scale-105
                               hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                               active:translate-y-2
                               active:translate-x-2
                               active:shadow-none">
                    เข้าสู่ระบบ
                </button>
            </div>

        </form>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs font-semibold text-gray-700">
            ยังไม่มีบัญชี?
            <a href="register"
               class="underline text-purple-700 hover:text-purple-900 transition">
               สมัครสมาชิก
            </a>
        </p>

    </div>

</body>
</html>