<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM job_listings ORDER BY created_at DESC LIMIT 6");
$listings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"  />
    <link rel="stylesheet" href="css/style.css?v=2" />
    <link rel="stylesheet" href="css/custom.css?v=2" />
    <title>Jobly - Job Board</title>
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
          <a href="login.php" class="text-slate-600 hover:text-brand-600 font-medium px-3 py-2 rounded-lg transition-colors">Login</a>
          <a href="register.php" class="hidden sm:inline-block text-slate-600 hover:text-brand-600 font-medium px-3 py-2 rounded-lg transition-colors">Register</a>
          <a href="post-job.php" class="btn-primary space-x-2">
            <i class="fa fa-edit"></i> <span class="hidden sm:inline">Post a Job</span>
          </a>
        </nav>
      </div>
    </header>

    <section class="showcase relative h-[32rem] min-h-[500px] flex items-center mt-16 bg-cover bg-center overflow-hidden">
      <div class="overlay"></div>
      <div class="container mx-auto px-4 z-10 relative flex flex-col items-center">
        <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-semibold tracking-wide backdrop-blur-sm mb-6 animate-fade-in-up">
          Over 10,000+ active jobs
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl text-white font-bold mb-6 text-center leading-tight font-display drop-shadow-sm max-w-3xl">
          Find Your Next <span class="text-brand-500">Dream Job</span> With Jobly.
        </h1>
        <p class="text-lg md:text-xl text-slate-300 font-medium text-center mb-10 max-w-2xl">
          Discover opportunities that match your skills, passion, and ambition.
        </p>

        <div class="w-full max-w-4xl bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-2xl">
          <form class="flex flex-col md:flex-row gap-2">
            <div class="relative flex-grow flex items-center">
              <i class="fa fa-search text-slate-400 absolute left-4"></i>
              <input type="text" name="keywords" placeholder="Job title, keywords, or company" class="w-full bg-white pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brand-500 text-slate-700 font-medium shadow-sm" />
            </div>
            <div class="relative flex-grow flex items-center">
              <i class="fa fa-map-marker-alt text-slate-400 absolute left-4"></i>
              <input type="text" name="location" placeholder="Location or 'Remote'" class="w-full bg-white pl-11 pr-4 py-3.5 rounded-xl outline-none focus:ring-2 focus:ring-brand-500 text-slate-700 font-medium shadow-sm" />
            </div>
            <button class="btn-primary md:w-32 py-3.5 shadow-brand-500/30 shadow-lg !rounded-xl text-lg font-semibold shrink-0">
              Search
            </button>
          </form>
        </div>
      </div>
    </section>

    <section class="py-16 md:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-center text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-brand-600 uppercase mb-2">Explore Opportunities</h2>
          <h3 class="text-3xl md:text-4xl font-bold font-display text-slate-900">Recommended Jobs</h3>
          <div class="w-20 h-1 bg-brand-500 rounded mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
          <?php foreach($listings as $listing): ?>
          <div class="premium-card flex flex-col h-full group">
            <div class="p-6 flex flex-col grow">
              <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                  <i class="fa-solid fa-code"></i>
                </div>
                <span class="text-xs font-semibold bg-brand-100 text-brand-700 rounded-full px-3 py-1"><?= $listing['city'] == 'Remote' ? 'Remote' : 'Local' ?></span>
              </div>
              <h2 class="text-xl font-bold font-display text-slate-900 mb-2 group-hover:text-brand-600 transition-colors"><?= htmlspecialchars($listing['title']) ?></h2>
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
              <a href="details.php?id=<?= $listing['id'] ?>" class="w-full btn-outline">
                View Details
              </a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="text-center">
          <a href="listings.php" class="inline-flex items-center justify-center gap-2 text-brand-600 font-semibold hover:text-brand-700 transition-colors py-2 px-4 rounded-lg hover:bg-brand-50">
            Show All Jobs <i class="fa-solid fa-arrow-right mt-0.5"></i>
          </a>
        </div>
      </div>
    </section>

    <section class="py-16 md:py-24 bg-gradient-to-br from-slate-900 via-brand-900 to-indigo-900 relative overflow-hidden">
      <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full border border-white/10 opacity-20 hidden md:block"></div>
      <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full border border-white/10 opacity-20 hidden md:block"></div>
      
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center md:text-left flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="max-w-2xl">
          <h2 class="text-3xl md:text-4xl font-bold font-display text-white mb-4">Looking to hire top talent?</h2>
          <p class="text-brand-100 text-lg md:text-xl font-medium">
            Post your job listing now, connect with millions of skilled professionals, and find the perfect candidate to grow your business.
          </p>
        </div>
        <div class="shrink-0 flex gap-4">
          <a href="post-job.php" class="btn-accent px-8 py-4 text-lg shadow-accent-500/30 shadow-lg !rounded-xl space-x-2">
            <i class="fa fa-edit"></i> <span>Post a Job Today</span>
          </a>
        </div>
      </div>
    </section>
  </body>
</html>
