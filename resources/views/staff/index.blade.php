<x-layouts.app title="Staff">
    <x-slot:actions><a href="{{ route('staff.create') }}" class="btn-primary">+ New staff</a></x-slot:actions>

    <x-search placeholder="Search name or username…" />

    <div class="card overflow-hidden">
        @if ($staff->isEmpty())
            <x-empty-state title="No staff found" :text="request('q') ? 'Try a different search term.' : null">
                <a href="{{ route('staff.create') }}" class="btn-primary">+ New staff</a>
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50"><tr>
                        <th scope="col" class="th">Staff member</th>
                        <th scope="col" class="th">Username</th>
                        <th scope="col" class="th">Role</th>
                        <th scope="col" class="th text-right">Sales</th>
                        <th scope="col" class="th text-right">Actions</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-100">
                    @foreach ($staff as $member)
                        <tr class="hover:bg-slate-50/60">
                            <td class="td">
                                <a href="{{ route('staff.show', $member) }}" class="flex items-center gap-3 font-medium text-slate-900 hover:text-accent-700">
                                    <x-avatar :user="$member" class="size-10" />
                                    <span>{{ $member->full_name }}@if($member->is(auth()->user())) <span class="badge-slate ml-1">You</span>@endif</span>
                                </a>
                            </td>
                            <td class="td text-slate-600">{{ $member->username }}</td>
                            <td class="td"><span class="{{ $member->isAdmin() ? 'badge-green' : 'badge-slate' }}">{{ \App\Models\User::ROLES[$member->role] ?? $member->role }}</span></td>
                            <td class="td text-right tabular-nums">{{ number_format($member->sales_count) }}</td>
                            <td class="td whitespace-nowrap text-right">
                                <a href="{{ route('staff.edit', $member) }}" class="btn-secondary btn-sm">Edit</a>
                                @unless($member->is(auth()->user()))
                                    <x-delete-form :action="route('staff.destroy', $member)" :message="'Delete staff account '.$member->full_name.'? This cannot be undone.'" />
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="mt-4">{{ $staff->links() }}</div>
</x-layouts.app>
