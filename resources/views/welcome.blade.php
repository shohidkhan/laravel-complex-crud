<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
  <h1 class="text-3xl font-bold flex justify-between bg-red-400 p-4 text-white">
    <span>
        Welcome to complex Crud with Laravel
    </span>
    <a href="{{ route('posts.index') }}" class="hover:underline">
        Posts
    </a>
  </h1>
</body>
</html>