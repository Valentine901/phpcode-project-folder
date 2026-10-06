<?php

require_once __DIR__ . "/../../settings/cors.php";
require_once __DIR__ . "/../../settings/database.php";
require_once __DIR__ . "/../auth/reusable.php";

// get authenticated user
$user = $publicAuth -> getCurrentUser();
// echo json_encode(["user" => $user]);
$user_id = $user["id"];

// use the user_id and query for a profile,
$sql = "SELECT id, last_name, first_name FROM profile WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    "user_id" => $user_id
]);

$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if ($profile) {
    http_response_code(400);
    echo json_encode([
        "message" => "Profile already existed"
    ]);
    exit();
}

// $data = json_decode(file_get_contents("php://input"), true);
if (!isset($_FILES["profile_image"])) {
    http_response_code(400);
    echo json_encode([
        "message" => "Profile image is required"
    ]);
    exit();
}
$image = $_FILES["profile_image"];


// if (!$data) {
//     http_response_code(400);
//     echo json_encode(["message" => "Invalid JSON format"]);
//     exit();
// }

if (empty($_POST["first_name"]) || empty($_POST["last_name"])) {
    http_response_code(400);
    echo json_encode([
        "message" => "First name and last name are required"
    ]);

    exit();
}


$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$location = $_POST["location"];
$phone = $_POST["phone"];
$bio = $_POST["bio"];

$fileProcessor = new FileProcessor($image);
$fileProcessor -> checkUploadError();
$mimeType = $fileProcessor -> getMimeType();
$fileProcessor -> validateMimeType($mimeType);
$fileProcessor -> validateFileSize();
$filename = $fileProcessor -> generateFilename($mimeType);
$fileProcessor -> moveFile($filename);



// if no profile , show user a button to create new one
$sql = "INSERT INTO profile (first_name, last_name, bio, phone, location, profile_image, user_id) VALUES (:first_name, :last_name, :bio, :phone, :location, :profile_image, :user_id)";
$stmt = $conn -> prepare($sql);
$stmt -> execute([
    "first_name" => $firstName,
    "last_name" => $lastName,
    "bio" => $bio,
    "phone" => $phone,
    "location" => $location,
    "profile_image" => $filename,
    "user_id" => $user_id
]);

http_response_code(201);
echo json_encode([
    "message" => "Profile created"
]);


// else display their profile
