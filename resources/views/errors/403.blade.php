<x-layouts.app title="Access denied">
    <div class="card max-w-2xl p-6">
        <p class="text-slate-600">This page doesn't exist.</p>
        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn-primary">Back to products</a>
        </div>
    </div>
</x-layouts.app>
