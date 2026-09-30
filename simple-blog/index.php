<?php

require_once 'config/database.php';
require_once 'includes/header.php';

$posts = [];
$categories = [];
$fetchData = [];



$stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll();

// $stmt = $pdo -> query("SELECT * FROM comments WHERE post_id =:post_id");


$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $data = trim($_GET["search"]);
    $sql = "SELECT * FROM posts WHERE user =:data OR category =:data";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":data" => $data
    ]);
    $fetchData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<body class="flex-col gap-4 w-full max-w-screen relative">

    <div class="flex items-center text-center justify-center w-full mx-auto">
        <h2 class="text-gray-700 font-semibold text-2xl md:text-3xl lg:text-4xl text-center">Start blogging and viewing other authors blogs</h2>
    </div>

    <!-- searching input -->
    <form method="GET" class="flex justify-center items-center max-w-2xl w-full mt-15 mx-auto gap-2">
        <input type="text" name="search" class="flex text-xl placeholder:text-sm mx-auto w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors" placeholder="Search posts by authors and categories">
        <button class="py-3 px-6 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 transition-all duration-300 rounded-lg border-none text-white" type="submit" name="submit_search">Search</button>
    </form>




    <?php if (count($posts) > 0) :  ?>
        <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-24">

            <!-- Comment modal -->
            <!-- <div id="modal" class="hidden bg-gray-900/80 rounded-lg p-4 w-full max-w-lg absolute top-20 left-1/2 -translate-x-1/2 text-center z-999 max-h-64 h-full flex flex-col gap-2 text-white shadow-xl">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-bold">Comment here</h2>
                    <button type="button" id="closeModalBtn" class="text-white hover:text-gray-300">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>
                <form class="w-full flex gap-1 text-white ">
                    <input type="text" name="comment_name" placeholder="Type your comment" class="px-3 py-2 border border-gray-900 outline-none focus:ring-1 focus:ring-blue-900/50 focus:ring-offset-1 w-full rounded-md" />
                    <button type="submit" class="py-2 px-6 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 transition-all duration-300 text-white font-semibold text-md rounded-md">send</button>
                </form>
            </div> -->

            <?php foreach ($posts as $post) : ?>
                <div class="md:max-w-sm w-full h-full overflow-hidden bg-gray-700/10 p-1 pb-2 rounded-lg text-md flex flex-col items-center mx-auto">
                    <?php if (!empty($post['image'])): ?>
                        <a href="/phpcodes/simple-blog/posts/post.php/?id=<?php echo $post["id"]; ?>" class="w-full h-lg overflow-hidden border-b border-slate-100 mb-2 rounded-lg ">
                            <img
                                src="<?php echo htmlspecialchars($post['image']); ?>"
                                alt=""
                                class="w-full h-48 object-cover hover:scale-105 duration-500 transition-all " />
                        </a>
                    <?php else: ?>
                        <div class="w-full h-64 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center border-b border-slate-100">
                            <span class="text-4xl">📝</span>
                        </div>
                    <?php endif; ?>

                    <!-- quick actions -->
                    <div class="flex w-full px-2">
                        <p class="p-3 overflow-y-auto h-32 scrollbar-none flex-1"><?php echo htmlspecialchars($post["content"]) ?></p>
                        <div class="text-2xl z-50 text-gray-700 flex flex-col gap-4 pt-4">
                            <a href="" class="flex flex-col items-center hover:text-gray-800 transition-all duration-300">
                                <i class="fa-solid fa-user"></i>
                            </a>


                            <button
                                type="button"
                                data-id="<?php echo htmlspecialchars($post["id"]) ?>"
                                class="commentModalBtn flex flex-col items-center hover:text-gray-800 transition-all duration-300">
                                <i title="comments" class="fa-solid fa-comment hover:scale-101"></i>
                                <span class="text-sm font-semibold">27</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    <?php else: ?>
        <div class="text-center items-center justify-center mx-auto bg-gray-700/20 text-md lg:text-lg max-w-2xl w-full p-4 rounded-lg">
            <span>Post Empty</span>
        </div>
    <?php endif  ?>

</body>

<!-- 
<script>
    const modalEl = document.getElementById("modal");
    const openButtons = document.querySelectorAll(".commentModalBtn");
    const closeButton = document.getElementById("closeModalBtn");
    const displayId = document.getElementById("displayId");


    openButtons.forEach(button => {
        button.addEventListener("click", () => {

            const postId = button.getAttribute("data-id");
            displayId.textContent = "ID: " + postId;

            modalEl.classList.remove("hidden");
        });
    });


    closeButton.addEventListener("click", () => {
        modalEl.classList.add("hidden");
    });
</script> -->

<?php require_once "includes/footer.php"  ?>