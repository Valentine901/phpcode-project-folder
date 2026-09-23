<?php

session_start();

require_once "../config/database.php";
require_once "../includes/header.php";



$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["category_submit"])) {
    $category_name = trim($_POST["name"]);

    $sql = "SELECT name FROM categories WHERE name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "name" => $category_name
    ]);

    $category = $stmt->fetch();

    

    if (!isset($_SESSION["logged_in"]) || isset($_SESSION["logged_in"]) !== true || !isset($_SESSION["email"]) || !isset($_SESSION["username"])) {
        $errorMessage = "You haven't logged in yet.";
    } elseif ($category) {
        $errorMessage = "Category name already exists";
    } else {

        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "name" => $category_name
        ]);
        header("Location: ../index.php");
        exit();
    }
}

?>


<body class="w-full h-screen">

    <form action="create-category.php" method="POST" class="flex flex-col gap-4 shadow-xl max-w-md w-full rounded-2xl p-8 mt-10 mx-auto bg-white border border-gray-100">

        <div class="text-center mb-2">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Category Page</h2>
            <p class="text-sm text-gray-500 mt-1">Add categories of your choice.</p>
        </div>


        <?php if (isset($errorMessage)) : ?>
            <div id="error-container" class="flex items-center ">
                <span class="text-red-500 text-md font-semibold text-center mx-auto flex">
                    <?= $errorMessage; ?>
                </span>
            </div>
        <?php endif ?>

        <div class="flex flex-col gap-1.5 w-full">
            <label for="category" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Category </label>
            <input id="category" name="name" type="text" placeholder="e.g., book, phone, govt news title" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>





        <button name="category_submit" type="submit" class="w-full mt-2 py-3 px-6 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 active:transform active:scale-[0.99] transition-all duration-200 shadow-md hover:shadow-lg">
            Save
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