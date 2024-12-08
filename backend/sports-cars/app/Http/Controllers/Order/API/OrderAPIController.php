<?php

namespace App\Http\Controllers\Order\API;

use App\Http\Controllers\Controller;
use App\Application\Order\RegisterOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;

class OrderAPIController extends Controller
{
    private RegisterOrder $registerOrder;

    public function __construct(RegisterOrder $registerOrder)
    {
        $this->registerOrder = $registerOrder;
    }

    public function getAll(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        try {
            $orderModels = $this->registerOrder->findAll();
            if (empty($orderModels)) {
                return response()->json(['message' => "No Orders found."], 404);
            }
            $orders = array_map(function($orderModel) {
                if (is_object($orderModel) && method_exists($orderModel, 'toArray')) {
                    return $orderModel->toArray();
                }
                return $orderModel;
            }, $orderModels);
            return response()->json(compact('orders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getByOrderId(string $orderId)
    {
        $orderModel = $this->registerOrder->findByOrderId($orderId);
        if (!$orderModel) {
            return response()->json(['message' => 'Order not found', 'id' => $orderId], 404);
        }
        $order = $orderModel->toArray();
        return response()->json(compact('order'), 200);
    }

    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }

    private function generateUniqueOrderID(): string
    {
        do {
            $orderId = $this->generateRandomAlphanumericID(15);
        } while ($this->registerOrder->findByOrderId($orderId));
        return $orderId;
    }
    public function getByOrderedCar(string $orderedCar, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $orderModels = $this->registerOrder->findByOrderedCar($orderedCar);
            if (empty($orderModels)) {
                return response()->json(['message' => "No Orders found."], 404);
            }
            $orders = array_map(function($orderModel) {
                if (is_object($orderModel) && method_exists($orderModel, 'toArray')) {
                    return $orderModel->toArray();
                }
                return $orderModel;
            }, $orderModels);
            return response()->json(compact('orders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function createOrder(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'orderedCar' => 'required|string|max:50',
            'orderedBy' => 'required|string|max:50',
            'address' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 400);
        }
        if ($request->file('image')) {
            // Get the image from the request.
            $image = $request->file('image');
            $destinationPath = 'images';

            // Renaming the image with the time of upload.
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);

            // the image name will be saved on database.
            $data['image'] = $imageName;
        } else {
            // if there is no image, the default image will be saved on database.
            $data['image'] = 'default.jpg';
        }

        // Fetch the sports car details
        $sportsCar = SportsCarModel::where('sportsCarId', $request->orderedCar)->first();
        if (!$sportsCar) {
            return response()->json(['message' => 'SportsCar not found'], 404);
        }

        // Fetch the user details
        $user = UserModel::where('userId', $request->orderedBy)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Set orderedCar as brand and model
        $data['orderedCar'] = $sportsCar->brand . ' ' . $sportsCar->model;

        // Set orderedBy as first name and last name
        $data['orderedBy'] = $user->firstName . ' ' . $user->lastName;

        // Set address as user's address
        $data['address'] = $user->address;

        // Set orderedImage as sports car's image
        $data['image'] = $sportsCar->image;

        // Set initial status for the order
        $data['status'] = 'pending';

        $orderId = $this->generateUniqueOrderID();
        $this->registerOrder->createOrder(
            $orderId,
            $data['orderedCar'],
            $data['orderedBy'],
            $data['address'],
            $data['status'],
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );

        return response()->json(['message' => 'Order created successfully', 'orderId' => $orderId], 201);
    }

    public function updateOrder(Request $request, string $orderId)
    {
        $order = $this->registerOrder->findByOrderId($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found', 'id' => $orderId], 404);
        }

        $validate = Validator::make($request->all(), [
            'orderedCar' => 'required|string|max:50',
            'orderedBy' => 'required|string|max:50',
            'address' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 400);
        }

        $data = $request->all();

        if ($request->file('image')) {
            // Delete old image if it's not the default image
            if ($order->getOrderedImage() !== 'default.jpg') {
                File::delete('images/' . $order->getOrderedImage());
            }
            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        // Fetch the sports car details
        $sportsCar = SportsCarModel::where('sportsCarId', $request->orderedCar)->first();
        if (!$sportsCar) {
            return response()->json(['message' => 'SportsCar not found'], 404);
        }

        // Fetch the user details  
        $user = UserModel::where('userId', $request->orderedBy)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Set orderedCar as brand and model
        $data['orderedCar'] = $sportsCar->brand . ' ' . $sportsCar->model;

        // Set orderedBy as first name and last name
        $data['orderedBy'] = $user->firstName . ' ' . $user->lastName;

        // Set address as user's address
        $data['address'] = $user->address;

        // Set orderedImage as sports car's image
        $data['image'] = $sportsCar->image;

        // Update status if provided in the request
        if ($request->has('status')) {
            $data['status'] = $request->input('status');
        }

        $this->registerOrder->updateOrder(
            $orderId,
            $data['orderedCar'], 
            $data['orderedBy'],
            $data['address'],
            $data['status'],
            $data['image'],
            Carbon::now()->toDateTimeString()
        );
        return response()->json(['message' => 'Order updated successfully'], 200);
    }

    public function deleteOrder(int $id)
    {
        try {
            $this->registerOrder->deleteOrder($id);
            return response()->json(['message' => 'Order deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function restoreOrder(int $id)
    {
        try {
            $this->registerOrder->restoreOrder($id);
            return response()->json(['message' => 'Order restored successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function searchOrder(string $search)
    {
        try {
            $orders = $this->registerOrder->searchOrder($search);
            return response()->json(compact('orders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getDeletedOrders()
    {
        try {
            $orders = $this->registerOrder->findDeletedOrder();
            return response()->json(compact('orders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function approveOrder(string $orderId)
    {
        $order = $this->registerOrder->findByOrderId($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found', 'id' => $orderId], 404);
        }

        // Update the order status to approved
        $this->registerOrder->updateOrderStatus($orderId, 'approved');

        return response()->json(['message' => 'Order approved successfully'], 200);
    }

    public function getApprovedOrders(Request $request)
    {
        try {
            $approvedOrders = $this->registerOrder->findByStatus('approved');
            return response()->json(compact('approvedOrders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getPendingOrders(Request $request)
    {
        try {
            $pendingOrders = $this->registerOrder->findByStatus('pending');
            return response()->json(compact('pendingOrders'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
