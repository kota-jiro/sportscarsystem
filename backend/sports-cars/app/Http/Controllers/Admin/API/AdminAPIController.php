<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Application\Admin\RegisterAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AdminAPIController extends Controller
{
    private RegisterAdmin $registerAdmin;
    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:admins',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $admin = $this->registerAdmin->register(new Admin(
            $request->name,
            $request->username,
            $request->password
        ));
        return response()->json($admin);
    }
    public function login(Request $request)
    {
        $admin = $this->registerAdmin->login($request->email, $request->password);
        if (!$admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($admin);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
