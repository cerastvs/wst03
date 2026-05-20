<?php
class DataLoader
{
    private array $data;
    public function __construct(string $filePath)
    {
        $this->data = [];
        if (file_exists($filePath)) {
            $parsed = json_decode(file_get_contents($filePath), true);
            if (is_array($parsed)) {
                $this->data = $parsed;
            }
        }
    }
    public function getSection(string $key): array
    {
        return isset($this->data[$key]) ? $this->data[$key] : [];
    }
}

$loader = new DataLoader(__DIR__ . '/data.json');
$siteMeta = $loader->getSection('siteMetadata');
$hero = $loader->getSection('heroSection');
$comments = $loader->getSection('comments');
$content = $loader->getSection('contentSection');
$blogPosts = $loader->getSection('blogPosts');
$episodes = $loader->getSection('episodes');
$footer = $loader->getSection('footer');

function renderComments(array $commentsList): string
{
    if (empty($commentsList))
        return '<p class="mt-4">No reviews yet.</p>';
    $output = '<div class="comments max-h-[200px] overflow-y-scroll flex flex-col gap-4">';
    $index = 0;
    while ($index < count($commentsList)) {
        $comment = $commentsList[$index];
        $output .= '<div class="flex items-center gap-5">';
        $output .= '<img src="' . htmlspecialchars($comment['img'] ?? '') . '" alt="" class="h-20 rounded-full">';
        $output .= '<div>';
        $output .= '<h3 class="font-bold">' . htmlspecialchars($comment['name'] ?? '') . '</h3>';
        $output .= '<h3 class="w-[550px]">' . htmlspecialchars($comment['comment'] ?? '') . '</h3>';
        $output .= '</div></div>';
        $index++;
    }
    $output .= '</div>';
    return $output;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($siteMeta['title'] ?? 'GOT') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .comments::-webkit-scrollbar {
            width: 0px;
            height: 0px;
        }
    </style>
</head>

<body class="bg-[#101010] text-white">
    <header id="main-header"
        class="h-20 w-full fixed p-4 flex items-center justify-center z-50 bg-transparent text-white transition-colors duration-300">
        <div class="flex justify-between w-[55%] justify-center">
            <h1 class=" font-sans text-3xl"><span
                    class="text-[#FFA500]"><?= htmlspecialchars($siteMeta['logoText1'] ?? 'LIEU') ?></span><?= htmlspecialchars($siteMeta['logoText2'] ?? 'blog') ?>
            </h1>
            <div class="flex gap-4">
                <?php
                $nav = $siteMeta['navLinks'] ?? [];
                for ($i = 0; $i < count($nav); $i++) {
                    echo '<h3 class="text-xl">' . htmlspecialchars($nav[$i]) . '</h3>';
                }
                ?>
            </div>
        </div>
    </header>
    <div class="flex justify-center items-center relative h-screen">
        <div class="flex flex-col">
            <div class="bg-gradient-to-r from-[#FFA50000] via-[#FFA500] to-[#FFA50000]">
                <img src="./img/gotlogo.png" alt="" class=" z-10 relative">
            </div>
            <button
                class="w-48 border rounded-md text-xl self-end flex justify-center items-center p-2 gap-2 mt-3">WATCH ON
                <img src="./img/hbo.svg" alt="" class="justify-self-end h-[20px]"></button>
            <img src="./img/craiyon_180903_image.png" alt="" class="h-[100vh] absolute bottom-0 right-[35%]">

            <div
                class="flex justify-center items-center absolute h-[35vh] bottom-0 right-0 w-full bg-gradient-to-b from-black/0 to-black p-8 gap-16 text-white min-w-max">
                <div>
                    <div class="flex items-center gap-4">
                        <h3><span
                                class="font-bold text-2xl"><?= htmlspecialchars($hero['rating'] ?? '9.2') ?></span><span
                                class="text-gray-400">/<?= htmlspecialchars($hero['ratingMax'] ?? '10') ?></span> </h3>
                        <img src="https://starrating-beta.vercel.app/4.6/?size=38"
                            alt="<?= htmlspecialchars($hero['rating'] ?? '9.2') ?> star rating">
                    </div>
                    <h3 class="w-[550px]"><?= htmlspecialchars($hero['description'] ?? '') ?></h3>
                </div>
                <div class="">
                    <div class="flex items-center gap-4">
                        <h3><span class="font-bold text-2xl">Reviews</span></h3>
                    </div>
                    <?= renderComments($comments) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="overflow-hidden bg-black ">
        <h1 class="text-[9.25vw] font-semibold tracking-[-0.10em] leading-[0.7] text-[#ebebeb] mt-[20vh] mb-[10vh]">
            WINTER IS COMING . . .
        </h1>
    </div>

    <section id="white-section"
        class="flex justify-center items-center relative h-screen bg-[#ebebeb] text-black relative z-10">
        <div class="max-w-[70vh] flex flex-col gap-4">
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($content['title'] ?? '') ?></h1>
            <?php
            $paragraphs = $content['paragraphs'] ?? [];
            if (!empty($paragraphs)) {
                $pIndex = 0;
                do {
                    echo '<p>' . $paragraphs[$pIndex] . '</p>';
                    $pIndex++;
                } while ($pIndex < count($paragraphs));
            }
            ?>
            <img src="./img/jonsnow.png" alt="" class="absolute h-screen bottom-0 right-[68%]">
        </div>
    </section>

    <section class="bg-[#101010] py-24 px-8 min-h-screen flex justify-center z-20 relative">
        <div class="max-w-[900px] w-full flex flex-col gap-12 mt-12 bg-black/50 p-12 rounded-2xl border border-white/5">
            <h2 class="text-4xl font-bold text-[#ebebeb] border-b-2 border-[#FFA500]/30 pb-6 mb-6">Latest In Westeros
            </h2>

            <div class="flex flex-col gap-12">
                <?php
                if (!empty($blogPosts)) {
                    foreach ($blogPosts as $post) {
                        echo '<article class="bg-[#151515] p-8 rounded-xl border border-white/5 hover:border-[#FFA500]/50 transition-all duration-300 hover:shadow-[0_0_20px_rgba(255,165,0,0.05)]">';
                        echo '<h3 class="text-3xl font-bold mb-4 text-[#ebebeb]">' . htmlspecialchars($post['title']) . '</h3>';
                        echo '<div class="flex items-center gap-4 text-sm text-gray-400 mb-6">';
                        echo '<span class="text-[#FFA500] font-semibold text-base py-1 px-3 bg-[#FFA500]/10 rounded-full">By ' . htmlspecialchars($post['author']) . '</span>';
                        echo '<span>|</span>';
                        echo '<span>' . htmlspecialchars($post['date']) . '</span>';
                        echo '</div>';
                        echo '<p class="text-gray-300 leading-relaxed text-lg">' . htmlspecialchars($post['content']) . '</p>';
                        echo '<div class="mt-8 flex justify-end">';
                        echo '<button class="text-[#FFA500] font-semibold hover:text-white transition-colors border border-[#FFA500]/30 px-6 py-2 rounded-full hover:bg-[#FFA500]/10">Read full article →</button>';
                        echo '</div>';
                        echo '</article>';
                    }
                }
                ?>
            </div>
        </div>
    </section>


    <section class="bg-[#0a0a0a] py-24 px-8 flex justify-center z-20 relative border-t border-white/5">
        <div class="max-w-[1000px] w-full flex flex-col gap-12">
            <h2 class="text-4xl font-bold text-[#ebebeb] text-center border-b-2 border-[#FFA500]/30 pb-6 w-max mx-auto shadow-sm">Top Rated Episodes (IMDb)</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                if (!empty($episodes)) {
                    foreach ($episodes as $ep) {
                        echo '<div class="bg-[#151515] rounded-2xl border border-white/5 hover:border-[#FFA500]/50 transition-all duration-300 shadow-lg hover:shadow-[0_0_20px_rgba(255,165,0,0.1)] overflow-hidden flex flex-col group">';
                        if (!empty($ep['img'])) {
                            echo '<div class="w-full h-56 overflow-hidden">';
                            echo '<img src="' . htmlspecialchars($ep['img']) . '" alt="' . htmlspecialchars($ep['title']) . '" class="w-full h-full object-cover border-b border-white/5 opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">';
                            echo '</div>';
                        }
                        echo '<div class="p-8 flex flex-col flex-1">';
                        echo '<div class="flex justify-between items-start mb-6">';
                        echo '<div>';
                        echo '<h3 class="text-2xl font-bold text-white mb-1">' . htmlspecialchars($ep['title']) . '</h3>';
                        echo '<span class="text-sm text-gray-400">' . htmlspecialchars($ep['season']) . '</span>';
                        echo '</div>';
                        echo '<div class="flex items-center gap-2 bg-[#FFA500]/10 px-4 py-2 rounded-full border border-[#FFA500]/20">';
                        echo '<span class="text-[#FFA500] font-bold text-xl">' . htmlspecialchars($ep['rating']) . '</span>';
                        echo '<span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">IMDb</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '<p class="text-gray-300 leading-relaxed">' . htmlspecialchars($ep['preview']) . '</p>';
                        echo '<button class="mt-8 self-end text-[#FFA500] font-semibold hover:text-white transition-colors border-b border-transparent hover:border-white w-max">Read more</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>


    <section class="bg-black py-24 px-8 flex justify-center z-20 relative border-t border-white/5">
        <div class="max-w-7xl w-full flex flex-col gap-12">
            <h2 class="text-4xl font-bold text-[#ebebeb] text-center border-b-2 border-[#FFA500]/30 pb-6 w-max mx-auto shadow-sm">Explore Westeros on Screen</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="aspect-video w-full rounded-xl overflow-hidden border border-white/10 hover:border-[#FFA500]/50 transition-colors shadow-lg hover:shadow-[0_0_20px_rgba(255,165,0,0.15)] group relative bg-[#1a1a1a]">
                    <iframe class="w-full h-full relative z-10" src="https://www.youtube.com/embed/KPLWWIOCOOQ" title="Game of Thrones | Official Series Trailer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                

                <div class="aspect-video w-full rounded-xl overflow-hidden border border-white/10 hover:border-[#FFA500]/50 transition-colors shadow-lg hover:shadow-[0_0_20px_rgba(255,165,0,0.15)] group relative bg-[#1a1a1a]">
                    <iframe class="w-full h-full relative z-10" src="https://www.youtube.com/embed/s7L2PVdrb_8" title="Game of Thrones | Season 8 | Official Trailer" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                

                <div class="aspect-video w-full rounded-xl overflow-hidden border border-white/10 hover:border-[#FFA500]/50 transition-colors shadow-lg hover:shadow-[0_0_20px_rgba(255,165,0,0.15)] group relative bg-[#1a1a1a]">
                    <iframe class="w-full h-full relative z-10" src="https://www.youtube.com/embed/A0pLbTXPHng" title="Game of Thrones Journey" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            
        </div>
    </section>
    
    <footer class="bg-[#050505] py-12 text-center text-gray-500 border-t border-white/5 relative z-20">
        <p class="text-lg"><?= htmlspecialchars($footer['text'] ?? '© 2026 LIEUblog') ?></p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('main-header');
            const whiteSection = document.getElementById('white-section');

            window.addEventListener('scroll', () => {
                if (whiteSection && header) {
                    const whiteRect = whiteSection.getBoundingClientRect();
                    const headerRect = header.getBoundingClientRect();

                    if (headerRect.bottom > whiteRect.top && headerRect.top < whiteRect.bottom) {
                        header.classList.add('text-black');
                        header.classList.remove('text-white');
                    } else {
                        header.classList.add('text-white');
                        header.classList.remove('text-black');
                    }
                }
            });
            window.dispatchEvent(new Event('scroll'));
        });
    </script>
</body>

</html>