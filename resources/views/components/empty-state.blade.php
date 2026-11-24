@props(['title', 'text' => null])
<div class="px-6 py-14 text-center">
    <svg class="mx-auto size-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0h-5l-1 2h-4l-1-2H4"/></svg>
    <h2 class="mt-3 text-sm font-semibold text-slate-900">{{ $title }}</h2>
    @if($text)<p class="mt-1 text-sm text-slate-500">{{ $text }}</p>@endif
    <div class="mt-4">{{ $slot }}</div>
</div>
