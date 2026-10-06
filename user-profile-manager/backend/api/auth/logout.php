<?php

require_once __DIR__ . "/../../settings/cors.php";

header("Content-Type: application/json");

setcookie("access_token", "", [
    "expires" => time() - 120,
    "httponly" => true,
    "secure" => false,
    "samesite" => "Lax",
    "path" => "/"
]);

setcookie("refresh_token", "", [
    "expires" => time() - (3600 * 24 * 7),
    "httponly" => true,
    "secure" => false,
    "samesite" => "Lax",
    "path" => "/"
]);

http_response_code(200);
echo json_encode([
    "message" => "Logged out success"
]);

?>
