<x-layouts.app title="Edit customer">
    @include('customers._form', ['action' => route('customers.update', $customer), 'customer' => $customer])
</x-layouts.app>
