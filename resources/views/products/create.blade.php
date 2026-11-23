<x-layouts.app title="New product">
    @include('products._form', ['action' => route('products.store')])
</x-layouts.app>
