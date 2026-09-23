<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management Dashboard</title>
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
   <link href="https://googleapis.com" rel="stylesheet">
<style>
    *{
        font-family: "Roboto", sans-serif;
    }
</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold tracking-wide">🎓 School Manager Pro</a>
            <div class="space-x-4 text-sm font-medium">
                <a href="index.php" class="hover:text-indigo-200 transition">Dashboard</a>
                <a href="create.php" class="bg-white text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-50 transition shadow-sm">Add Student</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper Container -->
    <main class="flex-grow max-w-6xl w-full mx-auto p-4 md:p-8">
