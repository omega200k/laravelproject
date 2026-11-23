@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null, 'required' => false])
@php $id = 'f-'.str_replace(['[', ']', '.'], '-', $name); @endphp
<div>
    <label for="{{ $id }}" class="label">{{ $label }}@if($required)<span class="text-red-600" aria-hidden="true"> *</span>@endif</label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
           @if($type !== 'password' && $type !== 'file') value="{{ old($name, $value) }}" @endif
           @required($required)
           @if($hint) aria-describedby="{{ $id }}-hint" @endif
           @error($name) aria-invalid="true" @enderror
           {{ $attributes->class(['input', 'input-error' => $errors->has($name)]) }}>
    @if($hint)<p id="{{ $id }}-hint" class="mt-1.5 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
</div>
