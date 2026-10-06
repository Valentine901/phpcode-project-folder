<?php

require_once __DIR__ . "/../settings/config.php";

$servername = $constants->DB_HOST;
$username = $constants->DB_USER;
$password = $constants->DB_PASS;
$dbname = $constants->DB_NAME;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
