@props(['action', 'message', 'label' => 'Delete'])
<form method="POST" action="{{ $action }}" class="inline"
      onsubmit="return confirm(@js($message))">
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->class(['btn-danger btn-sm']) }}>{{ $label }}</button>
</form>
