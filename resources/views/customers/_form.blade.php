@php $customer ??= null; @endphp
<form method="POST" action="{{ $action }}" class="card max-w-2xl space-y-5 p-6">
    @csrf
    @if($customer) @method('PUT') @endif
    <x-field name="full_name" label="Full name" :value="$customer?->full_name" required maxlength="100" autocomplete="off" />
    <div class="grid gap-5 sm:grid-cols-2">
        <x-field name="email" label="Email" type="email" :value="$customer?->email" required maxlength="100" autocomplete="off" />
        <x-field name="phone" label="Phone" type="tel" :value="$customer?->phone" maxlength="20" hint="Optional" autocomplete="off" />
    </div>
    <div class="flex gap-2 border-t border-slate-100 pt-5">
        <button type="submit" class="btn-primary">{{ $customer ? 'Save changes' : 'Create customer' }}</button>
        <a href="{{ $customer ? route('customers.show', $customer) : route('customers.index') }}" class="btn-secondary">Cancel</a>
    </div>
</form>
