<?php

namespace App\Infrastructure\Persistence\Eloquent\User;

use App\Domain\User\UserRepository;
use App\Domain\User\User;

class EloquentUserRepository implements UserRepository {
    public function findAll(): array {
        return UserModel::all()->toArray();
    }
    public function findById(int $id): ?User {
        $user = UserModel::find($id);
        if(!$user) {
            return null;
        }
        return new User(
            $user->id,
            $user->userId,
            $user->firstName,
            $user->lastName,
            $user->phone,
            $user->address,
            $user->email,
            $user->password,
            $user->image,
            $user->created_at,
            $user->updated_at,
        );
    }
    public function findByUserId(string $userId): ?User {
        $user = UserModel::where('userId', $userId)->first();
        if(!$user) {
            return null;
        }
        return new User(
            $user->id,
            $user->userId,
            $user->firstName,
            $user->lastName,
            $user->phone,
            $user->address,
            $user->email,
            $user->password,
            $user->image,
            $user->created_at,
            $user->updated_at,
        );
    }
    public function findByEmail(string $email): array {
        return UserModel::where('email', $email)->get()->toArray();
    }
    public function findByPassword(string $password): array {
        return UserModel::where('password', $password)->get()->toArray();
    }
    public function createUser(User $user): void {
        $userModel = UserModel::find($user->getId()) ?? new UserModel();
        $userModel->fill([
            'id' => $user->getId(),
            'userId' => $user->getUserId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
            'address' => $user->getAddress(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'image' => $user->getImage(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ]);
        $userModel->save();
    }
    public function updateUser(User $user): void {
        $existingUser = UserModel::where('userId', $user->getUserId())->first();
        if($existingUser) {
            $existingUser->update([
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'phone' => $user->getPhone(),
                'address' => $user->getAddress(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'image' => $user->getImage(),
                'updated_at' => $user->getUpdatedAt(),
            ]);
        }
    }
    public function deleteUser(int $id): void {
        $userExist = UserModel::find($id);
        $userExist->isDeleted = true;
        $userExist->save();
    }
    public function findDeletedUser(): array {
        $user = UserModel::where('isDeleted', true)->get();
        return [
            'user' => $user,
        ];
    }
    public function restoreUser(int $id): void {
        $userExist = UserModel::find($id);
        $userExist->isDeleted = false;
        $userExist->save();
    }
    public function searchUser(string $search): array {
        $exact_match = UserModel::where('userId', $search)
        ->orWhere('firstName', $search)
        ->orWhere('lastName', $search)
        ->orWhere('phone', $search)
        ->orWhere('address', $search)
        ->orWhere('email', $search)
        ->first();

        $related_match = UserModel::where('userId', '!=', $exact_match->userId)->where(
            function ($query) use ($search) {
                $query->where('userId', 'LIKE', "%{$search}%")
                ->orWhere('firstName', 'LIKE', "%{$search}%")
                ->orWhere('lastName', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            }
        )->get();

        return [
            'exact_match' => $exact_match ? new User(
                $exact_match->id,
                $exact_match->userId,
                $exact_match->firstName,
                $exact_match->lastName,
                $exact_match->phone,
                $exact_match->address,
                $exact_match->email,
                $exact_match->password,
                $exact_match->image,
                $exact_match->created_at,
                $exact_match->updated_at,
            ) : null,
            'related_match' => $related_match->map(function ($user) {
                return new User(
                    $user->id,
                    $user->userId,
                    $user->firstName,
                    $user->lastName,
                    $user->phone,
                    $user->address,
                    $user->email,
                    $user->password,
                    $user->image,
                    $user->created_at,
                    $user->updated_at,
                );
            })->toArray()
        ];
    }
}
