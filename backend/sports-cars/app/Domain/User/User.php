<?php

namespace App\Domain\User;

class User {
    private ?int $id;
    private ?string $userId;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $phone;
    private ?string $address;
    private ?string $email;
    private ?string $password;
    private ?string $image;
    private ?string $created_at;
    private ?string $updated_at;
    private ?bool $isDeleted;

    public function __construct(
        ?int $id = null,
        ?string $userId = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?string $address = null,
        ?string $email = null,
        ?string $password = null,
        ?string $image = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?bool $isDeleted = false
    ){
        $this->id = $id;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->address = $address;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->isDeleted = $isDeleted;
    }
    public function toArray() {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'password' => $this->password,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'isDeleted' => $this->isDeleted,
        ];
    }
    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getImage() {
        return $this->image;
    }
    public function getCreatedAt() {
        return $this->created_at;
    }
    public function getUpdatedAt() {
        return $this->updated_at;
    }
    public function getIsDeleted() {
        return $this->isDeleted;
    }
}