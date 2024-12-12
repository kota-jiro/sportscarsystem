<?php

namespace App\Http\Controllers\User\API;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Infrastructure\Persistence\Eloquent\CarBrand\CarBrandModel;
use App\Infrastructure\Persistence\Eloquent\Order\OrderModel;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;

class UserAPIController extends Controller
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }
    /**
     * get all users
     */
    public function getAll(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $userModels = $this->registerUser->findAll();
            if (empty($userModels)) {
                return response()->json(['message' => "No Users found."], 404);
            }
            $users = array_map(function($userModel) {
                if (is_object($userModel) && method_exists($userModel, 'toArray')) {
                    return $userModel->toArray();
                }
                return $userModel; // or handle the error as needed
            }, $userModels);
            return response()->json(compact('users'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * get user by id
     */
    public function getByUserId(string $userId)
    {
        $userModel = $this->registerUser->findByUserId($userId);
        if (!$userModel) {
            return response()->json(['message' => 'User not found', 'id' => $userId], 404);
        }
        $user = $userModel->toArray();
        return response()->json(compact('user'), 200);
    }
    /**
     * generate random alphanumeric id
     */
    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }
    /**
     * generate unique sports car id
     */
    private function generateUniqueSportsCarID(): string
    {
        do {
            $userId = $this->generateRandomAlphanumericID(15);
        } while ($this->registerUser->findByUserId($userId));
        return $userId;
    }
    /**
     * get user by email
     */
    public function getByUsername(string $username, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $userModel = $this->registerUser->findByUsername($username);
            if (empty($userModel)) {
                return response()->json(['message' => 'User not found', 'username' => $username], 404);
            }
            $user = array_map(function($userModel) {
                if (is_object($userModel) && method_exists($userModel, 'toArray')) {
                    return $userModel->toArray();
                }
                return $userModel; // or handle the error as needed
            }, $userModel);
            return response()->json(compact('user'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * login a user
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 422);
        }

        // First find the user by username
        $user = UserModel::where('username', $data['username'])->first();

        if (!$user) {
            \Log::info('No user found:', ['username' => $data['username']]);
            return response()->json(['error' => 'Invalid username or password'], 401);
        }

        // Add debug logging
        \Log::info('User found:', [
            'username' => $user->username,
            'roleId' => $user->roleId,
            'roleIdType' => gettype($user->roleId)
        ]);

        // Check if user is a regular user (roleId = 0)
        if ($user->roleId != 0) {
            \Log::info('Unauthorized access attempt - not a regular user:', [
                'username' => $data['username'],
                'roleId' => $user->roleId
            ]);
            return response()->json(['error' => 'Unauthorized access. Only users can login here.'], 403);
        }

        // Verify password
        if (!Hash::check($data['password'], $user->password)) {
            \Log::info('Password verification failed for user:', ['username' => $data['username']]);
            return response()->json(['error' => 'Invalid username or password'], 401);
        }

        // Convert user model to array and remove sensitive data
        $userData = $user->toArray();
        unset($userData['password']);
        
        return response()->json([
            'user' => $userData,
            'message' => 'Login successful'
        ], 200);
    }
    /**
     * add a user
     */
    public function addUser(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'phone' => 'nullable|string|max:11',
            'address' => 'nullable|string|max:255',
            'username' => 'required|string|unique:user,username',
            'password' => 'required|string|min:8|max:255',
            'confirmPassword' => 'required|string|min:8|max:255|same:password',
            'image' => 'nullable',
            'roleId' => 'nullable|integer|in:0,1'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $userId = $this->generateUniqueSportsCarID();
        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'images';

            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $hashedPassword = Hash::make($request->password);

        $this->registerUser->createUser(
            $userId,
            $request->firstName,
            $request->lastName,
            $request->phone,
            $request->address,
            $request->username,
            $hashedPassword,
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString(),
        );
        return response()->json(['message' => 'User created successfully'], 201);
    }
    /**
     * update a user
     */
    public function updateUser(Request $request, string $userId)
    {
        try {
            $user = $this->registerUser->findByUserId($userId);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $validate = Validator::make($request->all(), [
                'firstName' => 'nullable|string|max:25',
                'lastName' => 'nullable|string|max:25',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:11',
                'password' => 'nullable|string|min:8|max:255',
                'confirmPassword' => 'nullable|string|min:8|max:255|same:password',
                'image' => 'nullable',
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()], 422);
            }

            if ($request->hasFile('image')) {
                // Delete old image if it exists and is not default
                if ($user->getImage() !== 'default.jpg') {
                    File::delete(public_path('images/users/' . $user->getImage()));
                }
                
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/users/'), $imageName);
                $imageUrl = $imageName;
            } else {
                $imageUrl = $user->getImage();
            }

            $hashedPassword = Hash::make($request->password);

            $this->registerUser->updateUser(
                $userId,
                $request->firstName ?? $user->getFirstName(),
                $request->lastName ?? $user->getLastName(),
                $request->phone ?? $user->getPhone(),
                $request->address ?? $user->getAddress(),
                $user->getUsername(),
                $hashedPassword,
                $imageUrl,
                Carbon::now()->toDateTimeString()
            );

            return response()->json([
                'message' => 'User updated successfully',
                'image' => $imageUrl
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * search a user
     */
    public function searchUser(Request $request)
    {
        $search = $request->input('searched');
        if (!$search) {
            return null;
        }
        $result = $this->registerUser->searchUser($search);
        if (is_null($result['exact_match'] && empty($result['related_match']))) {
            return response()->json(['message' => 'No data found.'], 404);
        }
        return response()->json(compact('result'));
    }
    /**
     * add a admin
     */
    public function addAdmin(Request $request)
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
        $userId = $this->generateUniqueSportsCarID();
        if ($request->file('image')) {
            $image = $request->file('image');
            $destinationPath = 'images';

            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $hashedPassword = Hash::make($request->password);

        $this->registerUser->createUser(
            $userId,
            $request->firstName,
            $request->lastName,
            $request->phone,
            $request->address,
            $request->username,
            $hashedPassword,
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString(),
            1
        );
        return response()->json(['message' => 'User created successfully'], 201);
    }
    /**
     * get stats
     */
    public function getStats()
    {
        try {
            $totalUsers = UserModel::where('roleId', 0)->count();
            $totalCarBrands = SportsCarModel::count(); // You'll need to create this model
            $totalOrders = OrderModel::where('status', 'completed')->count(); // You'll need to create this model
            $totalSportsCars = SportsCarModel::count(); // You'll need to create this model

            return response()->json([
                'totalCarBrands' => $totalCarBrands,
                'totalOrders' => $totalOrders,
                'totalUsers' => $totalUsers,
                'totalSportsCars' => $totalSportsCars
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
