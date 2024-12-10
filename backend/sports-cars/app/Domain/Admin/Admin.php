<?php

namespace App\Domain\Admin;	

class Admin
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $api_token;
    private $created_at;
    private $updated_at;

    public function __construct(
        ?int $id = null,
        string $name = null,
        string $email = null,
        string $password = null,
        string $api_token = null,
        string $created_at = null,
        string $updated_at = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->api_token = $api_token;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'api_token' => $this->api_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getApiToken(): string
    {
        return $this->api_token;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}