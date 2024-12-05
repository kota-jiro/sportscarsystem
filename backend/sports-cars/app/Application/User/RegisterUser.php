<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;

class RegisterUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function findAll(){
        return $this->userRepository->findAll();
    }
    public function findById(int $id){
        return $this->userRepository->findById($id);
    }
    public function findByUserId(string $userId){
        return $this->userRepository->findByUserId($userId);
    }
    public function findByEmail(string $email){
        return $this->userRepository->findByEmail($email);
    }
    public function findByPassword(string $password){
        return $this->userRepository->findByPassword($password);
    }
    public function createUser(
        string $userId,
        string $firstName,
        string $lastName,
        string $phone,
        string $address,
        string $email,
        string $password,
        string $image,
        string $created_at,
        string $updated_at,
        bool $isDeleted = false,
    ){
        $data = new User(
            null,
            $userId,
            $firstName,
            $lastName,
            $phone,
            $address,
            $email,
            $password,
            $image,
            $created_at,
            $updated_at,
            $isDeleted,
        );
        $this->userRepository->createUser($data);
    }
    public function updateUser(
        string $userId,
        string $firstName,
        string $lastName,
        string $phone,
        string $address,
        string $email,
        string $password,
        string $image,
        string $updated_at,
    ){
        $validate = $this->userRepository->findByUserId($userId);

        if(!$validate){
            throw new \Exception("User not found");
        }

        $updateUser = new User(
            null,
            $userId,
            $firstName,
            $lastName,
            $phone,
            $address,
            $email,
            $password,
            $image,
            null,
            $updated_at,
        );
        $this->userRepository->updateUser($updateUser);
    }
    public function deleteUser(int $id){
        return $this->userRepository->deleteUser($id);
    }
    public function findDeletedUser(){
        return $this->userRepository->findDeletedUser();
    }
    public function restoreUser(int $id){
        return $this->userRepository->restoreUser($id);
    }
    public function searchUser(string $search){
        $results = $this->userRepository->searchUser($search);
        
        return [
            'exact_match'=> $results['exact_match'] ? $results['exact_match']->toArray() : null,
            'related_match'=> array_map(function($user){
                return $user->toArray();
            }, $results['related_match'] ?? [])
        ];
    }
}
