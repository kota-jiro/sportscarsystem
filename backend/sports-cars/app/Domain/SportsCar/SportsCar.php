<?php

namespace App\Domain\SportsCar;

class SportsCar {
    private ?int $id;
    private ?string $sportsCarId;
    private ?string $brand;
    private ?string $model;
    private ?int $year;
    private ?string $description;
    private ?string $speed;
    private ?string $drivetrain;
    private ?float $price;
    private ?string $image;
    private ?string $created_at;
    private ?string $updated_at;
    private ?bool $isDeleted;
    
    public function __construct(
        ?int $id = null,
        ?string $sportsCarId = null,
        ?string $brand = null,
        ?string $model = null,
        ?int $year = null,
        ?string $description = null,
        ?string $speed = null,
        ?string $drivetrain = null,
        ?float $price = null,
        ?string $image = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?bool $isDeleted = false,
    ){
        $this->id = $id;
        $this->sportsCarId = $sportsCarId;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->description = $description;
        $this->speed = $speed;
        $this->drivetrain = $drivetrain;
        $this->price = $price;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->isDeleted = $isDeleted;
    }
    public function toArray() {
        return [
            'id' => $this->id,
            'sportsCarId' => $this->sportsCarId,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'description' => $this->description,
            'speed' => $this->speed,
            'drivetrain' => $this->drivetrain,
            'price' => $this->price,
            'image' => $this->image,    
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'isDeleted' => $this->isDeleted,
        ];
    }
    public function getId() {
        return $this->id;
    }
    public function getSportsCarId() {
        return $this->sportsCarId;
    }
    public function getBrand() {
        return $this->brand;
    }
    public function getModel() {
        return $this->model;
    }   
    public function getYear() {
        return $this->year;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getSpeed() {
        return $this->speed;
    }
    public function getDrivetrain() {
        return $this->drivetrain;
    }
    public function getPrice() {
        return $this->price;
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