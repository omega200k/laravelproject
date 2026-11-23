<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staff = $this->route('staff');

        return [
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('users', 'username')->ignore($staff?->id)],
            'full_name' => ['required', 'string', 'max:100'],
            'role' => ['nullable', Rule::in(array_keys(User::ROLES))],
            'password' => [$staff ? 'nullable' : 'required', 'string', Password::min(8), 'max:255', 'confirmed'],
            'avatar' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'The username may only contain letters, numbers, dots, dashes and underscores.',
            'avatar.max' => 'The avatar may not be larger than 2 MB.',
        ];
    }
}
