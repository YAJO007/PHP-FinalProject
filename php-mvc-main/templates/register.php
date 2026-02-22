<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center p-4 font-sans
             bg-gradient-to-br from-purple-100 via-purple-300 to-purple-600">

    <div class="bg-white/90 backdrop-blur-md
                rounded-3xl
                shadow-[0_20px_60px_rgba(0,0,0,0.15)]
                w-full max-w-[550px]
                p-8 md:p-10 my-8
                transition-all duration-300">

        <div class="text-center mb-8">
            <h1 class="text-4xl font-black tracking-tight mb-2 text-purple-700">
                Sign Up
            </h1>
            <p class="text-gray-700 text-sm font-medium">
                สมัครสมาชิกเพื่อเข้าลงทะเบียนกิจกรรม
            </p>
        </div>

        <form action="/register" method="post" class="space-y-5">

            <div>
                <label for="username" class="block text-sm font-bold mb-2 text-gray-800">
                    ชื่อผู้ใช้ <span class="text-red-500">*</span>
                </label>
                <input type="text" name="username" id="username" placeholder="Username..." required
                    class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="first_name" class="block text-sm font-bold mb-2 text-gray-800">ชื่อ <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-bold mb-2 text-gray-800">นามสกุล <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold mb-2 text-gray-800">อีเมล <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email..." required
                    class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="password" class="block text-sm font-bold mb-2 text-gray-800">รหัสผ่าน <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Password..." required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-bold mb-2 text-gray-800">ยืนยันรหัสผ่าน <span class="text-red-500">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm..." required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
            </div>
            <p id='errorpass' class="hidden text-red-500 text-xs font-bold mt-[-10px]">รหัสผ่านไม่ตรงกัน</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-end">
                <div>
                    <label for="birthdate" class="block text-sm font-bold mb-2 text-gray-800">วันเกิด <span class="text-red-500">*</span></label>
                    <input type="date" name="birthdate" id="birthdate" required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 text-gray-600" />
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-800">เพศ <span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-3">
                        <label class="cursor-pointer group">
                            <input type="radio" name="gender" value="male" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center text-xl border-2 border-purple-300 rounded-xl bg-white peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-black peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-purple-50 transition-all">
                                ♂
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="gender" value="female" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center text-xl border-2 border-purple-300 rounded-xl bg-white peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-black peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-purple-50 transition-all">
                                ♀
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="gender" value="other" class="peer sr-only" />
                            <div class="w-12 h-12 flex items-center justify-center border-2 border-purple-300 rounded-xl bg-white peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-black peer-checked:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:bg-purple-50 transition-all">
                                <span class="text-sm font-bold">อื่นๆ</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="phone" class="block text-sm font-bold mb-2 text-gray-800">เบอร์โทรศัพท์ <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" placeholder="Phone Number" required
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
                <div>
                    <label for="congenital" class="block text-sm font-bold mb-2 text-gray-800">โรคประจำตัว (ถ้ามี)</label>
                    <input type="text" name="congenital" id="congenital" placeholder="None"
                        class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl outline-none font-medium transition-all duration-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-200 focus:scale-[1.01]" />
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" id="submit"
                    class="w-full bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700
                           text-white font-bold text-lg py-3 rounded-xl border-2 border-black
                           shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]
                           transition-all duration-200
                           hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                           active:translate-y-2 active:translate-x-2 active:shadow-none
                           disabled:bg-gray-400 disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed disabled:shadow-none disabled:translate-y-0">
                    สมัครสมาชิก
                </button>
            </div>

            <p class="mt-4 text-center text-xs font-bold text-gray-700">
                Already have an account? 
                <a href="/login" class="underline text-purple-700 hover:text-purple-900 transition">Log in</a>
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
            button.disabled = false;
            err.classList.add('hidden');
        }

        password.addEventListener('input', checkconfirm);
        confirm.addEventListener('input', checkconfirm);
        checkconfirm();
    </script>
</body>

</html>