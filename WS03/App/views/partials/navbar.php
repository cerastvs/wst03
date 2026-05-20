<?php

use Framework\Session;
?>
<!-- Nav -->
<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left: Avatar + Jobseek -->
        <div class="flex items-center gap-6">
            <?php if (Session::has('user')) : ?>
                <div class="flex flex-col items-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(Session::get('user')['name']) ?>&background=random&color=fff&rounded=true"
                        alt="Profile"
                        class="profile-img">
                    <span class="profile-name"><?= Session::get('user')['name'] ?></span>
                </div>
            <?php endif; ?>
            <h1 class="text-4xl font-bold tracking-wide">
                <a href="/">Jobseek</a>
            </h1>
        </div>

        <!-- Right: Logout/Login -->
        <nav>
            <?php if (Session::has('user')) : ?>
                <form method="POST" action="/auth/logout">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">Logout</button>
                </form>
            <?php else: ?>
                <a href="/auth/login" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>