<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM job_listings ORDER BY created_at DESC");
$listings = $stmt->fetchAll();
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
  <title>Jobly - All Jobs</title>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">
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

  <section
    class="bg-gradient-to-br from-brand-900 via-indigo-900 to-slate-900 pt-32 pb-20 text-center relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full border border-white/5 opacity-50 bg-white/5"></div>
    <div class="absolute -bottom-20 -left-20 w-96 h-96 rounded-full border border-white/5 opacity-50"></div>

    <div class="container mx-auto px-4 relative z-10">
      <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-4 drop-shadow-sm">Explore All Jobs</h2>
      <p class="text-brand-100 text-lg md:text-xl font-medium max-w-2xl mx-auto">
        Discover the perfect job opportunity tailored to your unique skills and ambitions.
      </p>
    </div>
  </section>

  <section class="py-16 md:py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex justify-between items-end mb-10 border-b border-slate-200 pb-4">
        <div>
          <h3 class="text-2xl font-bold font-display text-slate-900">Latest Opportunities</h3>
          <p class="text-slate-500 font-medium mt-1">Showing all available listings</p>
        </div>
        <div class="text-slate-400">
          <i class="fa fa-filter mr-2"></i>Filter
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <?php foreach($listings as $listing): ?>
        <div class="premium-card flex flex-col h-full group">
          <div class="p-6 flex flex-col grow">
            <div class="flex justify-between items-start mb-4">
              <div
                class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-code"></i>
              </div>
              <span class="text-xs font-semibold bg-brand-100 text-brand-700 rounded-full px-3 py-1"><?= $listing['city'] == 'Remote' ? 'Remote' : 'Local' ?></span>
            </div>
            <h2 class="text-xl font-bold font-display text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">
              <?= htmlspecialchars($listing['title']) ?></h2>
            <p class="text-slate-500 text-sm mb-6 flex-grow leading-relaxed">
              <?= htmlspecialchars($listing['description']) ?>
            </p>

            <div class="space-y-3 mb-6 bg-slate-50 rounded-xl p-4 border border-slate-100">
              <div class="flex items-center text-sm font-medium text-slate-700">
                <i class="fa-solid fa-sack-dollar text-slate-400 w-5"></i>
                <span>₱<?= $listing['salary'] ?> / year</span>
              </div>
              <div class="flex items-center text-sm font-medium text-slate-700">
                <i class="fa-solid fa-location-dot text-slate-400 w-5"></i>
                <span><?= htmlspecialchars($listing['city']) ?>, <?= htmlspecialchars($listing['state']) ?></span>
              </div>
              <div class="flex flex-wrap gap-2 pt-2">
                <?php 
                $tags = explode(',', $listing['tags']);
                foreach($tags as $tag): 
                ?>
                <span class="text-xs bg-white border border-slate-200 text-slate-600 rounded px-2 py-1 font-medium shadow-sm"><?= trim(htmlspecialchars($tag)) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <a href="details.php?id=<?= $listing['id'] ?>" class="w-full btn-outline">View Details</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="py-12 bg-slate-900 border-t border-slate-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div
        class="bg-indigo-900/40 border border-indigo-500/20 rounded-2xl p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 backdrop-blur">
        <div>
          <h2 class="text-2xl font-bold font-display text-white mb-2">Ready to hire top talent?</h2>
          <p class="text-indigo-200 text-lg">
            Post your job listing now and connect with perfect candidates.
          </p>
        </div>
        <a href="post-job.php"
          class="btn-accent px-8 py-3.5 whitespace-nowrap shadow-accent-500/30 shadow-lg space-x-2">
          <i class="fa fa-edit"></i> <span>Post a Job</span>
        </a>
      </div>
    </div>
  </section>
</body>

</html>
