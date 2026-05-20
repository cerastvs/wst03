<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css?v=2" />
  <link rel="stylesheet" href="css/custom.css?v=2" />
  <title>404 - Page Not Found | Jobly</title>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased h-screen flex flex-col">

  <header class="glass-nav fixed top-0 w-full z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <h1 class="text-2xl font-bold font-display tracking-tight text-brand-600">
        <a href="index.php" class="flex items-center gap-2">
          <i class="fa-solid fa-briefcase"></i> Jobly
        </a>
      </h1>
      <nav class="space-x-2 md:space-x-4 flex items-center">
        <a href="login.php"
          class="text-slate-600 hover:text-brand-600 font-medium px-3 py-2 rounded-lg transition-colors">Login</a>
        <a href="register.php"
          class="hidden sm:inline-block text-slate-600 hover:text-brand-600 font-medium px-3 py-2 rounded-lg transition-colors">Register</a>
        <a href="post-job.php" class="btn-primary space-x-2">
          <i class="fa fa-edit"></i> <span class="hidden sm:inline">Post a Job</span>
        </a>
      </nav>
    </div>
  </header>


  <main class="flex-grow flex items-center justify-center p-4">
    <div class="text-center max-w-lg mx-auto">

      <div class="relative w-64 h-64 mx-auto mb-8">
        <div class="absolute inset-0 bg-brand-100 rounded-full blur-3xl opacity-50"></div>
        <div class="relative z-10 w-full h-full flex items-center justify-center text-brand-500 text-9xl">
          <i class="fa-solid text-[10rem] fa-ghost drop-shadow-xl z-20"></i>
        </div>
      </div>

      <h1 class="text-7xl font-black font-display text-slate-900 mb-4 tracking-tighter">404</h1>
      <h2 class="text-2xl font-semibold text-slate-700 mb-6 font-display">Oops! Page not found.</h2>
      <p class="text-slate-500 text-lg mb-10 leading-relaxed font-medium">
        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="index.php"
          class="btn-primary py-3.5 px-8 text-lg !rounded-xl shadow-brand-500/20 shadow-lg space-x-2 w-full sm:w-auto">
          <i class="fa-solid fa-home"></i> <span>Back to Home</span>
        </a>
        <a href="listings.php"
          class="btn-outline py-3.5 px-8 text-lg text-slate-600 !rounded-xl border-slate-200 w-full sm:w-auto">
          Find Jobs
        </a>
      </div>
    </div>
  </main>
</body>

</html>