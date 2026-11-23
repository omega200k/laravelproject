<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center px-4">
    <main class="w-full max-w-sm">
        <div class="mb-6 text-center">
            <span class="mx-auto grid size-12 place-items-center rounded-xl bg-accent-600 text-white" aria-hidden="true">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </span>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-slate-900">{{ config('app.name') }}</h1>
            <p class="mt-1 text-sm text-slate-500">Sign in with your staff account</p>
        </div>
        <form method="POST" action="{{ route('login.store') }}" class="card space-y-4 p-6">
            @csrf
            <x-field name="username" label="Username" required autofocus autocomplete="username" />
            <x-field name="password" label="Password" type="password" required autocomplete="current-password" />
            <button type="submit" class="btn-primary w-full">Sign in</button>
        </form>
    </main>
</body>
</html>
