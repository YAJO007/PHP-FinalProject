<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSite Name</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#e3f0fb] min-h-screen p-4 sm:p-8 font-sans text-black flex flex-col">

    <div class="bg-white border-2 border-black rounded-[24px] shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex-1 flex flex-col overflow-hidden max-w-7xl mx-auto w-full">

        <header class="border-b-2 border-black p-6 bg-[#528af5]">
            <h1 class="text-3xl font-black tracking-widest uppercase text-center text-black">
                WebSite Name
            </h1>
        </header>

        <nav class="border-b-2 border-black flex flex-wrap justify-center gap-4 sm:gap-12 py-4 px-4 text-sm font-bold uppercase tracking-widest bg-white">
            <a href="/" class="px-4 py-2 border-2 border-transparent hover:border-black rounded-lg hover:bg-[#e3f0fb] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">Home</a>
            <a href="/login" class="px-4 py-2 border-2 border-transparent hover:border-black rounded-lg hover:bg-[#e3f0fb] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">Login</a>
            <a href="/register" class="px-4 py-2 border-2 border-transparent hover:border-black rounded-lg hover:bg-[#e3f0fb] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all">Register</a>
        </nav>

        <div class="flex flex-col md:flex-row flex-1">

            <div class="w-full md:w-64 border-b-2 md:border-b-0 md:border-r-2 border-black p-6 sm:p-8 bg-[#f9fafb]">
                <div role="tablist" class="flex flex-col gap-4 text-xs uppercase tracking-widest">

                    <button role="tab" aria-selected="true"
                            class="w-full text-left px-4 py-3 border-2 border-black rounded-lg font-bold bg-[#528af5] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                        General
                    </button>

                    <button role="tab"
                            class="w-full text-left px-4 py-3 border-2 border-transparent hover:border-black rounded-lg font-bold hover:bg-white hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                        Privacy
                    </button>

                    <button role="tab"
                            class="w-full text-left px-4 py-3 border-2 border-transparent hover:border-black rounded-lg font-bold hover:bg-white hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all">
                        Security
                    </button>

                </div>
            </div>

            <div role="tabpanel" class="flex-1 p-8 sm:p-12 md:p-16 bg-white">
                
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-black leading-tight uppercase mb-8 drop-shadow-sm">
                    A Deep Taste<br>
                    Enchanted In<br>
                    The Recipe.
                </h2>

                <p class="text-base text-gray-800 max-w-xl font-medium leading-relaxed border-l-4 border-[#528af5] pl-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    This layout follows an editorial campaign aesthetic with 
                    strong typography and generous spacing.
                </p>

            </div>

        </div>

        <main class="border-t-2 border-black bg-[#e3f0fb] p-6 text-center font-bold uppercase text-sm tracking-widest">
            Home
        </main>

        <footer class="border-t-2 border-black bg-white p-5 text-center text-sm font-bold">
            &copy; <?= date('Y') ?>. All rights reserved by Aj.M.
        </footer>

    </div>

</body>
</html>