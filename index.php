<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lieu Project Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-4xl w-full">
        <header class="text-center mb-12">
            <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                Project Portal
            </h1>
            <p class="text-gray-400 text-xl">Select an application to explore</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- WS03 Workopia -->
            <a href="/WS03/public/" class="group bg-gray-800 p-8 rounded-2xl border border-gray-700 hover:border-blue-500 transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-blue-500 mb-4 text-4xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Workopia</h2>
                <p class="text-gray-400 text-sm">Professional job listing platform built with a custom MVC framework.</p>
                <div class="mt-6 text-blue-400 font-semibold flex items-center">
                    Enter App <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </a>

            <!-- Blog Website -->
            <a href="/blog-website/blog.php" class="group bg-gray-800 p-8 rounded-2xl border border-gray-700 hover:border-orange-500 transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-orange-500 mb-4 text-4xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-blog"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Blog Site</h2>
                <p class="text-gray-400 text-sm">Game of Thrones themed blog featuring reviews and latest news.</p>
                <div class="mt-6 text-orange-400 font-semibold flex items-center">
                    Enter App <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </a>

            <!-- Jobseeker Online -->
            <a href="/jobseeker/index.php" class="group bg-gray-800 p-8 rounded-2xl border border-gray-700 hover:border-green-500 transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-green-500 mb-4 text-4xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-search-dollar"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Jobseeker</h2>
                <p class="text-gray-400 text-sm">Online job search and recruitment application with user registration.</p>
                <div class="mt-6 text-green-400 font-semibold flex items-center">
                    Enter App <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </a>
        </div>

        <footer class="mt-20 text-center text-gray-500">
            <p>&copy; 2026 Lieu Project Portfolio. All rights reserved.</p>
            <div class="mt-4 flex justify-center gap-6">
                <span class="px-3 py-1 bg-gray-800 rounded-full text-xs border border-gray-700">PHP 8.2</span>
                <span class="px-3 py-1 bg-gray-800 rounded-full text-xs border border-gray-700">JSON DB</span>
                <span class="px-3 py-1 bg-gray-800 rounded-full text-xs border border-gray-700">Dockerized</span>
            </div>
        </footer>
    </div>
</body>
</html>