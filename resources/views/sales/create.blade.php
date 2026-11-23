<x-layouts.app title="Record sale">
    <form method="POST" action="{{ route('sales.store') }}" id="sale-form" class="grid items-start gap-6 lg:grid-cols-3" novalidate>
        @csrf
        <div class="card space-y-5 p-6 lg:col-span-2">
            <div>
                <label for="product_id" class="label">Product <span class="text-red-600" aria-hidden="true">*</span></label>
                <select id="product_id" name="product_id" required class="input @error('product_id') input-error @enderror" @error('product_id') aria-invalid="true" @enderror>
                    <option value="">Select a product…</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}"
                                @selected(old('product_id') == $product->id) @disabled($product->stock_quantity <= 0 && old('product_id') != $product->id)>
                            {{ $product->name }}@if($product->stock_quantity <= 0) — out of stock @endif
                        </option>
                    @endforeach
                </select>
                @error('product_id')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="customer_id" class="label">Customer</label>
                <select id="customer_id" name="customer_id" class="input @error('customer_id') input-error @enderror">
                    <option value="">Walk-in Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->full_name }}</option>
                    @endforeach
                </select>
                @error('customer_id')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="quantity" class="label">Quantity <span class="text-red-600" aria-hidden="true">*</span></label>
                <input id="quantity" name="quantity" type="number" min="1" step="1" inputmode="numeric" required
                       value="{{ old('quantity', 1) }}" class="input max-w-40 @error('quantity') input-error @enderror"
                       @error('quantity') aria-invalid="true" @enderror aria-describedby="qty-hint">
                <p id="qty-hint" class="mt-1 text-sm text-slate-500">Enter the number of units sold.</p>
                @error('quantity')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-2 border-t border-slate-100 pt-5">
                <button type="submit" class="btn-primary">Record sale</button>
                <a href="{{ route('sales.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </div>

        <aside class="card p-6" aria-live="polite" aria-label="Sale summary">
            <h2 class="text-sm font-semibold text-slate-900">Summary</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">Unit price</dt><dd id="sum-price" class="font-medium tabular-nums">—</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">Available stock</dt><dd id="sum-stock" class="font-medium tabular-nums">—</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">Customer</dt><dd id="sum-customer" class="font-medium">Walk-in Customer</dd></div>
                <div class="flex items-baseline justify-between border-t border-slate-100 pt-3">
                    <dt class="font-medium text-slate-900">Total</dt><dd id="sum-total" class="text-xl font-semibold tabular-nums text-accent-700">₱0.00</dd>
                </div>
            </dl>
            <p id="sum-warn" class="mt-3 hidden rounded-lg bg-amber-50 px-3 py-2 text-sm text-amber-800" role="alert"></p>
        </aside>
    </form>

    <script>
        (function () {
            const product = document.getElementById('product_id');
            const customer = document.getElementById('customer_id');
            const qty = document.getElementById('quantity');
            const el = (id) => document.getElementById(id);
            const peso = (cents) => '₱' + (cents / 100).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            function update() {
                const opt = product.selectedOptions[0];
                const has = opt && opt.value !== '';
                const cents = has ? Math.round(parseFloat(opt.dataset.price) * 100) : 0;
                const stock = has ? parseInt(opt.dataset.stock, 10) : null;
                const q = parseInt(qty.value, 10);
                const validQty = Number.isInteger(q) && q > 0;

                el('sum-price').textContent = has ? peso(cents) : '—';
                el('sum-stock').textContent = has ? stock.toLocaleString() : '—';
                el('sum-customer').textContent = customer.value ? customer.selectedOptions[0].text : 'Walk-in Customer';
                el('sum-total').textContent = peso(has && validQty ? cents * q : 0);

                const warn = el('sum-warn');
                if (has && validQty && q > stock) {
                    warn.textContent = 'Quantity exceeds available stock (' + stock + ').';
                    warn.classList.remove('hidden');
                } else {
                    warn.classList.add('hidden');
                }
            }
            [product, customer].forEach((n) => n.addEventListener('change', update));
            qty.addEventListener('input', update);
            update();
        })();
    </script>
</x-layouts.app>
