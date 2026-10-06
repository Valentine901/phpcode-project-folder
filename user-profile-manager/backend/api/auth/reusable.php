<?php
header("Content-Type: application/json");

require_once __DIR__ . "/../../settings/database.php";
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../settings/config.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PublicAuth
{

    private $constants;
    private $conn;

    public function __construct($constants, $conn)
    {
        $this->conn = $conn;
        $this->constants = $constants;
    }

    public function create_token($payload)
    {
        $token = JWT::encode($payload, $this->constants->JWT_SECRET, "HS256");
        return $token;
    }

    public function decode_token($token)
    {
        try {
            $payload = JWT::decode($token, new Key($this->constants->JWT_SECRET, "HS256"));
            return $payload;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                "message" => "Token expires or missing token"
            ]);
            exit();
        }
    }

    public function getUserById($user_id)
    {
        $sql = "SELECT id, email, username, password FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "id" => $user_id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return null;
        return $user;
    }


    public function getUserByEmail($user_email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            "email" => $user_email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return null;
        return $user;
    }

    public function getCurrentUser()
    {

        if (!isset($_COOKIE["access_token"])) {
            http_response_code(401);
            echo json_encode([
                "message" => "Access token missing"
            ]);

            exit();
        }

        $token = $_COOKIE["access_token"];
        $payload = $this->decode_token($token);

        $user_id = $payload->user_id;

        $user = $this->getUserById($user_id);
        if ($user === null) {
            http_response_code(404);
            echo json_encode([
                "message" => "User not found"
            ]);
        }

        return [
                "id" => $user["id"],
                "username" => $user["username"],
                "email" => $user["email"]
            ];
    }

    public function refreshToken()
    {

        if (!isset($_COOKIE["refresh_token"])) {
            http_response_code(401);
            echo json_encode([
                "message" => "Refresh token missing"
            ]);

            exit();
        }

        $token = $_COOKIE["refresh_token"];
        $payload = $this->decode_token($token);

        if ($payload->exp > time()) {

            $user_id = $payload->user_id;
            $user = $this->getUserById($user_id);

            if ($user === null) {
                http_response_code(404);
                echo json_encode([
                    "message" => "User not found"
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

            $accessToken = $this->create_token($accessPayload);
            $refreshToken = $this->create_token($refreshPayload);

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
                "message" => "Token refreshed success"
            ]);

            exit();
        } else {
            http_response_code(401);
            echo json_encode([
                "message" => "Token expired, Reloggin to continue"
            ]);
        }
    }
}

$publicAuth = new PublicAuth($constants, $conn);


// file processing 
class FileProcessor
{
    // this image params is because we are going to accept data from the browser which is an array of data e.g., ["image" => "profile.png", "username" => "valentine"]
    //     [
    //     "name" => "profile.png",
    //     "type" => "image/png",
    //     "tmp_name" => "C:\\xampp\\tmp\\php123.tmp",
    //     "error" => 0,
    //     "size" => 42815
    // ];
    private array $image;
    private int $maxFileSize = 5 * 1024 * 1024;
    private array $allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    public function __construct(array $image)
    {
        $this->image = $image;
    }

    public function checkUploadError(): void
    {
        if ($this->image["error"] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(["message" => "Image upload failed"]);

            exit();
        }
    }

    public function getMimeType() : string {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        // temp_name returns actual file type from temp loci
        return $fileInfo -> file($this -> image["tmp_name"]);
    }

    public function validateMimeType(string $mimeType): void {
        if (!in_array($mimeType, $this -> allowedTypes, true)){
            http_response_code(400);
            echo json_encode([
                "message" => "Only JPG, PNG and WEBP images are allowed"
            ]);

            exit();
        }
    }

    public function validateFileSize(): void {
        if($this -> image["size"] > $this -> maxFileSize) {
            http_response_code(400);
            echo json_encode([
                "message" => "File size must not exceed 5MB"
            ]);

            exit();
        }
    }

    public function generateFilename(string $mimeType): string{
        $extension = match ($mimeType) {
            "image/jpeg" => "jpg",
            "image/png" => "png",
            "image/webp" => "webp"
        };

        $uniqueId = uniqid("profile_", true);
        return $uniqueId . "." . $extension;
    }

    public function moveFile(string $filename): string {
        $uploadDirectory = __DIR__ . "/../../uploads/profiles/";

        $filePath = $uploadDirectory . $filename;

        if (!move_uploaded_file($this -> image["tmp_name"], $filePath)) {
            http_response_code(500);
            echo json_encode([
                "message" => "Failed to save uploaded file"
            ]);

            exit();
        }

        return $filePath;
    }
}
