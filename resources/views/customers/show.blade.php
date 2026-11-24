<x-layouts.app :title="$customer->full_name">
    <x-slot:actions>
        <a href="{{ route('customers.index') }}" class="btn-secondary">Back</a>
        <a href="{{ route('customers.edit', $customer) }}" class="btn-primary">Edit</a>
        <x-delete-form :action="route('customers.destroy', $customer)" :message="'Delete customer '.$customer->full_name.'? This cannot be undone.'" class="py-2" />
    </x-slot:actions>
    <div class="card max-w-2xl p-6">
        <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
            <div><dt class="text-slate-500">Email</dt><dd class="mt-0.5 font-medium">{{ $customer->email }}</dd></div>
            <div><dt class="text-slate-500">Phone</dt><dd class="mt-0.5 font-medium">{{ $customer->phone ?: '—' }}</dd></div>
            <div><dt class="text-slate-500">Purchases</dt><dd class="mt-0.5 font-medium">{{ number_format($customer->sales_count) }}</dd></div>
            <div><dt class="text-slate-500">Added</dt><dd class="mt-0.5">{{ $customer->created_at?->format('M j, Y g:i A') }}</dd></div>
        </dl>
    </div>
</x-layouts.app>
