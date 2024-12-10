<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;

class AdminWebController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->except(['login', 'showLoginForm']);
    }

    public function showLoginForm()
    {
        return view('admin.adminlogin');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $credentials = $request->only('username', 'password');
        
        \Log::info('Searching for user with username:', ['username' => $credentials['username']]);
        
        $user = UserModel::where('username', $credentials['username'])->first();
        
        \Log::info('User found:', ['user' => $user]);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found')->withInput();
        }

        if ($user->roleId != 1) {
            return redirect()->back()->with('error', 'Not authorized as admin')->withInput();
        }

        // Save the hashed password to database
        $user->password = Hash::make($credentials['password']);
        $user->save();
        
        \Log::info('Admin login successful:', ['user' => $user]);

        session(['admin' => $user]);
        
        return redirect()->route('sportsCars.index');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
