<?php

require_once __DIR__ . "/../../settings/cors.php";
require_once __DIR__ . "/../../settings/database.php";
require_once __DIR__ . "/../auth/reusable.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid JSON format"
    ]);

    exit();
}

if (empty($data["email"]) || empty($data["password"])) {
    http_response_code(400);
    echo json_encode([
        "message" => "All fields are required"
    ]);

    exit();
}

if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        "message" => "Invalid email address"
    ]);

    exit();
}

try {
    $sql = "SELECT id, email, username, password FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        "email" => $data["email"]
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode([
            "message" => "Email not found"
        ]);

        exit();
    }

    if (!password_verify($data["password"], $user["password"])) {
        http_response_code(401);
        echo json_encode([
            "message" => "Invalid user password"
        ]);

        exit();
    }

    $accessPayload = [
        "user_id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"],
        "iat" => time(),
        "exp" => time() + (60 * 60)
    ];

    $refreshPayload = [
        "user_id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"],
        "iat" => time(),
        "exp" => time() + (60 * 60 * 24 * 7)
    ];

    $accessToken = $publicAuth->create_token($accessPayload);

    $refreshToken = $publicAuth->create_token($refreshPayload);

    setcookie("access_token", $accessToken, [
        "expires" => time() + (60 * 60),
        "httponly" => true,
        "secure" => false,
        "samesite" => "Lax",
        "path" => "/"
    ]);

    setcookie("refresh_token", $refreshToken, [
        "expires" => time() + (60 * 60 * 24 * 7),
        "httponly" => true,
        "secure" => false,
        "samesite" => "Lax",
        "path" => "/"
    ]);

    http_response_code(200);
    echo json_encode([
        "user" => [
            "id" => $user["id"],
            "email" => $user["email"],
            "username" => $user["username"]
        ]
    ]);

    exit();
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "message" => "Failed to login"
    ]);
    exit();
}
