<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <?php if (!empty($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>

        <form method="POST" action="/auth" class="space-y-4">
            <input type="hidden" name="action" value="login">
            <div>
                <input name="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" required>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">Login</button>
        </form>

        <p class="text-center text-gray-600 mt-6">
            Don't have an account? <a href="/register" class="text-blue-600 hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>
