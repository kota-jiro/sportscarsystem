<?php

namespace App\Infrastructure\Persistence\Eloquent\Admin;

use App\Domain\Admin\AdminRepository;
use App\Domain\Admin\Admin;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminModel;

class EloquentAdminRepository implements AdminRepository
{
    public function findAll(): array
    {
        return AdminModel::all()->toArray();
    }
    public function findById(int $id): ?Admin
    {
        $admin = AdminModel::find($id);
        if (! $admin) {
            return null;
        }
        return new Admin(
            $admin->id, 
            $admin->firstName, 
            $admin->lastName, 
            $admin->username, 
            $admin->password, 
            $admin->api_token, 
            $admin->created_at, 
            $admin->updated_at
        );
    }
    public function findByUsername(string $username): ?Admin
    {
        $admin = AdminModel::where('username', $username)->first();
        if (! $admin) {
            return null;
        }
        return new Admin(
            $admin->id, 
            $admin->firstName, 
            $admin->lastName, 
            $admin->username, 
            $admin->password, 
            $admin->api_token, 
            $admin->created_at, 
            $admin->updated_at
        );
    }
    public function register(Admin $admin): Admin
    {
        $adminModel = new AdminModel();
        $adminModel->firstName = $admin->getFirstName();
        $adminModel->lastName = $admin->getLastName();
        $adminModel->username = $admin->getUsername();
        $adminModel->password = $admin->getPassword();
        $adminModel->save();
        
        $token = $adminModel->createToken('admin_token')->plainTextToken;
        return new Admin(
            $adminModel->id, 
            $adminModel->firstName, 
            $adminModel->lastName, 
            $adminModel->username, 
            $adminModel->password, 
            $token, 
            $adminModel->created_at, 
            $adminModel->updated_at
        );
    }
    public function update(Admin $admin): Admin
    {
        $adminModel = AdminModel::find($admin->getId());
        $adminModel->firstName = $admin->getFirstName();
        $adminModel->lastName = $admin->getLastName();
        $adminModel->username = $admin->getUsername();
        $adminModel->password = $admin->getPassword();
        $adminModel->save();
        return $admin;
    }
    public function delete(int $id): void
    {
        AdminModel::destroy($id);
    }
    public function login(string $username, string $password): ?Admin
    {
        $admin = AdminModel::where('username', $username)->where('password', $password)->first();
        if (! $admin) {
            return null;
        }
        $token = $admin->createToken('admin_token')->plainTextToken;
        return new Admin(
            $admin->id, 
            $admin->firstName, 
            $admin->lastName, 
            $admin->username, 
            $admin->password, 
            $token, 
            $admin->created_at, 
            $admin->updated_at);
    }
    public function addApiToken(int $id, string $api_token): void
    {
        AdminModel::where('id', $id)->update([ 'api_token' => $api_token ]);
    }
    public function updateApiToken(int $id, string $api_token): void
    {
        AdminModel::where('id', $id)->update([ 'api_token' => $api_token ]);
    }
    public function findByApiToken(string $api_token): ?Admin
    {
        $admin = AdminModel::where('api_token', $api_token)->first();
        if (! $admin) {
            return null;
        }
        return new Admin($admin->id, $admin->firstName, $admin->lastName, $admin->username, $admin->password, $admin->api_token, $admin->created_at, $admin->updated_at);
    }
    public function findByPassword(string $password): ?Admin
    {
        $admin = AdminModel::where('password', $password)->first();
        if (! $admin) {
            return null;
        }
        return new Admin($admin->id, $admin->firstName, $admin->lastName, $admin->username, $admin->password, $admin->api_token, $admin->created_at, $admin->updated_at);
    }
    public function findByUserId(string $userId): ?Admin
    {
        $admin = AdminModel::where('userId', $userId)->first();
        if (! $admin) {
            return null;
        }
        return new Admin($admin->id, $admin->firstName, $admin->lastName, $admin->username, $admin->password, $admin->api_token, $admin->created_at, $admin->updated_at);
    }
}