<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use App\Application\User\RegisterUser;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserWebController extends Controller
{
    private RegisterUser $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }
    /**
     * generate random alphanumeric id
     */
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
        } while ($this->registerUser->findByUserId($userId));

        return $userId;
    }
    public function getUser()
    {
        $users = $this->registerUser->findAll();
        if (empty($users)) {
            return [];
        }

        if (is_array($users)) {
            return $users;
        }

        return $users->toArray();
    }
    /**
     * display a listing of the users.
     */
    public function index(Request $request)
    {
        $roleFilter = $request->input('roleId');
        $query = UserModel::where('isDeleted', false);

        if ($roleFilter) {
            $query->where('roleId', $roleFilter);
        }

        $users = $query->get();
        $userCount = $users->count();
        $totalRoles = UserModel::where('isDeleted', false)->distinct('roleId')->count();
        $roles = UserModel::where('isDeleted', false)->distinct('roleId')->pluck('roleId');
        return view('users.index', compact('users', 'userCount', 'totalRoles', 'roles', 'roleFilter'));
    }
    /**
     * show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }
    /**
     * store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'phone' => 'nullable|string|max:11',
            'address' => 'nullable|string|max:255',
            'email' => 'required|string|email|unique:user,email',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
            'roleId' => 'nullable|integer|in:0,1'
        ], [
            'phone' => 'The phone number must be exactly 11 digits.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $userId = $this->generateUniqueUserID();
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images/users/', $imageName);

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
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    /**
     * display the specified user.
     */
    public function show($id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }

        return view('users.showById', compact('user'));
    }
    /**
     * display all users.
     */
    public function showAll()
    {
        $users = UserModel::where('isDeleted', false)->get();
        return view('users.show', compact('users'));
    }
    /**
     * show the form for editing the specified user.
     */
    public function edit($userId)
    {
        $user = UserModel::find($userId);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
        return view('users.edit', compact('user'));
    }
    /**
     * update the specified user in storage.
     */
    public function update(Request $request, $userId)
    {
        $user = $this->registerUser->findByUserId($userId);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }

        $data = $request->all();
        $validate = Validator::make($data, [
            'firstName' => 'required|string|max:25',
            'lastName' => 'required|string|max:25',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
            'roleId' => 'nullable|integer|in:0,1'
        ], [
            'phone' => 'The phone number must be exactly 11 digits.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->hasFile('image')) {
            if ($user->getImage() !== 'default.jpg') {
                File::delete('images/' . $user->getImage());
            }
            $image = $request->file('image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images/users/', $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = $user->getImage();
        }

        $this->registerUser->updateUser(
            $userId,
            $request->firstName,
            $request->lastName,
            $user->getPhone(),
            $request->address,
            $user->getUsername(),
            $request->password,
            $data['image'],
            Carbon::now()->toDateTimeString()
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    /**
     * remove the specified user from storage.
     */
    public function destroy($id)
    {
        $this->registerUser->deleteUser($id);
        return redirect()->route('users.index')->with('archive', 'User archived successfully');
    }
    /**
     * display all archived users.
     */
    public function archive(Request $request)
    {
        $roleFilter = $request->input('roleId');
        $query = UserModel::where('isDeleted', true);

        if ($roleFilter) {
            $query->where('roleId', $roleFilter);
        }

        $deletedUsers = $query->get();
        $totalArchived = $deletedUsers->count();
        $totalRoles = UserModel::where('isDeleted', true)->distinct('roleId')->count();
        $roles = UserModel::where('isDeleted', true)->distinct('roleId')->pluck('roleId');

        return view('users.archive', compact('deletedUsers', 'totalArchived', 'totalRoles', 'roles', 'roleFilter'));
    }
    /**
     * restore the specified user from archive.
     */
    public function restore($id)
    {
        $user = UserModel::find($id);
        $user->isDeleted = false;
        $user->save();

        return redirect()->route('users.archive')->with('restore', 'User restored successfully');
    }
    /**
     * permanently delete the specified user from storage.
     */
    public function permanentDelete($id)
    {
        $user = UserModel::find($id);

        if ($user) {
            // Delete the image file if it's not the default image
            if ($user->image !== 'default.jpg') {
                File::delete(public_path('images/' . $user->image));
            }

            // Permanently delete the car record
            $user->delete();
        }

        return redirect()->route('users.archive')->with('success', 'User permanently deleted successfully');
    }
    public function showLoginForm()
    {
        return view('users.login.userlogin');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $user = UserModel::where('email', $credentials['email'])->first();

        if (!$user || $user->password !== $credentials['password']) {
            return redirect()->back()->with('error', 'Invalid email or password')->withInput();
        }

        session(['user' => $user]);
        
        return redirect()->route('sportsCars.index');
    }
}
