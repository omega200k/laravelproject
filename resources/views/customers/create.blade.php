<x-layouts.app title="New customer">
    @include('customers._form', ['action' => route('customers.store')])
</x-layouts.app>
