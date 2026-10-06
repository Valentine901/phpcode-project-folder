<?php 

require_once __DIR__ . "/../../settings/cors.php";
require_once __DIR__ . "/../../settings/database.php";
require_once __DIR__ . "/../auth/reusable.php";

$user = $publicAuth -> getCurrentUser();
// echo json_encode(["user" => $user]);
$user_id = $user["id"];


$sql = "SELECT * FROM profile WHERE user_id = :user_id";
$stmt = $conn -> prepare($sql);
$stmt -> execute([
    "user_id" => $user_id
]);

$profile = $stmt -> fetch(PDO::FETCH_ASSOC);
if(!$profile) {
    http_response_code(404);
    echo json_encode(["message" => "You don't have a profile, proceed to create one."]);
    exit();
}

http_response_code(200);
echo json_encode([
    "first_name" => $profile["first_name"],
    "last_name" => $profile["last_name"],
    "bio" => $profile["bio"],
    "phone" => $profile["phone"],
    "location" => $profile["location"],
    "profile_image" => $profile["profile_image"]
]);

?>