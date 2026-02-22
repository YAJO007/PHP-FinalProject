<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e3f0fb] min-h-screen flex items-center justify-center p-4 font-sans text-black">

    <div class="bg-white rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.08)] w-full max-w-[500px] p-8 md:p-10 my-8">

        <div class="text-center mb-8">
            <h1 class="text-5xl font-black tracking-tight mb-2">Sign up</h1>
            <p class="text-gray-800 text-sm font-medium">สมัครสมาชิกเพื่อเข้าสู่ระบบ</p>
        </div>

        <form action="/register" method="post" class="space-y-5">

            <div>
                <label for="username" class="block text-sm font-bold mb-1">ชื่อผู้ใช้ <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="username" placeholder="Username..." required
                    class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="first_name" class="block text-sm font-bold mb-1">ชื่อ<span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-bold mb-1">นามสกุล<span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required
                        class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold mb-1">อีเมล<span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email..." required
                    class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
            </div>

            <div>
                <label for="password" class="block text-sm font-bold mb-1">รหัสผ่าน<span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password" placeholder="Password..." required
                    class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-bold mb-1">ยืนยันรหัสผ่าน<span class="text-red-500">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password..." required
                    class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
                <p id='errorpass' class="hidden text-red-500 text-xs mt-1 font-bold">รหัสผ่านไม่ตรงกัน</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-end">
                <div>
                    <label for="birthdate" class="block text-sm font-bold mb-1">วันเกิด<span class="text-red-500">*</span></label>
                    <input type="date" name="birthdate" id="birthdate"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 text-gray-600 font-medium transition" />
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">เพศ<span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="male" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center text-xl border-2 border-black rounded-lg peer-checked:bg-[#528af5] peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-gray-100 transition">
                                ♂
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="female" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center text-xl border-2 border-black rounded-lg peer-checked:bg-[#528af5] peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-gray-100 transition">
                                ♀
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="other" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center border-2 border-black rounded-lg peer-checked:bg-[#528af5] peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-gray-100 transition">
                                <span class="text-sm font-bold">อื่นๆ</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="phone" class="block text-sm font-bold mb-1">เบอร์โทรศัพท์<span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" placeholder="Phone Number"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
                </div>
                <div>
                    <label for="congenital" class="block text-sm font-bold mb-1">โรคประจำตัว (ถ้ามี)</label>
                    <input type="text" name="congenital" id="congenital" placeholder="None"
                        class="w-full px-4 py-3 border-2 border-black rounded-lg outline-none focus:ring-2 focus:ring-blue-400 placeholder-gray-400 font-medium transition" />
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" id="submit"
                    class="w-full bg-[#528af5] hover:bg-[#3b73eb] disabled:bg-gray-400 disabled:border-gray-500 disabled:shadow-none disabled:translate-y-0 disabled:translate-x-0 disabled:cursor-not-allowed text-black font-bold text-lg py-3 rounded-lg border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-[0px_0px_0px_0px_rgba(0,0,0,1)] active:translate-y-[4px] active:translate-x-[4px] transition-all">
                    สมัครสมาชิก
                </button>
            </div>

            <p class="mt-4 text-center text-xs font-bold text-gray-700">
                Already have an account? <a href="/login" class="underline hover:text-black">Log in</a>
            </p>

        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');
        const button = document.getElementById('submit');
        const err = document.getElementById('errorpass');

        function checkconfirm() {
            if (confirm.value === '') {
                button.disabled = true;
                err.classList.add('hidden');
                return;
            }
            if (password.value !== confirm.value) {
                button.disabled = true;
                err.classList.remove('hidden');
                return;
            }
            if (password.value === confirm.value) {
                button.disabled = false;
                err.classList.add('hidden');
                return;
            }
        }
        password.addEventListener('input', checkconfirm);
        confirm.addEventListener('input', checkconfirm);
        checkconfirm();
    </script>
</body>

</html>