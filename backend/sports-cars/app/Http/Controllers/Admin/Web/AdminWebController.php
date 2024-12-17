<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;
use Carbon\Carbon;

class AdminWebController extends Controller
{   
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)
             ->except(['login', 'showLoginForm', 'register', 'showRegisterForm']);
    }
    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }
    /**
     * generate unique user id
     */
    private function generateUniqueUserID(): string
    {
        do {
            $userId = $this->generateRandomAlphanumericID(15);
        } while (UserModel::where('userId', $userId)->exists());
        
        return $userId;
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
        
        return redirect()->route('rentals.statistics');
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

    public function showRegisterForm()
    {
        return view('admin.adminregister');
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'username' => 'required|string|unique:user,username',
            'password' => 'required|string|min:8|max:255',
            'confirmPassword' => 'required|string|min:8|max:255|same:password'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            $userId = $this->generateUniqueUserId();
            
            if ($request->file('image')) {
                $image = $request->file('image');
                $imageName = time() . "." . $image->getClientOriginalExtension();
                $image->move('images/users/', $imageName);
                $data['image'] = $imageName;
            } else {
                $data['image'] = 'default.jpg';
            }

            UserModel::create([
                'userId' => $userId,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'image' => $data['image'] ?? 'default.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'isDeleted' => false,
                'roleId' => 1
            ]);

            return redirect()->route('admin.login')
                ->with('success', 'Admin registered successfully. Please login.');
        } catch (\Exception $e) {
            \Log::error('Admin registration failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
