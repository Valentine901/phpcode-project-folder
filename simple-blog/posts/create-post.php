<?php

session_start();

require_once "../config/database.php";
require_once "../includes/header.php";



$errorMessage = "";

$categories = [];
$sqlCategory = "SELECT * FROM categories";
$stmt = $pdo -> query($sqlCategory);
$categories = $stmt->fetchAll();

// check when submit button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["post_submit"])) {

    
// check if logged in 
    if (!isset($_SESSION["logged_in"]) || isset($_SESSION["logged_in"]) !== true || !isset($_SESSION["email"]) || !isset($_SESSION["username"])) {
        $errorMessage = "You haven't logged in yet.";
    } 

    // convert logged in user id to respective integer
    $user_id = (int)$_SESSION["id"];
    $category_id = (int)$_POST["category_id"];
    $content = trim($_POST["content"]);
    $image = trim($_POST["image"]);


    $sql = "INSERT INTO posts (user_id, category_id, content, image) VALUES (:user_id, :category_id, :content, :image)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "user_id" => $user_id,
        "category_id" => $category_id,
        "content" => $content,
        "image" => $image
    ]);
    header("Location: ../index.php");
        exit();
    
}

?>


<body class="w-full h-screen">

    <form action="create-post.php" method="POST" class="flex flex-col gap-4 shadow-xl max-w-md w-full rounded-2xl p-8 mt-10 mx-auto bg-white border border-gray-100">

        <div class="text-center mb-2">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Post Page</h2>
            <p class="text-sm text-gray-500 mt-1">Make a post.</p>
        </div>


        <?php if (isset($errorMessage)) : ?>
            <div id="error-container" class="flex items-center ">
                <span class="text-red-500 text-md font-semibold text-center mx-auto flex">
                    <?= $errorMessage; ?>
                </span>
            </div>
        <?php endif ?>

        <div class="flex flex-col gap-1.5 w-full">
            <label for="category" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Image </label>
            <input type="text" name="image" placeholder="Copy and paste image url here..." class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>

        <div class="flex flex-col gap-1.5 w-full">
            <label for="category" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">categories </label>

            <select name="category_id" id="category" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">

                <option value="" disabled selected> Choose an Article Category</option>

                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category["id"] ?>">
                        <?php echo $category["name"]; ?>
                    </option>
                <?php endforeach ?>

            </select>
        </div>

        <div class="flex flex-col gap-1.5 w-full">
            <label for="category" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Content </label>

            <textarea required name="content" id="content_id" placeholder="Your post content" class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
            </textarea>
        </div>

        <button name="post_submit" type="submit" class="w-full mt-2 py-3 px-6 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 active:transform active:scale-[0.99] transition-all duration-200 shadow-md hover:shadow-lg">
            Upload
        </button>

    </form>

    <?php if (!empty($errorMessage)) : ?>


        <script>
            setTimeout(() => {
                const errorAlert = document.getElementById("error-container");

                if (errorAlert) {
                    errorAlert.style.opacity = "0";
                    setTimeout(() => errorAlert.style.display = "none", 500);
                }

            }, 3000)
        </script>


    <?php endif; ?>

</body>


<?php require_once '../includes/footer.php'  ?>