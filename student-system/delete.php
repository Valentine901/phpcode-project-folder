<?php

require_once 'config/database.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

    // convert to integer because html form returns strings
    $student_db_id = (int)$_GET["id"];

    // checking if the usr exists in the database
    $check_stmt = $pdo->prepare("
    SELECT id FROM students WHERE id = :id
    ");

    $check_stmt->execute(["id" => $student_db_id]);

    // fetching the record or return false if row does not exist
    $student_exists = $check_stmt->fetch();

    if ($student_exists) {
        $delete_stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
        $delete_stmt->execute(["id" => $student_db_id]);

        header("Location: index.php");
        exit;
    } else {
        die("System Alert: The student profile you are attempting to delete does not exist");
    }
} else {
    die("Invalid request. No student tracking ID was specified");
}
