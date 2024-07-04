<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use User;

class UserController extends Controller
{
    public function index(){
        return 'Hello from UserController';
    }

    public function login(){
        if(View::exists('user.login')){
            return view('user.login');
        }else{
           
            return abort(404);
        }
    }
    
    public function process(Request $request){
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        if(auth()->attempt($validated)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Welcome back!');
        }
            return back()->withErrors(['email'=> 'Login failed'])->onlyInput('email');
    }

    public function register(){
        return view('user.register');
    }

    public function logout(Request $request){
        auth()->logout();
        $request-> session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logout successful');
    }

    public function store(Request $request){
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => 'required|confirmed|min:6'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user= ModelsUser::create($validated);
       
        auth()->login($user);
    }

    public function show($id){

        return view('user') ->with('name', 'Ryu Sunjae')
                            ->with('age', 21)
                            ->with('email', 'sunjae@gmail.com')
                            ->with('id', $id);
    }
}
