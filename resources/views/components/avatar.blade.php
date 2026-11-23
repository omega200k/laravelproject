@props(['user'])
<img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" loading="lazy"
     {{ $attributes->class(['shrink-0 rounded-full border border-slate-200 bg-slate-100 object-cover']) }}>
