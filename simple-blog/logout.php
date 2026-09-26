<?php

require_once "includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["logged_in"]) && isset($_POST["logout"])) {
    $_SESSION["id"] = null;
    $_SESSION["logged_in"] = false;
    $_SESSION["username"] = null;
    $_SESSION["email"] = null;
    session_destroy();
    header("Location: index.php");
}



?>

<body>
    <form action="logout.php" method="POST" class="flex flex-col shadow-sm border border-gray-700/60 rounded-xl px-6 py-16 w-xl mx-auto items-center justify-center w-full bg-gray-700/10">
    <h2 class="text-2xl font-semibold text-gray-900 mb-12">Are you sure you wanna logout?</h2>
    <div class="flex gap-6 w-full mx-auto justify-center items-center">
        <a href="index.php" class="px-6 py-2 rounded-sm border-none shadow-xs bg-gray-700/50 text-white" type="submit">Cancel</a>
        <button class="px-6 py-2 rounded-sm border-none shadow-xs bg-red-500 text-white" type="submit" name="logout">Logout</button>
    </div>
</form>
</body>

<?php require_once "includes/footer.php"; ?>