<?php

namespace App\Http\Controllers\RentCar\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Infrastructure\Persistence\Eloquent\RentCar\RentCarModel;

class RentCarWebController extends Controller
{
    private function getPendingCount()
    {
        return RentCarModel::where('status', 'pending')->count();
    }

    public function index()
    {
        try {
            $rentals = RentCarModel::with(['sportsCar', 'user'])->get();
            $pendingCount = $this->getPendingCount();
            
            // Get statistics data
            $stats = [
                'total' => RentCarModel::count(),
                'pending' => RentCarModel::where('status', 'pending')->count(),
                'approved' => RentCarModel::where('status', 'approved')->count(),
                'completed' => RentCarModel::where('status', 'completed')->count(),
                'damaged' => RentCarModel::where('status', 'damaged')->count(),
                'totalRevenue' => RentCarModel::where('status', 'completed')->sum('rentPrice'),
                'damageCharges' => RentCarModel::whereNotNull('damageCharges')->sum('damageCharges')
            ];

            return view('rentals.index', compact('rentals', 'pendingCount', 'stats'));
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to load rentals: ' . $e->getMessage());
        }
    }

    public function pendingRentals()
    {
        $rentals = RentCarModel::where('status', 'pending')
            ->with(['sportsCar', 'user'])
            ->get();
        $pendingCount = $this->getPendingCount();
        return view('rentals.pending', compact('rentals', 'pendingCount'));
    }

    public function activeRentals()
    {
        $rentals = RentCarModel::where('status', 'approved')
            ->where('endDate', '>=', Carbon::now())
            ->with(['sportsCar', 'user'])
            ->get();
        $pendingCount = $this->getPendingCount();
        return view('rentals.active', compact('rentals', 'pendingCount'));
    }

    public function approveRental(string $rentId)
    {
        try {
            $rental = RentCarModel::findOrFail($rentId);
            $rental->update([
                'status' => 'approved',
                'updated_at' => Carbon::now()
            ]);
            
            return redirect()->route('rentals.index')
                ->with('success', 'Rental approved successfully');
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to approve rental: ' . $e->getMessage());
        }
    }

    public function rejectRental(string $rentId)
    {
        try {
            $rental = RentCarModel::findOrFail($rentId);
            $rental->update([
                'status' => 'rejected',
                'updated_at' => Carbon::now()
            ]);
            
            return redirect()->route('rentals.index')
                ->with('success', 'Rental rejected successfully');
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to reject rental: ' . $e->getMessage());
        }
    }

    public function processRentalDamage(Request $request, string $rentId)
    {
        try {
            $rental = RentCarModel::findOrFail($rentId);
            $damageCharges = $rental->carPrice * 0.25;

            $rental->update([
                'status' => 'damaged',
                'damageNotes' => $request->damageNotes,
                'damageCharges' => $damageCharges,
                'updated_at' => Carbon::now()
            ]);

            return redirect()->route('rentals.index')
                ->with('success', 'Damage report processed successfully');
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to process damage report: ' . $e->getMessage());
        }
    }

    public function statistics()
    {
        try {
            $stats = [
                'total' => RentCarModel::count(),
                'pending' => RentCarModel::where('status', 'pending')->count(),
                'approved' => RentCarModel::where('status', 'approved')->count(),
                'completed' => RentCarModel::where('status', 'completed')->count(),
                'damaged' => RentCarModel::where('status', 'damaged')->count(),
                'totalRevenue' => RentCarModel::where('status', 'completed')->sum('rentPrice'),
                'damageCharges' => RentCarModel::whereNotNull('damageCharges')->sum('damageCharges')
            ];
            $pendingCount = $this->getPendingCount();
            return view('rentals.statistics', compact('stats', 'pendingCount'));
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to load statistics: ' . $e->getMessage());
        }
    }

    public function rejectedRentals()
    {
        $rentals = RentCarModel::where('status', 'rejected')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('rentals.rejected', compact('rentals'));
    }

    public function completedRentals()
    {
        try {
            $rentals = RentCarModel::where('status', 'completed')
                ->with(['sportsCar', 'user'])
                ->orderBy('updated_at', 'desc')
                ->get();
            $pendingCount = $this->getPendingCount();
            return view('rentals.completed', compact('rentals', 'pendingCount'));
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to load completed rentals: ' . $e->getMessage());
        }
    }

    public function damagedRentals()
    {
        try {
            $rentals = RentCarModel::where('status', 'damaged')
                ->with(['sportsCar', 'user'])
                ->orderBy('updated_at', 'desc')
                ->get();
            $pendingCount = $this->getPendingCount();
            return view('rentals.damaged', compact('rentals', 'pendingCount'));
        } catch (\Exception $e) {
            return redirect()->route('rentals.index')
                ->with('error', 'Failed to load damaged rentals: ' . $e->getMessage());
        }
    }

    public function filterRentals($status)
    {
        try {
            $query = RentCarModel::with(['sportsCar', 'user']);
            
            if ($status !== 'all') {
                $query->where('status', $status);
            }
            
            $rentals = $query->get();
            
            return response()->json($rentals);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
