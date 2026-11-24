<x-layouts.app :title="$product->name">
    <div class="card max-w-2xl p-6">
        <div class="flex flex-col gap-6 sm:flex-row">
            <x-product-image :product="$product" class="size-48 self-center sm:self-start" />
            <dl class="grid flex-1 grid-cols-2 gap-x-4 gap-y-4 text-sm">
                <div><dt class="text-slate-500">Price</dt><dd class="mt-0.5 text-lg font-semibold tabular-nums">{{ \App\Support\Money::format($product->price) }}</dd></div>
                <div><dt class="text-slate-500">Stock</dt><dd class="mt-1"><x-stock-badge :product="$product" /></dd></div>
                <div><dt class="text-slate-500">Units on hand</dt><dd class="mt-0.5 font-medium">{{ number_format($product->stock_quantity) }}</dd></div>
                    <div><dt class="text-slate-500">Sales recorded</dt><dd class="mt-0.5 font-medium">{{ number_format($product->sales_count) }}</dd></div>
                <div class="col-span-2"><dt class="text-slate-500">Added</dt><dd class="mt-0.5">{{ $product->created_at?->format('M j, Y g:i A') }}</dd></div>
            </dl>
        </div>
    </div>
</x-layouts.app>
