<?php

require_once 'config/database.php';
require_once 'includes/header.php';
include_once "dependencies/auth.php";

$authInstance = new AuthClass();
$errorMessage = "";



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_submit"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirmPassword"]);
    
    $userStmt = $pdo -> prepare('SELECT email FROM users WHERE email = :email');
    $userStmt -> execute(["email" => $email]);
    $user = $userStmt -> fetch();
    
    if($user) {
        $errorMessage = "User email already exists";

    }elseif ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match";
    } else {
        $hashed_password = $authInstance -> hashUserPassword($password);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "username" => $username,
            "email" => $email,
            "password" => $hashed_password
        ]);
        header("Location: login.php");
        exit();
    }
}




?>



<body class="w-full h-screen">

    <form action="register.php" method="POST" class="flex flex-col gap-4 shadow-xl max-w-md w-full rounded-2xl p-8 mt-10 mx-auto bg-white border border-gray-100">

        <div class="text-center mb-2">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create your account</h2>
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
            <label for="username" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Username</label>
            <input id="username" name="username" type="text" placeholder="e.g., johndoe" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>


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


        <div class="flex flex-col gap-1.5 w-full">
            <label for="confirm-password" class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Confirm Password</label>
            <input id="confirmPassword" name="confirmPassword" type="password" placeholder="••••••••" required
                class="w-full p-2.5 border border-gray-300 rounded-lg text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:border-gray-900 transition-colors">
        </div>


        <button name="register_submit" type="submit" class="w-full mt-2 py-3 px-6 rounded-lg text-sm font-semibold text-white bg-gray-900 hover:bg-gray-800 active:transform active:scale-[0.99] transition-all duration-200 shadow-md hover:shadow-lg">
            Create Account
        </button>

        <p class="text-center text-sm text-gray-600 mt-2">
            Already have an account?
            <a href="/phpcodes/simple-blog/login.php" class="font-medium text-gray-900 hover:underline">Sign in</a>
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