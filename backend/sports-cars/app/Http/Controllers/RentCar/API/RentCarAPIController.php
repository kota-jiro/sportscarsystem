<?php

namespace App\Http\Controllers\RentCar\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Infrastructure\Persistence\Eloquent\RentCar\RentCarModel;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;
class RentCarAPIController extends Controller
{
    private function generateUniqueRentID(): string
    {
        do {
            $rentId = substr(md5(uniqid(mt_rand(), true)), 0, 15);
        } while (RentCarModel::find($rentId));
        return $rentId;
    }

    public function calculateRentPrice($carPrice, $duration)
    {
        if ($carPrice <= 100000) {
            return [
                'day' => 2000,
                'week' => 12000,
                'month' => 30000
            ][$duration];
        } elseif ($carPrice <= 500000) {
            return [
                'day' => 12000,
                'week' => 50000,
                'month' => 120000
            ][$duration];
        } elseif ($carPrice <= 800000) {
            return [
                'day' => 23000,
                'week' => 155000,
                'month' => 380000
            ][$duration];
        } else {
            return [
                'day' => 30000,
                'week' => 180000,
                'month' => 480000
            ][$duration];
        }
    }

    public function createRentRequest(Request $request)
    {
        Log::info('Rent Request Received: ', $request->all());

        // Validate the incoming request
        $validate = Validator::make($request->all(), [
            'sportsCarId' => 'required|string',
            'userId' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'brandModel' => 'required|string',
            'carPrice' => 'required|numeric',
            'duration' => 'required|in:day,week,month',
            'startDate' => 'required|date|after:today',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        // Calculate rent price
        $rentPrice = $this->calculateRentPrice($request->carPrice, $request->duration);
        $endDate = Carbon::parse($request->startDate);

        // Determine end date based on duration
        switch($request->duration) {
            case 'day':
                $endDate->addDay();
                break;
            case 'week':
                $endDate->addWeek();
                break;
            case 'month':
                $endDate->addMonth();
                break;
        }

        // Generate a unique rent ID
        $rentId = $this->generateUniqueRentID();

        // Find the sports car by ID
        $sportsCar = SportsCarModel::where('sportsCarId', $request->sportsCarId)->first();

        if (!$sportsCar) {
            return response()->json(['message' => 'Sports car not found'], 404);
        }

        // Find the user by ID
        $user = UserModel::where('userId', $request->userId)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Create a new rent car record
        RentCarModel::create([
            'rentId' => $rentId,
            'sportsCarId' => $sportsCar->sportsCarId,
            'userId' => $user->userId,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'brandModel' => $request->brandModel,
            'carPrice' => $request->carPrice,
            'rentPrice' => $rentPrice,
            'rentDuration' => $request->duration,
            'startDate' => $request->startDate,
            'endDate' => $endDate,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Rent request created successfully',
            'rentPrice' => $rentPrice,
            'damageWarning' => 'Note: Any damage to the vehicle will incur a charge of 25% of the car\'s value.'
        ], 201);
    }

    public function getUserRentals(string $userId)
    {
        $rentals = RentCarModel::where('userId', $userId)->get();
        return response()->json(['rentals' => $rentals]);
    }

    public function approveRental(string $rentId)
    {
        $rental = RentCarModel::find($rentId);
        
        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        $rental->update(['status' => 'approved']);
        return response()->json(['message' => 'Rental approved successfully']);
    }

    public function completeRental(string $rentId)
    {
        $rental = RentCarModel::find($rentId);
        
        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        $rental->update(['status' => 'completed']);
        return response()->json(['message' => 'Rental marked as completed']);
    }

    public function reportDamage(Request $request, string $rentId)
    {
        $validate = Validator::make($request->all(), [
            'damageNotes' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $rental = RentCarModel::find($rentId);
        
        if (!$rental) {
            return response()->json(['message' => 'Rental not found'], 404);
        }

        $damageCharges = $rental->carPrice * 0.25;

        $rental->update([
            'damageNotes' => $request->damageNotes,
            'damageCharges' => $damageCharges,
            'status' => 'damaged'
        ]);

        return response()->json([
            'message' => 'Damage report submitted successfully',
            'damageCharges' => $damageCharges
        ]);
    }

    public function getAllRentals()
    {
        $rentals = RentCarModel::all();
        return response()->json(['rentals' => $rentals]);
    }

    public function getPendingRentals()
    {
        $rentals = RentCarModel::where('status', 'pending')->get();
        return response()->json(['rentals' => $rentals]);
    }

    public function getActiveRentals()
    {
        $rentals = RentCarModel::where('status', 'approved')
            ->where('endDate', '>=', Carbon::now())
            ->get();
        return response()->json(['rentals' => $rentals]);
    }
}
