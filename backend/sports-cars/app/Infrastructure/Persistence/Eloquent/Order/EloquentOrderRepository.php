<?php

namespace App\Infrastructure\Persistence\Eloquent\Order;

use App\Domain\Order\OrderRepository;
use App\Domain\Order\Order;
use App\Infrastructure\Persistence\Eloquent\Order\OrderModel;

class EloquentOrderRepository implements OrderRepository
{
    public function findAll(): array {
        return OrderModel::all()->toArray();
    }
    public function findById(int $id): ?Order {
        $order = OrderModel::find($id);
        if (! $order) {
            return null;
        }
        return new Order(
            $order->id,
            $order->orderId,
            $order->orderedCar,
            $order->orderedBy,  
            $order->status,
            $order->address,
            $order->orderedImage,
            $order->created_at,
            $order->updated_at
        );
    }
    public function findByOrderId(string $orderId): ?Order {
        $order = OrderModel::where('orderId', $orderId)->first();
        if (! $order) {
            return null;
        }
        return new Order(
            $order->id,
            $order->orderId,
            $order->orderedCar,
            $order->orderedBy,
            $order->status,
            $order->address,
            $order->orderedImage,
            $order->created_at,
            $order->updated_at
        );
    }
    public function findByOrderedCar(string $orderedCar): array {
        return OrderModel::where('orderedCar', $orderedCar)->get()->toArray();
    }
    public function findByOrderedBy(string $orderedBy): array {
        return OrderModel::where('orderedBy', $orderedBy)->get()->toArray();
    }
    public function findByOrderedTo(string $orderedTo): array {
        return OrderModel::where('orderedTo', $orderedTo)->get()->toArray();
    }
    public function createOrder(Order $order): void {
        $orderModel = OrderModel::find($order->getId()) ?? new OrderModel();
        $orderModel->fill([
            'id' => $order->getId(),
            'orderId' => $order->getOrderId(),
            'orderedCar' => $order->getOrderedCar(),
            'orderedBy' => $order->getOrderedBy(),
            'status' => $order->getStatus(),
            'address' => $order->getAddress(),
            'orderedImage' => $order->getOrderedImage(),
            'created_at' => $order->getCreatedAt(),
            'updated_at' => $order->getUpdatedAt()
        ]);
        $orderModel->save();
    }
    public function updateOrder(Order $order): void {
        $existingOrder = OrderModel::where('orderId', $order->getOrderId())->first();
        if ($existingOrder) {
            $existingOrder->update([
                'orderedCar' => $order->getOrderedCar(),
                'orderedBy' => $order->getOrderedBy(),
                'status' => $order->getStatus(),
                'address' => $order->getAddress(),
                'orderedImage' => $order->getOrderedImage(),
                'updated_at' => $order->getUpdatedAt()
            ]);
        }
    }
    public function deleteOrder(int $id): void {
        $orderExist = OrderModel::find($id);
        $orderExist->isDeleted = true;
        $orderExist->save();
    }
    public function findDeletedOrder(): array
    {
        $order = OrderModel::where('isDeleted', true)->get();
        return [
            'order' => $order,
        ];
    }
    public function restoreOrder(int $id): void {
        $orderExist = OrderModel::find($id);
        $orderExist->isDeleted = false;
        $orderExist->save();
    }
    public function searchOrder(string $search): array {
        $exact_match = OrderModel::where('orderId', $search)
        ->orWhere('orderedCar', $search)
        ->orWhere('orderedBy', $search)
        ->first();
        
        $related_match = OrderModel::where('orderId', '!=', $exact_match->orderId)->where(
            function ($query) use ($search) {
            $query->where('orderId','LIKE',"%{$search}%")
            ->orWhere('orderedCar','LIKE',"%{$search}%")
            ->orWhere('orderedBy','LIKE',"%{$search}%");
            }
        )->get();
        return [
            'exact_match' => $exact_match ? new Order(
                $exact_match->id,
                $exact_match->orderId,
                $exact_match->orderedCar,
                $exact_match->orderedBy,
                $exact_match->status,
                $exact_match->address,
                $exact_match->orderedImage,
                $exact_match->created_at,
                $exact_match->updated_at
            ) : null,
            'related_match' => $related_match->map(function ($order) {
                return new Order(
                    $order->id,
                    $order->orderId,
                    $order->orderedCar,
                    $order->orderedBy,
                    $order->status,
                    $order->address,
                    $order->orderedImage,
                    $order->created_at,
                    $order->updated_at
                );
            })->toArray()
        ];
    }
    public function updateOrderStatus(string $orderId, string $status): void {

        $order = OrderModel::where('orderId', $orderId)->first();
        if ($order) {
            $order->status = $status;
            $order->save();
        }
    }
    public function findByStatus(string $status): array {
        return OrderModel::where('status', $status)->get()->toArray();
    }
}
