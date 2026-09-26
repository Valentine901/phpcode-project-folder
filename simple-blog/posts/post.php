<?php 
require_once "../config/database.php";
require_once "../includes/header.php";

$post = null;
$author = null; 
$author_id = null;
$category = null; 
$category_id = null;

if(isset($_GET["id"])) {
    $post_id = $_GET["id"];

    $post_sql = "SELECT id, image, content, user_id, category_id, created_at FROM posts WHERE id =:id";
    $stmt = $pdo -> prepare($post_sql);
    $stmt -> execute([
        "id" => $post_id
    ]);
    $post = $stmt -> fetch();

    $author_id = $post["user_id"];
    $category_id = $post["category_id"];

    $user_sql = "SELECT id, username, email FROM users WHERE id =:author_id";
    $category_sql = "SELECT id, name FROM categories WHERE id =:category_id";

    // fetch author of post
    $userStmt = $pdo -> prepare($user_sql);
    $userStmt -> execute(["author_id" => $author_id]);
    $author = $userStmt -> fetch();
    
    // fetch category of post
    $categoryStmt = $pdo -> prepare($category_sql);
    $categoryStmt -> execute(["category_id" => $category_id]);
    $category = $categoryStmt -> fetch();
}
?>

<body class="w-full min-h-screen bg-gray-50 flex justify-center items-start p-4 md:p-8">
    <div class="max-w-6xl w-full flex flex-col md:flex-row gap-6 md:gap-8 items-start">
        
        <div class="flex-1 flex flex-col gap-6 w-full">
            <?php if ($post && isset($post["image"])): ?>
                <div class="w-full aspect-[16/9] md:aspect-[4/3] rounded-xl overflow-hidden shadow-sm bg-gray-200">
                    <img src="<?php echo htmlspecialchars($post["image"]); ?>" class="w-full h-full object-cover" alt="Post Image">
                </div>
            <?php endif; ?>

            <?php if ($post && isset($post["content"])): ?>
                <div class="bg-white text-gray-800 rounded-xl shadow-sm border border-gray-100 p-6 leading-relaxed text-base">
                   <?php echo nl2br(htmlspecialchars($post["content"])); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="w-full md:w-80 shrink-0 bg-white border border-gray-100 rounded-xl shadow-sm p-6 space-y-4">
            <?php if ($category && isset($category["name"])): ?>
                <div class="border-b border-gray-100 pb-3">
                    <span class="text-xs font-semibold text-gray-400 tracking-wider uppercase block mb-1">Category</span>
                    <span class="text-base font-bold text-gray-800">
                        <?php echo htmlspecialchars($category["name"]); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($author && isset($author["username"])): ?>
                <div class="border-b border-gray-100 pb-3">
                    <span class="text-xs font-semibold text-gray-400 tracking-wider uppercase block mb-1">Author</span>
                    <span class="text-base font-bold text-gray-800">    
                        @<?php echo htmlspecialchars($author["username"]); ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($post && isset($post["created_at"])): ?>
                <div>
                    <span class="text-xs font-semibold text-gray-400 tracking-wider uppercase block mb-1">Published On</span>
                    <span class="text-base font-bold text-gray-800">    
                        <?php echo date("d/m/Y", strtotime($post["created_at"])); ?>
                    </span>
                </div>
            <?php endif; ?>

            <div>
                <h2>Comments:</h2>
            </div>
        </div>

    </div>
</body>
