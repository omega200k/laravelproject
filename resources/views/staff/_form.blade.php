@php $staff ??= null; @endphp
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card max-w-2xl space-y-5 p-6">
    @csrf
    @if($staff) @method('PUT') @endif
    <div class="grid gap-5 sm:grid-cols-2">
        <x-field name="full_name" label="Full name" :value="$staff?->full_name" required maxlength="100" />
        <x-field name="username" label="Username" :value="$staff?->username" required maxlength="50" autocomplete="off" hint="Letters, numbers, dots, dashes and underscores." />
    </div>
    <div>
        <label for="f-role" class="label">Role <span class="text-red-600" aria-hidden="true">*</span></label>
        <select id="f-role" name="role" required class="input @error('role') input-error @enderror" @error('role') aria-invalid="true" @enderror>
            @foreach (\App\Models\User::ROLES as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $staff?->role ?? \App\Models\User::ROLE_STAFF) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <p class="mt-1.5 text-xs text-slate-500">Admins can manage everything. Staff can only view products and their stock.</p>
        @error('role')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <x-field name="password" label="Password" type="password" :required="! $staff" autocomplete="new-password"
                 :hint="$staff ? 'Leave blank to keep the current password.' : 'At least 8 characters.'" />
        <x-field name="password_confirmation" label="Confirm password" type="password" :required="! $staff" autocomplete="new-password" />
    </div>
    <div>
        <label for="f-avatar" class="label">Avatar</label>
        <div class="flex items-start gap-4">
            <x-avatar :user="$staff ?? new \App\Models\User" class="size-20" alt="" />
            <div class="min-w-0 flex-1">
                <input id="f-avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"
                       @error('avatar') aria-invalid="true" @enderror
                       class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                <p class="mt-1.5 text-xs text-slate-500">JPEG, PNG or WebP, up to 2 MB. Cropped to a square automatically.</p>
                @error('avatar')<p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                @if($staff?->avatar)
                    <label class="mt-3 flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" name="remove_avatar" value="1" @checked(old('remove_avatar')) class="rounded border-slate-300 text-accent-600">
                        Remove current avatar
                    </label>
                @endif
            </div>
        </div>
    </div>
    <div class="flex gap-2 border-t border-slate-100 pt-5">
        <button type="submit" class="btn-primary">{{ $staff ? 'Save changes' : 'Create account' }}</button>
        <a href="{{ $staff ? route('staff.show', $staff) : route('staff.index') }}" class="btn-secondary">Cancel</a>
    </div>
</form>
