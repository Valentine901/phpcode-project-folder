<?php

require_once 'config/database.php';
require_once 'includes/header.php';

$posts = [];
$categories = [];

$stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();


?>

<body class="flex-col gap-4 w-full max-w-screen">
    <div class="flex items-center text-center justify-center w-full mx-auto">
        <h2 class="text-gray-700 font-semebold text-2xl md:text-3xl lg:text-4xl text-center">Start blogging and viewing other authors blogs</h2>
    </div>


    <div class="flex justify-center items-center max-w-2xl w-full mt-5 mx-auto">
        <input type="text" class="flex mx-auto w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors" placeholder="Search posts by authors and categories">
    </div>


    <?php if (count($posts) > 0) :  ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 p-4">
            <?php foreach ($posts as $post) : ?>
                <div class="max-w-sm w-full h-full overflow-hidden bg-gray-700/10 p-1 pb-2  rounded-lg text-md flex flex-col">
                    <?php if (!empty($post['image'])): ?>
                        <div class="w-full h-lg overflow-hidden border-b border-slate-100 mb-2 rounded-lg ">
                            <img
                                src="<?php echo htmlspecialchars($post['image']); ?>"
                                alt=""
                                class="w-full h-48 object-cover hover:scale-105 duration-500 transition-all " />
                        </div>
                    <?php else: ?>

                        <div class="w-full h-64 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center border-b border-slate-100">
                            <span class="text-4xl">📝</span>
                        </div>
                    <?php endif; ?>
                    <p class="p-3 overflow-y-auto h-32 -webkit-font-smoothing: antialiased scrollbar-none"><?php echo $post["content"] ?></p>
                </div>
            <?php endforeach ?>
        </div>

    <?php else: ?>

        <div class="text-center items-center justify-center mx-auto bg-gray-700/20 text-md lg:text-lg max-w-2xl w-full text-center p-4 rounded-lg">
            <span>Post Empty</span>
        </div>
    <?php endif  ?>


</body>


<?php require_once "includes/footer.php"  ?>