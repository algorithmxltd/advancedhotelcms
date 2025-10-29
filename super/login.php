<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in or sign up</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../styles/styles.css"> 
    <link rel="stylesheet" href="styles/login.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Additional styles for proper floating labels */
        .form-input:focus ~ .form-label,
        .form-input:not(:placeholder-shown) ~ .form-label {
            top: -10px;
            transform: scale(0.75);
            color: #2563eb; /* blue-600 */
        }
        
        /* Password toggle styles */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s ease;
        }
        
        .password-toggle:hover {
            color: #374151;
        }
        
        .password-container {
            position: relative;
        }
    </style>

</head>
<body class="">
      <div class="app-container">

    

    <div class="main-content">
    <div class="bg-white text-gray-900 flex items-center justify-center min-h-screen">
    
    <!-- Main container for the content -->
    <div class="w-full max-w-md mx-auto p-6">
        <div class="text-center">
            
            <!-- Main Heading -->
            <h1 class="text-4xl font-bold mb-2">Mt. Everest Hotel</h1>
            <h2 class="text-2xl font-semibold mb-3">Log in</h2>
            <p class="text-gray-600 mb-8">Login to manage hotel operations</p>

            
            <!-- Login Form -->
            <form action="#">
                <div class="relative mb-4">
                    <input id="nationalId" type="number" placeholder=" " class="form-input block w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent peer transition-colors" />
                    <label for="nationalId" class="form-label absolute left-4 top-3 text-gray-500 duration-300 transform -translate-y-0 scale-100 bg-white px-2 pointer-events-none transition-all">
                        National ID
                    </label>
                </div>

                <div class="relative mb-6 password-container">
                    <input id="password" type="password" placeholder=" " class="form-input block w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent peer transition-colors pr-12" />
                    <label for="password" class="form-label absolute left-4 top-3 text-gray-500 duration-300 transform -translate-y-0 scale-100 bg-white px-2 pointer-events-none transition-all">
                        Password
                    </label>
                    <button type="button" class="password-toggle" id="passwordToggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Forgot Password Link -->
                <div class="text-right mb-6">
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-full text-lg btn-transition">
                    Continue
                </button>
            </form>

        </div>
    </div>
</div>
</div>
</div>

<script>
// Password toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');
    const passwordIcon = passwordToggle.querySelector('i');
    
    passwordToggle.addEventListener('click', function() {
        // Toggle password visibility
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        
        // Toggle eye icon
        if (isPassword) {
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    });
});
</script>

<script src='js/login.js'></script>
</body>
</html>