<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Relational PHP Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://googleapis.com" rel="stylesheet">
    <link rel="stylesheet" href="https://googleapis.com" />

    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
    </style>

</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/phpcodes/simple-blog/index.php" class="text-xl font-bold tracking-tight text-indigo-400">DevNotes <span class="text-white font-light">Blog</span></a>

            <div class="space-x-5 text-sm font-medium flex items-center">
                <a href="/phpcodes/simple-blog/categories/create-category.php" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                    
                    <span>Add category</span>
                </a>
                <a href="/phpcodes/simple-blog/posts/create-post.php" class="hover:text-indigo-400 transition flex items-center gap-1.5">
                    
                    <span>Create Post</span>
                </a>
                <a href="/phpcodes/simple-blog/login.php" class="hover:text-indigo-400 transition">Login</a>
                <a href="/phpcodes/simple-blog/register.php" class="hover:text-indigo-400 transition">Register</a>
            </div>

        </div>
    </nav>

    
    <main class="flex-grow max-w-5xl w-full mx-auto p-4 md:p-8">