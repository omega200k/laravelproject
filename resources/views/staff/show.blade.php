<x-layouts.app :title="$staff->full_name">
    <x-slot:actions>
        <a href="{{ route('staff.index') }}" class="btn-secondary">Back</a>
        <a href="{{ route('staff.edit', $staff) }}" class="btn-primary">Edit</a>
        @unless($staff->is(auth()->user()))
            <x-delete-form :action="route('staff.destroy', $staff)" :message="'Delete staff account '.$staff->full_name.'? This cannot be undone.'" class="py-2" />
        @endunless
    </x-slot:actions>
    <div class="card max-w-2xl p-6">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
            <x-avatar :user="$staff" class="size-28 self-center" />
            <dl class="grid flex-1 grid-cols-2 gap-4 text-sm">
                <div><dt class="text-slate-500">Username</dt><dd class="mt-0.5 font-medium">{{ $staff->username }}</dd></div>
                <div><dt class="text-slate-500">Role</dt><dd class="mt-1"><span class="{{ $staff->isAdmin() ? 'badge-green' : 'badge-slate' }}">{{ \App\Models\User::ROLES[$staff->role] ?? $staff->role }}</span></dd></div>
                <div><dt class="text-slate-500">Sales recorded</dt><dd class="mt-0.5 font-medium">{{ number_format($staff->sales_count) }}</dd></div>
                <div class="col-span-2"><dt class="text-slate-500">Created</dt><dd class="mt-0.5">{{ $staff->created_at?->format('M j, Y g:i A') }}</dd></div>
            </dl>
        </div>
    </div>
</x-layouts.app>
