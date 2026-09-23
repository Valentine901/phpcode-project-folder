<?php

$host = "127.0.0.1"; // localhost
$db = "school_db"; // database name
$user = "root"; // xampp username
$pass = ""; // xampp password
$charset = "utf8mb4"; // allows handling special characters

// DSN: Data Source Name -> Tells the PDO where to connect
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    //to show details error during testing
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 

     // pull database record as clean array
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // uses real prepared statementss for extreme security
    PDO::ATTR_EMULATE_PREPARES => false,
];

try{
    // create active database connection and return pdo
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e){
    // if something goes wrong, stop everything and show the error as text
    die("Database connection failed: " . $e->getMessage());
};

?>