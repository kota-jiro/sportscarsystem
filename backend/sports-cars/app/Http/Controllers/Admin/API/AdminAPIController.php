<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Application\Admin\RegisterAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;

class AdminAPIController extends Controller
{
    private RegisterAdmin $registerAdmin;
    
    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'username' => 'required|string|unique:user,username',
            'password' => 'required|string|min:8|max:255',
            'confirmPassword' => 'required|string|min:8|max:255|same:password',
        ]);
    
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
    
        $userId = $this->generateUniqueUserId();
        
        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'images/users';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        try {
            $user = UserModel::create([
                'userId' => $userId,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'image' => $data['image'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'isDeleted' => false,
                'roleId' => 1 // Admin role
            ]);

            return response()->json([
                'message' => 'Admin registered successfully',
                'userId' => $user->userId
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to register admin',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = UserModel::where('username', $request->username)
                        ->where('roleId', 1)
                        ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'user' => $user,
            'message' => 'Login successful'
        ], 200);
    }

    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }

    private function generateUniqueUserId(): string
    {
        do {
            $userId = $this->generateRandomAlphanumericID(15);
        } while (UserModel::where('userId', $userId)->exists());
        
        return $userId;
    }
}
