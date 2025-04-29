<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    body {
        background-image: url('../../assets/images/pesawat.jpg'); /* Ensure the path is correct */
        background-size: cover; /* Cover the entire viewport */
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Prevent the image from repeating */
    }

    .card {
        background-color: rgba(241, 241, 241, 0.8); /* Set background color with transparency */
        backdrop-filter: blur(0px); /* Optional: add a blur effect to the background behind the card */
    }
</style>
<body class="bg-gray-100 font-sans">
    <div class="flex justify-center items-center min-h-screen">
        <div class="card p-8 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-2">TIKET!NG</h3>
            <h4 class="text-lg text-center text-gray-600 mb-6">Register your account</h4>

            <form action="process.php" method="POST">
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" name="username" id="username" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="nama_lengkap" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Register Button -->
                <button type="submit" name="register" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Register</button>
            </form>

            <!-- Login Link -->
            <div class="mt-4 text-center">
                <a href="../login/" class="text-blue-500 hover:text-blue-700">Sudah punya akun?</a>
            </div>
        </div>
    </div>
</body>
</html>
