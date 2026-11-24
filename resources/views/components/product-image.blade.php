@props(['product'])
<img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
     {{ $attributes->class(['shrink-0 rounded-lg border border-slate-200 bg-slate-100 object-cover']) }}>
