<?php 
require_once __DIR__ . "/../../settings/cors.php";

header("Content-Type: application/json");

require_once  __DIR__ . "/../../settings/database.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid JSON format"
    ]);

    exit();
}


if (empty($data["username"]) || empty($data["email"]) || empty($data["password"])) {
    http_response_code(400);
    echo json_encode([
        "message" => "All fields are required"
    ]);
    exit();
}

if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
    http_response_code(409);
    echo json_encode([
        "message" => "Invalid email address"
    ]);

    exit();
}

$sql = "SELECT * FROM users WHERE email = :email";

$stmt = $conn -> prepare($sql);
$stmt -> execute([
    "email" => $data["email"]
]);

$user = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($user) {
    http_response_code(400);
    echo json_encode([
        "message" => "Email already existed"
    ]);

    exit();
}

try{

    $hashed_password = password_hash($data["password"], PASSWORD_ARGON2I);
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        "username" => $data["username"],
        "email" => $data["email"],
        "password" => $hashed_password
    ]);

    http_response_code(201);
    echo json_encode([
        "message" => "User created successfully",
        "user" => [
            "username" => $data["username"],
            "email" => $data["email"]
        ]
    ]);

    exit();

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "message" => "Failed to register user"
    ]);
}



?>