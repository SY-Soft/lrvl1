<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    public function index()
    {
        $users = User::orderBy('id','asc')->paginate(10);

        return view('users.index',compact('users'));

    }

    public function create()
    {

        return view('users.create');  //        return view('users.form');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:64|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:64',
                Rule::unique('users','email')->ignore($user->id),
            ],

            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

/*
    public function changeRole(Request $request, User $user)
    {
        if ($request->direction === 'up') {
            $user->role--;
        }

        if ($request->direction === 'down') {
            $user->role++;
        }

        $user->save();

        return response()->json(['success' => true]);
    }
    */
    public function changeRole(Request $request, User $user)
    {
        // 1 - admin  2 - editor 3 - author

        if ($request->direction === 'up') {
            $_up=[0=>3,3=>2,2=>1];
            $user->role=$_up[$user->role];
        }

        if ($request->direction === 'down') {
            $_down=[1=>2,2=>3,3=>0];
            $user->role=$_down[$user->role];
        }

        $user->save();

        return view('users.partials.user_row', [
            'user' => $user
        ]);

    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted');
    }

    public function loginForm()
    {
        return view('users.loginForm');
    }

    public function loginAuth(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email',],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validated)) {
            return redirect()->intended('/')->with('success', 'Успешно авторизовались');
        }
        return back()->withErrors([
            'email' => 'Не верный пароль или E-Mail'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
