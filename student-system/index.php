<?php

require_once 'config/database.php';
require_once 'includes/header.php';


try {
    //  fetch all users from mysql db from the newest
    // instead of doing $pdo.query like in python, here i will do $pdo -> query, therefore $pdo -> query == $pdo.query
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    $students = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Error fetching student record: " . $e->getMessage());
};

?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Student Directory</h1>
            <p class="text-sm text-slate-500">Manage, monitor, and view all registered students on campus.</p>
        </div>
        <div>
            <h2 class="text-md font-semibold font-sans flex gap-2 items-center">
                <span>Total Students </span>
               <span class="font-bold text-2xl"> <?php echo count($students) ?>
               </span>
            </h2>
        </div>
    </div>

    <!-- Data Display Table Container -->
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="w-full text-left border-collapse bg-white">
            <!-- Table Header -->
            <thead class="bg-slate-50 text-slate-700 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Student ID</th>
                    <th class="px-6 py-4">Full Name</th>
                    <th class="px-6 py-4">Email Address</th>
                    <th class="px-6 py-4">Course</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (count($students) > 0): ?>
                    <!-- Loop through each student record found in the database -->
                    <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-mono font-medium text-indigo-600">
                                <?php echo htmlspecialchars($row['student_id']); ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <?php echo htmlspecialchars($row['fullname']); ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <?php echo htmlspecialchars($row['email']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full text-xs font-medium">
                                    <?php echo htmlspecialchars($row['course']); ?>
                                </span>
                            </td>
                            <!-- Action Buttons Placeholders -->
                            <td class="px-6 py-4 text-center space-x-3">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="text-amber-600 hover:text-amber-700 font-medium transition">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-700 font-medium transition">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- If the database table is completely empty -->
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            No student profiles found. Click "Add Student" to get started.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- include my footer neatly -->
<?php
require_once 'includes/footer.php';
?>