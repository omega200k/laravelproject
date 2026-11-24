<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\User;
use App\Services\ImageProcessor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(private ImageProcessor $images)
    {
    }

    public function index(Request $request): View
    {
        $staff = User::query()
            ->withCount('sales')
            ->when($request->string('q')->trim()->value(), function ($q, $term) {
                $q->where(fn ($w) => $w->where('full_name', 'like', "%{$term}%")
                    ->orWhere('username', 'like', "%{$term}%"));
            })
            ->orderBy('full_name')
            ->paginate(10)
            ->withQueryString();

        return view('staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('staff.create');
    }

    public function store(StaffRequest $request): RedirectResponse
    {
        $data = array_filter($request->safe()->only(['username', 'full_name', 'role', 'password']), fn ($v) => $v !== null);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->images->storeAvatar($request->file('avatar'));
        }

        $user = User::create($data);

        return redirect()->route('staff.show', $user)->with('success', 'Staff account created.');
    }

    public function show(User $staff): View
    {
        $staff->loadCount('sales');

        return view('staff.show', compact('staff'));
    }

    public function edit(User $staff): View
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(StaffRequest $request, User $staff): RedirectResponse
    {
        $data = array_filter($request->safe()->only(['username', 'full_name', 'role']), fn ($v) => $v !== null);

        if ($staff->is($request->user()) && isset($data['role']) && $data['role'] !== User::ROLE_ADMIN) {
            return back()->withInput()->withErrors(['role' => "You can't remove your own admin role."]);
        }

     
        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        $old = $staff->avatar;
        $newAvatar = null;

        if ($request->hasFile('avatar')) {
            $newAvatar = $data['avatar'] = $this->images->storeAvatar($request->file('avatar'));
        } elseif ($request->boolean('remove_avatar')) {
            $data['avatar'] = null;
        }

        try {
            $staff->update($data);
        } catch (\Throwable $e) {
            $this->images->delete($newAvatar, 'avatar');
            throw $e;
        }

        if (array_key_exists('avatar', $data) && $old !== $data['avatar']) {
            $this->images->delete($old, 'avatar');
        }

        return redirect()->route('staff.show', $staff)->with('success', 'Staff account updated.');
    }

    public function destroy(Request $request, User $staff): RedirectResponse
    {
        if ($staff->is($request->user())) {
            return back()->with('error', "You can't delete your own account while signed in.");
        }

        if ($staff->sales()->exists()) {
            return back()->with('error', "{$staff->full_name} can't be deleted because they have recorded sales.");
        }

        try {
            $staff->delete();
        } catch (QueryException) {
            return back()->with('error', "{$staff->full_name} can't be deleted because they are referenced by other records.");
        }

        $this->images->delete($staff->avatar, 'avatar');

        return redirect()->route('staff.index')->with('success', 'Staff account deleted.');
    }
}
