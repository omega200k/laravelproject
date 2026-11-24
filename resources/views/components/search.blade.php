@props(['placeholder' => 'Search…'])
<form method="GET" class="mb-4 flex gap-2" role="search">
    <label for="q" class="sr-only">Search</label>
    <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="{{ $placeholder }}" class="input max-w-xs">
    <button class="btn-secondary" type="submit">Search</button>
    @if(request('q'))<a href="{{ url()->current() }}" class="btn-secondary">Clear</a>@endif
</form>
