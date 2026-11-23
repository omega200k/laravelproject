<x-layouts.app title="Edit product">
    @include('products._form', ['action' => route('products.update', $product), 'product' => $product])
</x-layouts.app>
