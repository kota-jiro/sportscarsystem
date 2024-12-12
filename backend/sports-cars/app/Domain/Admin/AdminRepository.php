<?php

namespace App\Domain\Admin;

interface AdminRepository
{
    public function findAll(): array;
    public function findById(int $id): ?Admin;
    public function findByUsername(string $username): ?Admin;
    public function register(Admin $admin): Admin;
    public function update(Admin $admin): Admin;
    public function delete(int $id): void;
    public function login(string $username, string $password): ?Admin;
    public function addApiToken(int $id, string $api_token): void;
    public function updateApiToken(int $id, string $api_token): void;
    public function findByApiToken(string $api_token): ?Admin;
    public function findByPassword(string $password): ?Admin;
    public function findByUserId(string $userId): ?Admin;
}