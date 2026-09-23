<?php 

require_once 'config/database.php';
require_once 'includes/header.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = trim($_POST["student_id"]);
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $course = trim($_POST["course"]);


    // :student_id, :fullname ->  This tells MySQL to treat the inputs strictly as harmless text, preventing SQL Injection attacks
    $sql = "INSERT INTO students (student_id, fullname, email, phone, course) VALUES (:student_id, :fullname, :email, :phone, :course)";

     // We use $pdo->prepare() instead of ->query() because this statement contains user variables!
    $stmt = $pdo -> prepare($sql);

    try{
        $stmt -> execute([
            'student_id' => $student_id,
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'course' => $course
        ]);

        // once successfully created new record, redirect to dashboard
        header("Location: index.php");
    } catch (\PDOException $e) {
        $error_message = "Error saving student: " . $e -> getMessage();
        // die("Error saving student: " . $e -> getMessage());
    }
}

?>



<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Add New Student</h1>
        <p class="text-sm text-slate-500">Register a new profile into the campus directory.</p>
    </div>

    <!-- Show an alert if a database error occurs -->
    <?php if (isset($error_message)): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-4 rounded-md mb-6">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="create.php" method="POST" class="space-y-4">
        
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Student ID</label>
            <input type="text" name="student_id" placeholder="e.g. STU-1003" required
                   class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
            <input type="text" name="fullname" placeholder="Johnathan Doe" required
                   class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
            <input type="email" name="email" placeholder="johndoe@school.com" required
                   class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
            <input type="text" name="phone" placeholder="e.g. 08012345678"
                   class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Course / Department</label>
            <input type="text" name="course" placeholder="e.g. Computer Science" required
                   class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="index.php" class="text-sm font-medium text-slate-600 hover:text-slate-800 transition">Cancel</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md text-sm transition shadow-sm">
                Save Student
            </button>
        </div>
    </form>
</div>

<?php 
require_once 'includes/footer.php'; 
?>