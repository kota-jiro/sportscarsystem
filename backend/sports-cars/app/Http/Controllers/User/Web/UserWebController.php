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
     * generate unique sports car id
     */
    private function generateUniqueSportsCarID(): string
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
        $emailFilter = $request->input('email');
        $query = UserModel::where('isDeleted', false);

        if ($emailFilter) {
            $query->where('email', $emailFilter);
        }

        $users = $query->get();
        $userCount = $users->count();
        $totalEmails = UserModel::where('isDeleted', false)->distinct('email')->count();
        $emails = UserModel::where('isDeleted', false)->distinct('email')->pluck('email');
        return view('users.index', compact('users', 'userCount', 'totalEmails', 'emails', 'emailFilter'));
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
            'phone' => 'required|string|digits:11|unique:user,phone',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
        ], [
            'phone' => 'The phone number must be exactly 11 digits.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $userId = $this->generateUniqueSportsCarID();
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
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:20',
            'confirmPassword' => 'required|string|min:8|max:20|same:password',
            'image' => 'nullable',
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
            $user->getEmail(),
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
        $emailFilter = $request->input('email');
        $query = UserModel::where('isDeleted', true);

        if ($emailFilter) {
            $query->where('email', $emailFilter);
        }

        $deletedUsers = $query->get();
        $totalArchived = $deletedUsers->count();
        $totalEmails = UserModel::where('isDeleted', true)->distinct('email')->count();
        $emails = UserModel::where('isDeleted', true)->distinct('email')->pluck('email');

        return view('users.archive', compact('deletedUsers', 'totalArchived', 'totalEmails', 'emails', 'emailFilter'));
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
}
