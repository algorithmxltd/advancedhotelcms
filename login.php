<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in or sign up</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/login.css">
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body class="">
    <?php include 'includes/navbar.php' ?>
    <div class="bg-white text-gray-900 flex items-center justify-center min-h-screen">
    
    <!-- Main container for the content -->
    <div class="w-full max-w-md mx-auto p-6">
        <div class="text-center">
            
            <!-- Main Heading -->
            <h1 class="text-4xl font-bold mb-3">Log in or sign up</h1>
            <p class="text-gray-600 mb-8">Login to track and manage your bookings</p>

            <!-- Social Logins container -->
            <div class="space-y-4">
                <!-- Continue with Google -->
                <button class="w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-full hover:bg-gray-50 btn-transition">
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/><path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/><path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/><path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.237-2.231 4.166-4.087 5.574l6.19 5.238C42.011 35.391 44 30.015 44 24c0-1.341-.138-2.65-.389-3.917z"/></svg>
                    <span class="font-medium">Continue with Google</span>
                </button>
            </div>

            <!-- OR divider -->
            <div class="flex items-center my-8">
                <hr class="w-full border-gray-300">
                <span class="px-4 text-gray-500 font-medium">OR</span>
                <hr class="w-full border-gray-300">
            </div>

            <!-- Email Form -->
            <form action="#">
                <div class="relative mb-6">
                    <input id="email" type="email" placeholder=" " class="form-input block w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent peer transition-colors" />
                    <label for="email" class="form-label absolute text-gray-500 duration-300 transform -translate-y-4 scale-75 top-3 z-10 origin-[0] bg-white px-2 left-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-3 peer-focus:scale-75 peer-focus:-translate-y-4">Email address</label>
                </div>

                <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-full text-lg btn-transition">
                    Continue
                </button>
            </form>

        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

