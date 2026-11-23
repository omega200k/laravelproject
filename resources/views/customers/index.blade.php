<x-layouts.app title="Customers">
    <x-slot:actions><a href="{{ route('customers.create') }}" class="btn-primary">+ New customer</a></x-slot:actions>

    <x-search placeholder="Search name or email…" />

    <div class="card overflow-hidden">
        @if ($customers->isEmpty())
            <x-empty-state :title="request('q') ? 'No customers match your search' : 'No customers yet'"
                           :text="request('q') ? 'Try a different search term.' : 'Customers are optional on sales, but handy to track.'">
                <a href="{{ route('customers.create') }}" class="btn-primary">+ New customer</a>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50"><tr>
                        <th scope="col" class="th">Name</th>
                        <th scope="col" class="th">Email</th>
                        <th scope="col" class="th">Phone</th>
                        <th scope="col" class="th text-right">Actions</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-slate-50/60">
                            <td class="td font-medium"><a href="{{ route('customers.show', $customer) }}" class="text-slate-900 hover:text-accent-700">{{ $customer->full_name }}</a></td>
                            <td class="td text-slate-600">{{ $customer->email }}</td>
                            <td class="td text-slate-600">{{ $customer->phone ?: '—' }}</td>
                            <td class="td whitespace-nowrap text-right">
                                <a href="{{ route('customers.edit', $customer) }}" class="btn-secondary btn-sm">Edit</a>
                                <x-delete-form :action="route('customers.destroy', $customer)" :message="'Delete customer '.$customer->full_name.'? This cannot be undone.'" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="mt-4">{{ $customers->links() }}</div>
</x-layouts.app>
