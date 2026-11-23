<x-layouts.app title="Products">
        <x-slot:actions><a href="{{ route('products.create') }}" class="btn-primary">+ New product</a></x-slot:actions>
    <x-search placeholder="Search products…" />

    <div class="card overflow-hidden">
        @if ($products->isEmpty())
            <x-empty-state :title="request('q') ? 'No products match your search' : 'No products yet'"
                           :text="request('q') ? 'Try a different search term.' : 'Add your first product to start selling.'">

                    <a href="{{ route('products.create') }}" class="btn-primary">+ New product</a>

            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50"><tr>
                        <th scope="col" class="th">Product</th>
                        <th scope="col" class="th text-right">Price</th>
                        <th scope="col" class="th">Stock</th>

                            <th scope="col" class="th text-right">Actions</th>

                    </tr></thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-slate-50/60">
                            <td class="td">
                                <a href="{{ route('products.show', $product) }}" class="flex items-center gap-3 font-medium text-slate-900 hover:text-accent-700">
                                    <x-product-image :product="$product" class="size-12" />
                                    <span>{{ $product->name }}</span>
                                </a>
                            </td>
                            <td class="td text-right tabular-nums">{{ \App\Support\Money::format($product->price) }}</td>
                            <td class="td"><x-stock-badge :product="$product" /></td>
                                <td class="td whitespace-nowrap text-right">
                                    <a href="{{ route('products.edit', $product) }}" class="btn-secondary btn-sm">Edit</a>
                                    <x-delete-form :action="route('products.destroy', $product)" :message="'Delete product “'.$product->name.'”? This cannot be undone.'" />
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</x-layouts.app>
