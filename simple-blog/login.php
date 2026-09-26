<?php

// if (session_start() === PHP_SESSION_NONE) {
//     session_start();
// }

require_once "config/database.php";
require_once "includes/header.php";
require_once "dependencies/auth.php";

$authInstance = new AuthClass();
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signin_submit"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, username, email, password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "email" => $email
    ]);
    $user = $stmt->fetch();

    if ($user["email"] === $email && $authInstance->verifyUserPassword($password, $user["password"])) {
        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["username"] = $user["username"];
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        $errorMessage = "Incorrect email or password";
    }
}

?>


<body class="w-full h-screen">

    <form action="login.php" method="POST" class="flex flex-col gap-4 shadow-xl max-w-md w-full rounded-2xl p-8 mt-10 mx-auto bg-white border border-gray-100">

        <div class="text-center mb-2">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Sign In</h2>
            <p class="text-sm text-gray-500 mt-1">Start your blogging journey today.</p>
        </div>


        <?php if (isset($errorMessage)) : ?>
            <div id="error-container" class="flex items-center ">
                <span class="text-red-500 text-md font-semibold text-center mx-auto flex">
                    <?= $errorMessage; ?>
                </span>
            </div>
        <?php endif ?>

        <div class="flex flex-col gap-1.5 w-full">
            <label for="email" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Email Address</label>
            <input id="email" name="email" type="email" placeholder="you@example.com" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>


        <div class="flex flex-col gap-1.5 w-full">
            <label for="password" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
            <input id="password" name="password" type="password" placeholder="••••••••" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>



        <button name="signin_submit" type="submit" class="w-full mt-2 py-3 px-6 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 active:transform active:scale-[0.99] transition-all duration-200 shadow-md hover:shadow-lg">
            Sign In
        </button>

        <p class="text-center text-sm text-gray-600 mt-2">
            Don't have an account?
            <a href="/phpcodes/simple-blog/register.php" class="font-medium text-gray-900 hover:underline">Create Account</a>
        </p>
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


<?php require_once 'includes/footer.php'  ?>