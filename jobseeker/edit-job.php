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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = [
        'id' => $id,
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'salary' => $_POST['salary'],
        'tags' => $_POST['tags'] ?? '',
        'company' => $_POST['company'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'requirements' => $_POST['requirements'],
        'benefits' => $_POST['benefits']
    ];

    $sql = "UPDATE job_listings SET 
            title = :title, 
            description = :description, 
            salary = :salary, 
            tags = :tags, 
            company = :company, 
            address = :address, 
            city = :city, 
            state = :state, 
            phone = :phone, 
            email = :email, 
            requirements = :requirements, 
            benefits = :benefits 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header('Location: details.php?id=' . $id);
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
  <title>Edit Job - Jobly</title>
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
          <i class="fa fa-edit"></i> <span class="hidden sm:inline">Post Job Listing</span>
        </a>
      </nav>
    </div>
  </header>

  <section class="bg-gradient-to-r from-brand-900 to-indigo-900 pt-32 pb-24 text-center">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-3">Edit Job Listing</h2>
      <p class="text-brand-100 text-lg font-medium max-w-xl mx-auto">
        Update the details of your job listing to ensure candidates have the most accurate information.
      </p>
    </div>
  </section>

  <section class="flex justify-center -mt-12 px-4 relative z-10">
    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-xl shadow-brand-900/5 border border-slate-100 w-full max-w-4xl">
      <form method="POST">
        <div class="mb-10">
          <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center">
              <i class="fa-solid fa-file-signature"></i>
            </div>
            <h2 class="text-2xl font-bold font-display text-slate-900">
              Job Information
            </h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Job Title <span
                  class="text-rose-500">*</span></label>
              <input type="text" name="title" value="<?= htmlspecialchars($listing['title']) ?>" placeholder="e.g. Senior Software Engineer" class="input-field"
                required />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Job Description <span
                  class="text-rose-500">*</span></label>
              <textarea name="description" placeholder="Describe the responsibilities and role..." rows="5"
                class="input-field resize-none" required><?= htmlspecialchars($listing['description']) ?></textarea>
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Annual Salary</label>
              <div class="relative">
                <i class="fa-solid fa-dollar-sign text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="salary" value="<?= htmlspecialchars($listing['salary']) ?>" placeholder="80,000" class="input-field pl-9" />
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Benefits</label>
              <input type="text" name="benefits" value="<?= htmlspecialchars($listing['benefits']) ?>" placeholder="e.g. Healthcare, 401(k), Remote" class="input-field" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Requirements</label>
              <input type="text" name="requirements" value="<?= htmlspecialchars($listing['requirements']) ?>"
                placeholder="e.g. 5+ YOE in Web Development, BA in Computer Science" class="input-field" />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Tags (comma separated)</label>
              <input type="text" name="tags" value="<?= htmlspecialchars($listing['tags']) ?>" placeholder="e.g. development, coding, java" class="input-field" />
            </div>
          </div>
        </div>

        <div class="mb-10">
          <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
              <i class="fa-solid fa-building"></i>
            </div>
            <h2 class="text-2xl font-bold font-display text-slate-900">
              Company & Location
            </h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Company Name <span
                  class="text-rose-500">*</span></label>
              <input type="text" name="company" value="<?= htmlspecialchars($listing['company']) ?>" placeholder="e.g. Jobly Technologies" class="input-field" required />
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-slate-700 mb-2">Office Address</label>
              <input type="text" name="address" value="<?= htmlspecialchars($listing['address']) ?>" placeholder="123 Innovation Drive" class="input-field" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">City</label>
              <input type="text" name="city" value="<?= htmlspecialchars($listing['city']) ?>" placeholder="San Francisco" class="input-field" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">State / Province</label>
              <input type="text" name="state" value="<?= htmlspecialchars($listing['state']) ?>" placeholder="CA" class="input-field" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Contact Phone</label>
              <input type="text" name="phone" value="<?= htmlspecialchars($listing['phone']) ?>" placeholder="+1 (555) 000-0000" class="input-field" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-slate-700 mb-2">Application Email <span
                  class="text-rose-500">*</span></label>
              <input type="email" name="email" value="<?= htmlspecialchars($listing['email']) ?>" placeholder="jobs@company.com" class="input-field" required />
            </div>
          </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-4 pt-6 border-t border-slate-100">
          <button type="submit"
            class="w-full md:w-auto bg-brand-600 hover:bg-brand-700 text-white font-semibold flex-grow py-3.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 flex justify-center items-center gap-2">
            <i class="fa fa-save"></i> Update Job Listing
          </button>
          <a href="details.php?id=<?= $listing['id'] ?>"
            class="w-full md:w-auto btn-outline border-slate-200 text-slate-600 hover:bg-slate-50 px-8 py-3.5 justify-center rounded-xl">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </section>
</body>

</html>
