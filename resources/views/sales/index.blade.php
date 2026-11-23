<x-layouts.app title="Sales history">
    <x-slot:actions><a href="{{ route('sales.create') }}" class="btn-primary">+ Record sale</a></x-slot:actions>

    <form method="GET" class="card mb-4 grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-5 lg:items-end" role="search">
        <div class="lg:col-span-2">
            <label for="q" class="label">Search</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Product, customer or staff…" class="input">
        </div>
        <div>
            <label for="staff" class="label">Staff</label>
            <select id="staff" name="staff" class="input">
                <option value="">All staff</option>
                @foreach ($staffList as $s)
                    <option value="{{ $s->id }}" @selected(request('staff') == $s->id)>{{ $s->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="from" class="label">From</label>
            <input id="from" name="from" type="date" value="{{ request('from') }}" class="input @error('from') input-error @enderror">
        </div>
        <div>
            <label for="to" class="label">To</label>
            <input id="to" name="to" type="date" value="{{ request('to') }}" class="input @error('to') input-error @enderror">
            @error('to')<p class="mt-1 text-xs text-red-600" role="alert">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-2 sm:col-span-2 lg:col-span-5">
            <button class="btn-primary" type="submit">Apply filters</button>
            @if(request()->hasAny(['q', 'staff', 'from', 'to']))<a href="{{ route('sales.index') }}" class="btn-secondary">Clear</a>@endif
        </div>
    </form>

    <div class="card overflow-hidden">
        @if ($sales->isEmpty())
            <x-empty-state :title="request()->hasAny(['q', 'staff', 'from', 'to']) ? 'No sales match your filters' : 'No sales recorded yet'"
                           :text="request()->hasAny(['q', 'staff', 'from', 'to']) ? 'Try widening the date range or clearing the search.' : 'Recorded sales will appear here.'">
                <a href="{{ route('sales.create') }}" class="btn-primary">+ Record sale</a>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50"><tr>
                        <th scope="col" class="th">Date &amp; time</th>
                        <th scope="col" class="th">Product</th>
                        <th scope="col" class="th">Customer</th>
                        <th scope="col" class="th">Sold by</th>
                        <th scope="col" class="th text-right">Qty</th>
                        <th scope="col" class="th text-right">Total</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($sales as $sale)
                        <tr class="hover:bg-slate-50/60">
                            <td class="td whitespace-nowrap text-slate-600">{{ $sale->created_at->format('M j, Y g:i A') }}</td>
                            <td class="td font-medium text-slate-900">{{ $sale->product->name }}</td>
                            <td class="td {{ $sale->customer ? '' : 'text-slate-500' }}">{{ $sale->customer?->full_name ?? 'Walk-in Customer' }}</td>
                            <td class="td">{{ $sale->staff->full_name }}</td>
                            <td class="td text-right tabular-nums">{{ number_format($sale->quantity) }}</td>
                            <td class="td text-right font-medium tabular-nums">{{ \App\Support\Money::format($sale->total_price) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="mt-4">{{ $sales->links() }}</div>
</x-layouts.app>
