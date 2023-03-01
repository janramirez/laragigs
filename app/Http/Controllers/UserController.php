<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show all
    public function index()
    {
        // TODO
    }

    // show one
    public function show()
    {
        // TODO
    }

    // show registration form
    public function create()
    {
        return view('users.register');
    }

    // create new user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // create the user
        $user = User::create($formFields);

        // login newly created user
        auth()->login($user);

        return redirect('/')->with('message','User created and logged in');
    }

    // logout
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been logged out');
    }
    
    // show login form
    public function login()
    {
        return view('users.login');
    }

    // authenticate
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message','You are logged in');
        }
        return back()->with(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    // update user
    public function update()
    {

    }

    // delete user
    public function destroy()
    {

    }
}
