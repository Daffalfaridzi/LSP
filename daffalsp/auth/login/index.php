<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('../../assets/images/pesawat.jpg'); /* Pastikan path gambar benar */
            background-size: cover; /* Menutupi seluruh layar */
            background-position: center; /* Posisi gambar di tengah */
            background-repeat: no-repeat; /* Menghindari pengulangan gambar */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Centered login form container -->
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white bg-opacity-80 p-8 rounded-xl shadow-lg w-full max-w-sm">
            <!-- Logo or Title -->
            <h3 class="text-3xl font-bold text-center text-gray-800 mb-2">TIKET!NG</h3>
            <h4 class="text-lg text-center text-gray-600 mb-6">Login to your account</h4>

            <!-- Login Form -->
            <form action="process.php" method="POST">
                <!-- Username -->
                <div class="mb-5">
                    <label for="username" class="text-gray-700 font-semibold">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username"
                        class="w-full p-3 border mt-1 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out" required>
                </div>

                <!-- Password -->
                <div class="mb-8">
                    <label for="password" class="text-gray-700 font-semibold">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password"
                        class="w-full p-3 border mt-1 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out" required>
                </div>

                <!-- Login Button -->
                <button type="submit" name="login"
                    class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 ease-in-out">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
