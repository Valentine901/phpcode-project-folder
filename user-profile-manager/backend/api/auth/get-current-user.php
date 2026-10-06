<?php 

require_once __DIR__ . "/../../settings/cors.php";
require_once __DIR__ . "/../auth/reusable.php";

header("Content-Type: application/json");

$user = $publicAuth -> getCurrentUser();
echo json_encode(["user" => $user]);

?>