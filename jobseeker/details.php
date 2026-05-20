<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: listings.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM job_listings WHERE id = :id");
$stmt->execute(['id' => $id]);
$listing = $stmt->fetch();

if (!$listing) {
    header('Location: listings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
    $stmt = $pdo->prepare("DELETE FROM job_listings WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header('Location: listings.php');
    exit;
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
  <title>Job Details - Jobly</title>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased pb-24">
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

  <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-24 mt-4">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <a href="listings.php"
        class="inline-flex items-center text-slate-500 hover:text-brand-600 font-medium transition-colors">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back to listings
      </a>
      <div class="flex space-x-3">
        <a href="edit-job.php?id=<?= $listing['id'] ?>" class="btn-outline !py-2 !px-4 text-sm font-semibold">
          <i class="fa fa-pen mr-1.5"></i> Edit
        </a>
        <form method="POST">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit"
            class="inline-flex items-center justify-center font-semibold rounded-lg text-rose-600 bg-rose-50 border border-rose-200 hover:bg-rose-100 hover:text-rose-700 transition-all duration-200 px-4 py-2 text-sm shadow-sm">
            <i class="fa fa-trash-alt mr-1.5"></i> Delete
          </button>
        </form>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

      <div class="w-full lg:w-2/3 space-y-6">
        <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-sm border border-slate-100 relative overflow-hidden">
          <div
            class="absolute top-0 right-0 bg-brand-50 text-brand-600 font-semibold px-6 py-2 rounded-bl-3xl text-sm border-b border-l border-brand-100">
            Featured Role
          </div>

          <div class="flex items-center gap-6 mb-8 mt-2">
            <div
              class="w-20 h-20 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-4xl shadow-inner border border-brand-100 shrink-0">
              <i class="fa-solid fa-code"></i>
            </div>
            <div>
              <h1 class="text-3xl lg:text-4xl font-bold font-display text-slate-900 mb-2"><?= htmlspecialchars($listing['title']) ?></h1>
              <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center text-slate-500 text-sm font-medium">
                  <i class="fa-regular fa-building mr-1.5"></i> <?= htmlspecialchars($listing['company']) ?>
                </span>
                <span class="inline-flex items-center text-slate-500 text-sm font-medium">
                  <i class="fa-solid fa-location-dot mr-1.5 text-brand-400"></i> <?= htmlspecialchars($listing['city']) ?>, <?= htmlspecialchars($listing['state']) ?> <span
                    class="ml-2 font-bold text-xs bg-brand-100 text-brand-700 px-2 py-0.5 rounded-full"><?= $listing['city'] == 'Remote' ? 'Remote' : 'Local' ?></span>
                </span>
              </div>
            </div>
          </div>

          <div class="mb-8">
            <h2 class="text-xl font-bold font-display text-slate-800 mb-4 flex items-center gap-2">
              <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                <i class="fa-solid fa-align-left"></i>
              </div>
              About The Role
            </h2>
            <p class="text-slate-600 text-lg leading-relaxed">
              <?= htmlspecialchars($listing['description']) ?>
            </p>
          </div>

          <div class="mb-8">
            <h3 class="text-xl font-bold font-display text-slate-800 mb-4 flex items-center gap-2">
              <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                <i class="fa-solid fa-list-check"></i>
              </div>
              Job Requirements
            </h3>
            <p class="text-slate-600 text-base leading-relaxed">
              <?= htmlspecialchars($listing['requirements']) ?>
            </p>
          </div>

          <div class="mb-2">
            <h3 class="text-xl font-bold font-display text-slate-800 mb-4 flex items-center gap-2">
              <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                <i class="fa-solid fa-gift"></i>
              </div>
              Benefits
            </h3>
            <p class="text-slate-600 text-base leading-relaxed">
              <?= htmlspecialchars($listing['benefits']) ?>
            </p>
          </div>
        </div>
      </div>

      <div class="w-full lg:w-1/3">
        <div class="sticky top-24 bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">
          <h3 class="text-lg font-bold font-display text-slate-900 mb-6">Job Overview</h3>

          <div class="space-y-5 mb-8">
            <div class="flex items-start gap-4">
              <div
                class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-sack-dollar"></i>
              </div>
              <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Salary</p>
                <p class="font-medium text-slate-800">₱<?= $listing['salary'] ?> / year</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Location</p>
                <p class="font-medium text-slate-800"><?= htmlspecialchars($listing['city']) ?>, <?= htmlspecialchars($listing['state']) ?> (<?= $listing['city'] == 'Remote' ? 'Remote' : 'Local' ?>)</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div
                class="w-10 h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-tags"></i>
              </div>
              <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Categories</p>
                <div class="flex flex-wrap gap-2 mt-1">
                  <?php 
                  $tags = explode(',', $listing['tags']);
                  foreach($tags as $tag): 
                  ?>
                  <span
                    class="text-xs bg-slate-100 text-slate-600 rounded-md px-2 py-1 font-medium border border-slate-200"><?= trim(htmlspecialchars($tag)) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="border-t border-slate-100 pt-6">
            <div class="bg-indigo-50 rounded-xl p-4 mb-4 border border-indigo-100">
              <p class="text-sm text-indigo-800 font-medium leading-relaxed">
                Put <strong class="font-bold">"Job Application"</strong> as the subject of your email and attach your
                resume.
              </p>
            </div>
            <a href="mailto:<?= htmlspecialchars($listing['email']) ?>"
              class="btn-primary w-full py-3.5 text-lg shadow-brand-500/20 shadow-lg !rounded-xl space-x-2 flex items-center justify-center group">
              <span>Apply Now</span>
              <i
                class="fa-solid fa-paper-plane group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </main>

</body>

</html>
