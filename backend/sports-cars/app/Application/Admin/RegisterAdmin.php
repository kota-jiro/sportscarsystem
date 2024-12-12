<?php

namespace App\Application\Admin;

use App\Domain\Admin\Admin;
use App\Domain\Admin\AdminRepository;

class RegisterAdmin
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    public function findAll(): array
    {
        return $this->adminRepository->findAll();
    }
    public function findById(int $id): ?Admin
    {
        return $this->adminRepository->findById($id);
    }
    public function findByUsername(string $username): ?Admin
    {
        return $this->adminRepository->findByUsername($username);
    }
    public function register(Admin $admin): Admin
    {
        return $this->adminRepository->register($admin);
    }
    public function update(Admin $admin): Admin
    {
        return $this->adminRepository->update($admin);
    }
    public function delete(int $id): void
    {
        $this->adminRepository->delete($id);
    }
    public function login(string $username, string $password): ?Admin
    {
        return $this->adminRepository->login($username, $password);
    }
    public function addApiToken(int $id, string $api_token): void
    {
        $this->adminRepository->addApiToken($id, $api_token);
    }
    public function updateApiToken(int $id, string $api_token): void
    {
        $this->adminRepository->updateApiToken($id, $api_token);
    }
    public function api_token(string $api_token): ?Admin
    {
        return $this->adminRepository->findByApiToken($api_token);
    }
    public function password(string $password): ?Admin
    {
        return $this->adminRepository->findByPassword($password);
    }
    public function findByUserId(string $userId): ?Admin
    {
        return $this->adminRepository->findByUserId($userId);
    }
}