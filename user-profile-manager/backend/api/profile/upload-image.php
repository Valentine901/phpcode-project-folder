<?php 

header("Content-Type: application/json");

if(!isset($_FILES["profile_image"])) {
    http_response_code(400);
    echo json_encode(["message" => "No image uploaded"]);
    exit();
}


$image = $_FILES["profile_image"];

// check if image upload success
//You can do this :
//  if($image["error"] !== 0) {}
if ($image["error"] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["message" => "Image upload failed"]);
    exit();
}
// different types of php upload errors
// UPLOAD_ERR_INI_SIZE
// UPLOAD_ERR_FORM_SIZE
// UPLOAD_ERR_PARTIAL
// UPLOAD_ERR_NO_FILE
// UPLOAD_ERR_NO_TMP_DIR
// UPLOAD_ERR_CANT_WRITE
// UPLOAD_ERR_EXTENSION


// Inspecting uploaded image to get the real type
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo -> file($image["tmp_name"]);


$allowedType = [
    "image/jpeg",
    "image/png",
    "image/jpg",
    "image/webp"
];

// checking if the file type is in the file type array using php in_array func
if(!in_array($mimeType, $allowedType)) {
    http_response_code(400);
    echo json_encode(["message" => "Only JPG, PNG, JPEG, and WEBP are allowed"]);

    exit();
}

// checking file size and calculate in bytes
// 1024 bytes = 1kb 
// 1024 kilobytes = 1mb
// 1024kb * 5 = 5mb

$maxFileSize = 1024 * 1024 * 5;
if ($image["size"] > $maxFileSize) {
    http_response_code(400);
    echo json_encode(["message" => "file size is bigger than 5MB"]);

    exit();
}

// generating a unique filename for our image
// first we use match built-in method to find a filetype that match our mimeType and assign a new extension to it
$extension = match ($mimeType) {
    "image/jpg" => "jpg",
    "image/jpeg" => "jpeg",
    "image/png" => "png",
    "image/webp" => "webp"
}; 

// concatenate the unique name and our extension
$unique_filename = uniqid("profile_", true) . "." . $extension;

// moving our file to a dir to be stored in db
// To move temporal dir ( C:\xampp\tmp\php5E41.tmp) to permanent dir (C:\xampp\htdocs\phpcodes\user-profile-manager\backend\uploads\profiles\) use :

// create a dir to store files and reference it here
$uploadDirectory = __DIR__ . "/../../uploads/profiles/";
$filePath =  $uploadDirectory . $unique_filename;
move_uploaded_file($image["tmp_name"], $filePath);

echo json_encode([
    "message" => "Image Uploaded successfully",
    "name" => $image["name"],
    "type" => $image["type"],
    // tmp_name is storing img to a temp location, later we use move_upload_file() to store at a permanent loci
    "tmp_name" => $image["tmp_name"],
    // check actual file type to avoid file attack
    "actual_type" => $mimeType,
    "file_path" => $filePath,
    "error" => $image["error"],
    "size" => $image["size"]
]);


?>