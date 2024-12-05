<?php

namespace App\Http\Controllers\User\API;

use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
    public function getByEmail(string $email, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $userModel = $this->registerUser->findByEmail($email);
            if (empty($userModel)) {
                return response()->json(['message' => 'User not found', 'email' => $email], 404);
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
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $users = $this->registerUser->findByEmail($data['email']);
        if (empty($users)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
        
        $passwordMatch = false;
        foreach ($users as $user) {
            if ($user['password'] === $data['password']) {
                $passwordMatch = true;
                break;
            }
        }
        
        if (!$passwordMatch) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
        
        return response()->json(compact('users'), 200);
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
            'phone' => 'required|string|digits:11|unique:user,phone',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
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

        $this->registerUser->createUser(
            $userId,
            $request->firstName,
            $request->lastName,
            $request->phone,
            $request->address,
            $request->email,
            $request->password,
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
        $user = $this->registerUser->findByUserId($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $validate = Validator::make($request->all(), [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
        ]);

        $data = $request->all();
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        if ($request->file('image')) {
            if ($user->getImage() !== 'default.jpg') {
                File::delete('images/' . $user->getImage());
            }
            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            if ($user->getImage() === null) {
                $data['image'] = 'default.jpg';
            } else {
                $data['image'] = $user->getImage();
            }
        }
        $this->registerUser->updateUser(
            $userId,
            $request->firstName,
            $request->lastName,
            $user->getPhone(),
            $request->address,
            $user->getEmail(),
            $request->password,
            $data['image'],
            Carbon::now()->toDateTimeString(),
        );
        return response()->json(['message' => 'User updated successfully'], 200);
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
}
