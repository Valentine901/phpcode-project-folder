<?php

require_once 'config/database.php';
require_once 'includes/header.php';

$student_id = $fullname = $email = $phone = $course = "";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $student_db_id = (int)$_GET['id'];

    $stmt_query = $pdo -> prepare("SELECT * FROM students WHERE id = :id");
    $stmt_query -> execute(["id" => $student_db_id]);

    $student = $stmt_query -> fetch();

    if($student) {
        $student_id = $student["student_id"];
        $fullname = $student["fullname"];
        $email = $student["email"];
        $phone = $student["phone"];
        $course = $student["course"];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $student_id = trim($_POST["student_id"]);
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);

    $stmt = $pdo -> prepare("UPDATE students SET student_id = :student_id, fullname = :fullname, email = :email, phone = :phone, course = :course WHERE id = :student_db_id");
    $stmt->execute([
        "student_db_id" => $student_db_id,
        "student_id" => $student_id,
        "fullname" => $fullname,
        "email" => $email,
        "phone" => $phone,
        "course" => $course
    ]);
    header("Location: index.php");
}

?>

<form action="edit.php?id=<?php echo $student_db_id; ?>" method="POST" class="flex flex-col gap-3 max-w-2xl w-full rounded-xl shadow-lg border-none p-4 mx-auto items-center">
    <input  type="text" class="w-full p-4 rounded-lg border border-gray-600 text-lg" value="<?php echo $student_id;?> "placeholder="STU-1003" name="student_id">
    <input  type="text" class="w-full p-4 rounded-lg border border-gray-600 text-lg" value="<?php echo $fullname;?>" placeholder="John Doe" name="fullname">
    <input  type="text" class="w-full p-4 rounded-lg border border-gray-600 text-lg" value="<?php echo $email;?> "placeholder="john@gmail.com" name="email">
    <input  type="text" class="w-full p-4 rounded-lg border border-gray-600 text-lg" value="<?php echo $phone;?>" placeholder="85647838383" name="phone">
    <input  type="text" class="w-full p-4 rounded-lg border border-gray-600 text-lg" value="<?php echo $course;?>" placeholder="Computer Science" name="course">
    <button type="submit" class="py-4 px-6 rounded-lg bg-blue-500 hover:bg-blue-600 duration-300 transition-all text-lg my-3 text-white font-semibold max-w-50 w-full mx-auto">Save Changes</button>
</form>

<?php 
    require_once 'includes/footer.php';
?>