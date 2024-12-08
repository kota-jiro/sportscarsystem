<?php

namespace App\Http\Controllers\Order\Web;

use App\Http\Controllers\Controller;
use App\Application\Order\RegisterOrder;
use App\Infrastructure\Persistence\Eloquent\Order\OrderModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;

class OrderWebController extends Controller
{
    private RegisterOrder $registerOrder;

    public function __construct(RegisterOrder $registerOrder)
    {
        $this->registerOrder = $registerOrder;
    }
    /**
     * generate random alphanumeric id
     */
    private function generateRandomAlphanumericID(int $length = 15): string
    {
        return substr(bin2hex(random_bytes($length / 2)), 0, $length);
    }
    /**
     * generate unique sports car id
     */
    private function generateUniqueOrderID(): string
    {
        do {
            $orderId = $this->generateRandomAlphanumericID(15);
        } while ($this->registerOrder->findByOrderId($orderId));

        return $orderId;
    }
    public function getOrder()
    {
        $orders = $this->registerOrder->findAll();
        if (empty($orders)) {
            return [];
        }

        if (is_array($orders)) {
            return $orders;
        }

        return $orders->toArray();
    }
    public function index(Request $request)
    {
        $orderedByFilter = $request->input('orderedBy');
        $query = OrderModel::where('isDeleted', false);

        if ($orderedByFilter) {
            $query->where('orderedBy', $orderedByFilter);
        }

        $deleteOrders = $query->get();
        $orderCount = $deleteOrders->count();
        $totalOrderedBy = OrderModel::where('isDeleted', false)->distinct('orderedBy')->count();
        $orderedBy = OrderModel::where('isDeleted', false)->distinct('orderedBy')->pluck('orderedBy');

        return view('orders.index', compact('deleteOrders', 'orderCount', 'totalOrderedBy', 'orderedBy', 'orderedByFilter'));
    }
    public function create()
    {
        $orders = $this->getOrder();
        return view('orders.create', compact('orders'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'orderedCar' => 'required|string|max:50',
            'orderedBy' => 'required|string|max:50',
            'address' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $sportsCar = SportsCarModel::where('sportsCarId', $request->orderedCar)->first();
        if (!$sportsCar) {
            return redirect()->back()->withErrors(['message' => 'SportsCar not found'])->withInput();
        }

        $user = UserModel::where('userId', $request->orderedBy)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['message' => 'User not found'])->withInput();
        }

        $data['orderedCar'] = $sportsCar->brand . ' ' . $sportsCar->model;
        $data['orderedBy'] = $user->firstName . ' ' . $user->lastName;
        $data['address'] = $user->address;
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
            Carbon::now()->toDateTimeString(),
        );

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }
    public function show($id)
    {
        $order = OrderModel::find($id);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        return view('orders.showById', compact('order'));
    }
    public function showAll()
    {
        $orders = OrderModel::where('isDeleted', false)->get();
        return view('orders.show', compact('orders'));
    }

    public function edit(string $orderId)
    {
        $order = OrderModel::find($orderId);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }
        return view('orders.edit', compact('order'));
    }
    public function update(Request $request, string $orderId)
    {
        $order = OrderModel::find($orderId);
        if (!$order) {
            return redirect()->back()->withErrors(['message' => 'Order not found'])->withInput();
        }

        $validate = Validator::make($request->all(), [
            'orderedCar' => 'required|string|max:50',
            'orderedBy' => 'required|string|max:50',
            'address' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $data = $request->all();

        if ($request->file('image')) {
            if ($order->getOrderedImage() !== 'default.jpg') {
                File::delete('images/' . $order->getOrderedImage());
            }
            $image = $request->file('image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }

        $sportsCar = SportsCarModel::where('sportsCarId', $request->orderedCar)->first();
        if (!$sportsCar) {
            return redirect()->back()->withErrors(['message' => 'SportsCar not found'])->withInput();
        }

        $user = UserModel::where('userId', $request->orderedBy)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['message' => 'User not found'])->withInput();
        }

        $data['orderedCar'] = $sportsCar->brand . ' ' . $sportsCar->model;
        $data['orderedBy'] = $user->firstName . ' ' . $user->lastName;
        $data['address'] = $user->address;
        $data['status'] = 'pending';

        $this->registerOrder->updateOrder(
            $orderId,
            $data['orderedCar'],
            $data['orderedBy'],
            $data['address'],
            $data['status'],
            $data['image'],
            Carbon::now()->toDateTimeString(),
        );

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }
    public function destroy($id)
    {
        $this->registerOrder->deleteOrder($id);
        return redirect()->route('orders.index')->with('archive', 'Order archived successfully');
    }
    public function archive(Request $request)
    {
        $orderedByFilter = $request->input('orderedBy');
        $query = OrderModel::where('isDeleted', true);

        if ($orderedByFilter) {
            $query->where('orderedBy', $orderedByFilter);
        }

        $deleteOrders = $query->get();
        $totalArchived = $deleteOrders->count();
        $totalOrderedBy = OrderModel::where('isDeleted', true)->distinct('orderedBy')->count();
        $orderedBy = OrderModel::where('isDeleted', true)->distinct('orderedBy')->pluck('orderedBy');

        return view('orders.archive', compact('deleteOrders', 'totalArchived', 'totalOrderedBy', 'orderedBy', 'orderedByFilter'));
    }
    public function restore($id)
    {
        $order = OrderModel::find($id);
        $order->isDeleted = false;
        $order->save();

        return redirect()->route('orders.archive')->with('restore', 'Order restored successfully');
    }
    public function permanentDelete($id)
    {
        $order = OrderModel::find($id);

        if ($order) {
            // Delete the image file if it's not the default image
            if ($order->image !== 'default.jpg') {
                File::delete(public_path('images/' . $order->image));
            }

            // Permanently delete the car record
            $order->delete();
        }

        return redirect()->route('orders.archive')->with('success', 'Order permanently deleted successfully');
    }
    public function updateStatus(Request $request, $id)
    {
        $order = OrderModel::find($id);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $validate = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,approved',
        ]);

        if ($validate->fails()) {
            return redirect()->route('orders.index')->with('error', 'Invalid status value');
        }

        // Update the order status directly on the model
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully');
    }
}
