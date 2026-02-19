<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WebSite Name</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[oklch(87.1%_0.15_154.449)] from-purple-50 to-pink-50 p-6">

<div class="bg-white border border-black min-h-screen flex flex-col">

<header class="border-b border-black p-6">
    <h1 class="text-xl font-semibold tracking-widest uppercase text-center">
        WebSite Name
    </h1>
</header>

<nav class="border-b border-black flex justify-center gap-12 py-4 text-sm uppercase tracking-widest">
    <a href="/" class="hover:underline">Home</a>
    <a href="/login" class="hover:underline">Login</a>
    <a href="/register" class="hover:underline">Register</a>
</nav>

<div class="flex flex-1">

  <!-- Sidebar -->
  <div class="w-56 border-r border-black p-8">
    <div role="tablist" class="flex flex-col gap-6 text-xs uppercase tracking-widest">

      <button role="tab" aria-selected="true"
        class="text-left border-b border-black pb-2 font-semibold">
        General
      </button>

      <button role="tab"
        class="text-left hover:underline">
        Privacy
      </button>

      <button role="tab"
        class="text-left hover:underline">
        Security
      </button>

    </div>
  </div>

  <!-- Content -->
  <div role="tabpanel" class="flex-1 p-16">

    <h2 class="text-5xl font-extrabold leading-tight uppercase mb-10">
      A Deep Taste<br>
      Enchanted In<br>
      The Recipe.
    </h2>

    <p class="text-sm text-gray-600 max-w-xl leading-relaxed">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. 
      This layout follows an editorial campaign aesthetic with 
      strong typography and generous spacing.
    </p>

  </div>

</div>

<main class="border-t border-black p-6 text-center uppercase text-sm tracking-widest">
    Home
</main>

<footer class="border-t border-black p-4 text-center text-xs">
    &copy; <?= date('Y') ?>. All rights reserved by Aj.M.
</footer>

</div>

</body>
</html>
