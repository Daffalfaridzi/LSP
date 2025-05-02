<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TIKET!NG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../../assets/images/pesawat.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
        }
        .input-field {
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .login-btn {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transition: all 0.2s ease;
        }
        .login-btn:hover {
            background: linear-gradient(to right, #1d4ed8, #1e40af);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="login-container w-full max-w-md p-8">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="bg-blue-600 text-white w-16 h-16 rounded-2xl flex items-center justify-center shadow-md">
                <i class="fas fa-plane text-2xl"></i>
            </div>
        </div>
        
        <!-- Title -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">TIKET<span class="text-yellow-500">!NG</span></h1>
        <p class="text-center text-gray-600 mb-8">Login to your account</p>
        
        <!-- Login Form -->
        <form action="process.php" method="POST" class="space-y-6">
            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required
                        class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none">
                </div>
            </div>
            
            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                        class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none">
                </div>
            </div>
            <br>
            
            <!-- Login Button -->
            <button type="submit" name="login" class="login-btn w-full py-3 text-white font-semibold rounded-lg">
                Login
            </button>
        </form>
    </div>
</body>
</html>