<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    if ($password === $password_confirmation) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => $hashed_password
        ]);
        header('Location: login.php');
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
  <title>Jobly - Register</title>
</head>

<body
  class="bg-slate-50 text-slate-800 font-sans antialiased h-screen flex flex-col lg:flex-row-reverse overflow-x-hidden">
  <div
    class="hidden lg:flex flex-col flex-1 bg-gradient-to-br from-indigo-900 to-slate-900 items-center justify-center p-12 relative overflow-hidden text-center sticky top-0 h-screen">
    <div
      class="absolute top-10 left-10 w-96 h-96 rounded-full border-[2px] border-brand-500/20 opacity-50 border-dashed animate-[spin_60s_linear_infinite]">
    </div>
    <div class="absolute bottom-10 right-10 w-64 h-64 rounded-full bg-accent-500/20 blur-3xl opacity-50"></div>

    <div class="relative z-10 max-w-lg">
      <div class="mb-8 p-6 bg-white/10 backdrop-blur border border-white/10 rounded-2xl shadow-2xl animate-fade-in-up">
        <div class="flex items-center gap-4 text-left">
          <div class="w-16 h-16 bg-gradient-to-tr from-brand-500 to-indigo-500 p-1 rounded-xl">
            <div class="w-full h-full bg-slate-900 rounded-lg flex items-center justify-center text-white text-xl">
              <i class="fa fa-briefcase"></i>
            </div>
          </div>
          <div>
            <h3 class="text-white font-bold text-lg font-display">10,000+ Opportunities</h3>
            <p class="text-brand-200 text-sm">Join the community today.</p>
          </div>
        </div>
      </div>
      <h2 class="text-3xl lg:text-4xl text-white font-display font-bold leading-tight mb-4">
        Kickstart Your Career Journey
      </h2>
      <p class="text-slate-300 text-lg">
        Create a free account to discover personalized job recommendations, track your applications, and more.
      </p>
    </div>
  </div>

  <div class="flex-1 flex flex-col">
    <header
      class="w-full relative z-10 bg-white/80 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none border-b border-white/20 lg:border-none p-4 px-6 lg:p-8 flex justify-between">
      <a href="index.php"
        class="flex items-center gap-2 text-2xl font-bold font-display tracking-tight text-brand-600 hover:text-brand-700 transition">
        <i class="fa-solid fa-arrow-left text-lg"></i> Back Home
      </a>
    </header>

    <div class="flex-grow flex justify-center lg:items-center py-6 px-4">
      <div class="bg-white p-8 md:p-12 rounded-3xl shadow-xl border border-slate-100 w-full max-w-lg relative">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-2xl opacity-50 z-0"></div>

        <div class="relative z-10 mb-8">
          <h2 class="text-3xl font-bold font-display text-slate-900 mb-2">Create an account</h2>
          <p class="text-slate-500 font-medium tracking-wide">Let's get started. It's fast, simple, and free.</p>
        </div>

        <form method="POST" class="relative z-10 space-y-5">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
            <input type="text" name="name" placeholder="John Doe" class="input-field" required />
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" class="input-field" required />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">City</label>
              <input type="text" name="city" placeholder="San Francisco" class="input-field" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">State</label>
              <input type="text" name="state" placeholder="CA" class="input-field" />
            </div>
          </div>

          <div class="relative pt-2">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
              <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center">
              <span class="px-3 bg-white text-xs font-semibold text-slate-400 uppercase tracking-widest">Security</span>
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input type="password" name="password" placeholder="••••••••" class="input-field" required />
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="••••••••" class="input-field" required />
          </div>

          <button type="submit"
            class="w-full btn-primary py-3.5 text-lg shadow-brand-500/20 shadow-lg mt-6 !rounded-xl">
            Create Account
          </button>

          <p class="mt-8 text-center text-slate-500 font-medium text-sm">
            Already have an account?
            <a href="login.php"
              class="text-brand-600 font-semibold hover:text-brand-700 hover:underline transition-all">Sign in here</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
