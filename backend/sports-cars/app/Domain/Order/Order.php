<?php

namespace App\Domain\Order;

class Order
{
    private ?int $id;
    private ?string $orderId;
    private ?string $orderedCar;
    private ?string $orderedBy;
    private ?string $address;
    private ?string $status;
    private ?string $orderedImage;
    private ?string $created_at ;
    private ?string $updated_at;
    private ?bool $isDeleted;

    public function __construct(
        ?int $id = null,
        ?string $orderId = null,
        ?string $orderedCar = null,
        ?string $orderedBy = null,
        ?string $address = null,
        ?string $status = null,
        ?string $orderedImage = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?bool $isDeleted = null
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->orderedCar = $orderedCar;
        $this->orderedBy = $orderedBy;
        $this->address = $address;
        $this->status = $status;
        $this->orderedImage = $orderedImage;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->isDeleted = $isDeleted;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'orderId' => $this->orderId,
            'orderedCar' => $this->orderedCar,
            'orderedBy' => $this->orderedBy,
            'address' => $this->address,
            'status' => $this->status,
            'orderedImage' => $this->orderedImage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'isDeleted' => $this->isDeleted,
        ];
    }

    // Getters for each property
    public function getId() {
        return $this->id;
    }
    public function getOrderId() {
        return $this->orderId;
    }
    public function getOrderedBy() {
        return $this->orderedBy;
    }
    public function getOrderedCar() {
        return $this->orderedCar;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getOrderedImage() {
        return $this->orderedImage;
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
