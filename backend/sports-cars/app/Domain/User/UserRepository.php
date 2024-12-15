<?php

namespace App\Domain\User;

interface UserRepository
{
    public function findAll(): array;
    public function findById(int $id): ?User;
    public function findByUserId(string $userId): ?User;
    public function findByUsername(string $username): array;
    public function findByPassword(string $password): array;
    public function createUser(User $user): void;
    public function updateUser(User $user): void;
    public function deleteUser(int $id): void;
    public function findDeletedUser(): array;
    public function restoreUser(int $id): void;
    public function searchUser(string $search): array;
}