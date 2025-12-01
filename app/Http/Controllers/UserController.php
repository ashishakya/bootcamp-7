<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Phone;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with(['phone', 'posts'])->orderByDesc('created_at')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function show(User $user): View
    {
        $user->load(['phone', 'posts', 'roles', 'carOwnerDetail', 'comments']);

        return view('users.show', compact('user'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $user = User::create($data);

        if (! empty($data['phone'])) {
            Phone::create([
                'user_id' => $user->id,
                'phone' => $data['phone'],
            ]);
        }

        if (! empty($roles)) {
            $user->roles()->sync($roles);
        }

        return redirect()->route('users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        if (! empty($data['phone'])) {
            $user->phone()->updateOrCreate(
                [],
                ['phone' => $data['phone']]
            );
        }

        $user->roles()->sync($roles);

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }
}
