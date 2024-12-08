<?php

namespace App\Domain\Order;

interface OrderRepository
{
    public function findAll(): array;
    public function findById(int $id): ?Order;
    public function findByOrderId(string $orderId): ?Order;
    public function findByOrderedCar(string $orderedCar): array;
    public function findByOrderedBy(string $orderedBy): array;
    public function createOrder(Order $order): void;
    public function updateOrder(Order $order): void;
    public function deleteOrder(int $id): void;
    public function findDeletedOrder(): array;
    public function restoreOrder(int $id): void;
    public function searchOrder(string $search): array;
    public function updateOrderStatus(string $orderId, string $status): void;
    public function findByStatus(string $status): array;
}
