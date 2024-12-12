<?php

namespace App\Domain\Admin;	

class Admin
{
    private ?int $id;
    private ?string $userId;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $username;
    private ?string $password;
    private ?string $api_token;
    private ?string $created_at;
    private ?string $updated_at;
    private ?int $roleId;

    public function __construct(
        ?int $id = null,
        ?string $userId = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $username = null,
        ?string $password = null,
        ?string $api_token = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?int $roleId = null
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
        $this->api_token = $api_token;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->roleId = $roleId;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'username' => $this->username,
            'password' => $this->password,
            'api_token' => $this->api_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roleId' => $this->roleId,
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUserId(): ?string
    {
        return $this->userId;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getApiToken(): ?string
    {
        return $this->api_token;
    }
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }
}