<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
@php
  $nav = [
    ['products.*', 'products.index', 'Products', '/icons/package.svg', false],
    ['customers.*', 'customers.index', 'Customers', '/icons/users.svg', true],
    ['staff.*', 'staff.index', 'Staff', '/icons/user.svg', true],
    ['sales.create', 'sales.create', 'Record Sale', '/icons/philippine-peso.svg', false],
    ['sales.index', 'sales.index', 'Sales History', '/icons/clipboard-check.svg', true],
];
@endphp

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-2 focus:top-2 focus:z-50 focus:rounded focus:bg-white focus:px-3 focus:py-2">Skip to content</a>


<header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
    <button id="nav-toggle" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation"
            class="rounded-lg p-2 text-slate-700 hover:bg-slate-100">
        <img src="{{ asset('/icons/menu.svg') }}" alt="" class="size-6">
    </button>
    <span class="font-semibold text-slate-900">{{ config('app.name') }}</span>
    <x-avatar :user="auth()->user()" class="size-8" />
</header>
<div id="nav-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/40 lg:hidden"></div>


<aside id="sidebar" aria-label="Main navigation"
       class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform lg:translate-x-0">
    <div class="flex h-16 items-center gap-2 px-6 text-lg font-semibold text-slate-900">
        <span class="grid size-8 place-items-center rounded-lg bg-accent-600 text-white" aria-hidden="true">
            <img src="{{ asset('/icons/package.svg') }}" alt="" class="size-5">
        </span>
        {{ config('app.name') }}
    </div>
    <nav class="flex-1 space-y-1 px-3 py-2">
        @foreach ($nav as [$pattern, $route, $label, $icon, $adminOnly])
            @if (! $adminOnly || auth()->user()->can('admin'))
            @php $active = request()->routeIs($pattern) && ! ($route === 'sales.index' && request()->routeIs('sales.create')); @endphp
            <a href="{{ route($route) }}" @if($active) aria-current="page" @endif
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium {{ $active ? 'bg-accent-50 text-accent-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <img src="{{ asset($icon) }}" alt="" class="size-5 shrink-0">
                {{ $label }}
            </a>
            @endif
        @endforeach
    </nav>
    <div class="border-t border-slate-200 p-4">
        <div class="flex items-center gap-3">
            <x-avatar :user="auth()->user()" class="size-10" />
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()->full_name }}</p>
                <p class="truncate text-xs text-slate-500">{{ '@'.auth()->user()->username }} · {{ \App\Models\User::ROLES[auth()->user()->role] ?? auth()->user()->role }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn-secondary w-full btn-sm">Log out</button>
        </form>
    </div>
</aside>

<main id="main" class="lg:pl-64">
    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <x-flash />
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $title ?? '' }}</h1>
            @isset($actions)<div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>@endisset
        </div>
        {{ $slot }}
    </div>
</main>
</body>
</html>
