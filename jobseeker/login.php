<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="css/style.css?v=2" />
  <link rel="stylesheet" href="css/custom.css?v=2" />
  <title>Jobly - Login</title>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased h-screen flex flex-col">
  <header class="glass-nav sticky top-0 w-full z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
      <h1 class="text-2xl font-bold font-display tracking-tight text-brand-600">
        <a href="index.php" class="flex items-center gap-2">
          <i class="fa-solid fa-briefcase"></i> Jobly
        </a>
      </h1>
      <nav class="space-x-2 md:space-x-4 flex items-center">
        <a href="login.php" class="text-brand-600 font-semibold px-3 py-2 rounded-lg transition-colors">Login</a>
        <a href="register.php"
          class="text-slate-600 hover:text-brand-600 font-medium px-3 py-2 rounded-lg transition-colors">Register</a>
        <a href="post-job.php" class="btn-primary space-x-2 hidden sm:inline-flex">
          <i class="fa fa-edit"></i> <span>Post a Job</span>
        </a>
      </nav>
    </div>
  </header>

  <div class="flex-grow flex">
    <div class="flex-1 flex justify-center items-center p-4">
      <div
        class="bg-white p-8 md:p-12 rounded-3xl shadow-xl border border-slate-100 w-full max-md relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-100 rounded-full blur-2xl opacity-50 z-0"></div>

        <div class="relative z-10 text-center mb-8">
          <div
            class="w-16 h-16 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-6 shadow-sm border border-brand-100">
            <i class="fa-solid fa-right-to-bracket"></i>
          </div>
          <h2 class="text-3xl font-bold font-display text-slate-900 mb-2">Welcome back</h2>
          <p class="text-slate-500 font-medium tracking-wide">Enter your credentials to access your account.</p>
        </div>

        <form method="POST" class="relative z-10 space-y-5">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" class="input-field" required />
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input type="password" name="password" placeholder="••••••••" class="input-field" required />
          </div>

          <button type="submit"
            class="w-full btn-primary py-3.5 text-lg shadow-brand-500/20 shadow-lg mt-4 !rounded-xl">
            Sign In
          </button>

          <p class="mt-8 text-center text-slate-500 font-medium">
            Don't have an account?
            <a href="register.php"
              class="text-brand-600 font-semibold hover:text-brand-700 hover:underline transition-all">Sign up now</a>
          </p>
        </form>
      </div>
    </div>

    <div
      class="hidden lg:flex flex-1 bg-gradient-to-br from-brand-900 to-indigo-900 items-center justify-center p-12 relative overflow-hidden flex-col text-center">
      <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full border-[20px] border-white/5 opacity-50"></div>
      <div class="absolute bottom-10 left-10 w-64 h-64 rounded-full bg-brand-500/20 blur-3xl opacity-50"></div>

      <div class="relative z-10 max-w-lg">
        <i class="fa-solid fa-quote-left text-5xl text-brand-400 mb-6 opacity-50"></i>
        <h2 class="text-4xl text-white font-display font-bold leading-tight mb-6">
          "Jobly transformed my job search. Clean, fast, and I found multiple top-tier opportunities in days."
        </h2>
        <div class="flex items-center justify-center gap-4">
          <div
            class="w-12 h-12 bg-slate-300 rounded-full border-2 border-white flex items-center justify-center text-slate-500 font-bold overflow-hidden shadow-lg">
            <i class="fa-solid fa-user"></i>
          </div>
          <div class="text-left">
            <p class="text-white font-semibold">Sarah Jenkins</p>
            <p class="text-brand-200 text-sm">Product Manager</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
