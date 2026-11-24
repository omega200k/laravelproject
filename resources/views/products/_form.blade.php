@php $product ??= null; @endphp
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card max-w-2xl space-y-5 p-6">
    @csrf
    @if($product) @method('PUT') @endif

    <x-field name="name" label="Product name" :value="$product?->name" required maxlength="100" />

    <div class="grid gap-5 sm:grid-cols-2">
        <x-field name="price" label="Price (₱)" type="number" step="0.01" min="0" inputmode="decimal" :value="$product?->price" required />
        <x-field name="stock_quantity" label="Stock quantity" type="number" step="1" min="0" :value="$product?->stock_quantity ?? 0" required />
    </div>

    <div>
        <label for="f-image" class="label">Product image</label>
        <div class="flex items-start gap-4">
            <x-product-image :product="$product ?? new \App\Models\Product" class="size-24" />
            <div class="min-w-0 flex-1">
                <input id="f-image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                       @error('image') aria-invalid="true" @enderror
                       class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                <p class="mt-1.5 text-xs text-slate-500">JPEG, PNG or WebP, up to 2 MB. Images are fitted into a square without distortion.</p>
                @error('image')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                @if($product?->image)
                    <label class="mt-3 flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image')) class="rounded border-slate-300 text-accent-600">
                        Remove current image
                    </label>
                @endif
            </div>
        </div>
    </div>

    <div class="flex gap-2 border-t border-slate-100 pt-5">
        <button type="submit" class="btn-primary">{{ $product ? 'Save changes' : 'Create product' }}</button>
        <a href="{{ $product ? route('products.show', $product) : route('products.index') }}" class="btn-secondary">Cancel</a>
    </div>
</form>
