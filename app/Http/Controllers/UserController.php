<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use SweetAlert2\Laravel\Swal;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['admin', 'customer'])],
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        Swal::success(['title' => 'Success!', 'text' => 'User created successfully.']);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['admin', 'customer'])],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        Swal::success(['title' => 'Success!', 'text' => 'User updated successfully.']);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            Swal::error(['title' => 'Error!', 'text' => 'You cannot delete yourself.']);

            return redirect()->route('users.index');
        }

        $user->delete();

        Swal::success(['title' => 'Deleted!', 'text' => 'User deleted successfully.']);

        return redirect()->route('users.index');
    }
}
