@props(['title' => config('app.name')])
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-base-200">
    @include('layouts.navigation')
    
    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="alert alert-success mb-4"> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error mb-4"> {{ session('error') }}</div>
        @endif
        
        {{ $slot }}
    </main>
</body>
</html>
