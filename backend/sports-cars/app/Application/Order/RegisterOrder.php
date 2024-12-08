<?php

namespace App\Application\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepository;

class RegisterOrder
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function findAll() 
    {
        return $this->orderRepository->findAll();
    }
    public function findById(int $id)
    {
        return $this->orderRepository->findById($id);
    }
    public function findByOrderId(string $orderId)
    {
        return $this->orderRepository->findByOrderId($orderId);
    }
    public function findByOrderedCar(string $orderedCar)
    {
        return $this->orderRepository->findByOrderedCar($orderedCar);
    }
    public function findByOrderedBy(string $orderedBy)
    {
        return $this->orderRepository->findByOrderedBy($orderedBy);
    }
    public function createOrder(
        string $orderId,
        string $orderedCar,
        string $orderedBy,
        string $address,
        string $status,
        string $orderedImage,
        string $created_at,
        string $updated_at,
    )
    {
        $data = new Order(
            null,
            $orderId,
            $orderedCar,
            $orderedBy,
            $address,
            $status,
            $orderedImage,
            $created_at,
            $updated_at,
        );
        $this->orderRepository->createOrder($data);
    }
    public function updateOrder(
        string $orderId,
        string $orderedCar,
        string $orderedBy,
        string $address,
        string $status,
        string $orderedImage,
        string $updated_at,
    )
    {
        $validate = $this->orderRepository->findByOrderId($orderId);
        if(!$validate){
            throw new \Exception("Order not found");
        }
        $updateOrder = new Order(
            null,
            $orderId,
            $orderedCar,
            $orderedBy,
            $address,
            $status,
            $orderedImage,
            null,
            $updated_at,
        );
        $this->orderRepository->updateOrder($updateOrder);
    }
    public function deleteOrder(int $id)
    {
        $this->orderRepository->deleteOrder($id);
    }
    public function findDeletedOrder()
    {
        return $this->orderRepository->findDeletedOrder();
    }
    public function restoreOrder(int $id)
    {
        $this->orderRepository->restoreOrder($id);
    }
    public function searchOrder(string $search)
    {
        $results = $this->orderRepository->searchOrder($search);
        return [
            'exact_match'=> $results['exact_match'] ? $results['exact_match']->toArray() : null,
            'related_match'=> array_map(function($order){
                return $order->toArray();
            }, $results['related_match'] ?? [])
        ];
    }
    public function updateOrderStatus(string $orderId, string $status)
    {
        $this->orderRepository->updateOrderStatus($orderId, $status);
    }
    public function findByStatus(string $status)
    {
        return $this->orderRepository->findByStatus($status);
    }
}
