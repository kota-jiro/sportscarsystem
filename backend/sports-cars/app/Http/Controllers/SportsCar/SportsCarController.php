<?php

namespace App\Http\Controllers\SportsCar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SportsCar;

class SportsCarController extends Controller
{
    /**
     * Display a listing of the sports cars.
     */
    public function index()
    {
        $sportscars = SportsCar::all();
        return view('sportscars.index', compact('sportscars'));
    }

    /**
     * Show the form for creating a new sports car.
     */
    public function create()
    {
        return view('sportscars.create');
    }

    /**
     * Store a newly created sports car in storage.
     */
    public function store(Request $request)
{
    // Validate the form data
    $validated = $request->validate([
        'make' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for the image
    ]);

    // Handle the image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName); // Move the image to the 'public/images' directory
    } else {
        $imageName = 'default.jpg'; // Set a default image if no image is uploaded
    }

    // Create a new sports car
    SportsCar::create([
        'make' => $request->make,
        'model' => $request->model,
        'year' => $request->year,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'image' => $imageName, // Save the image name in the database
    ]);

    return redirect()->route('sportscars.index')->with('success', 'Sports Car added successfully!');
}

    /**
     * Display the specified sports car.
     */
    public function show($id)
    {
        $car = SportsCar::findOrFail($id);
        return view('sportscars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified sports car.
     */
    public function edit($id)
    {
        $car = SportsCar::findOrFail($id);
        return view('sportscars.edit', compact('car'));
    }

    /**
     * Update the specified sports car in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $car = SportsCar::findOrFail($id);
        
        // Update Image if a new one is uploaded
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/cars/'), $imageName);
            $car->image = $imageName;
        }

        // Update Other Fields
        $car->update([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $car->image
        ]);

        return redirect()->route('sportscars.index')->with('success', 'Sports Car updated successfully.');
    }

    /**
     * Remove the specified sports car from storage.
     */
    public function destroy($id)
    {
        $sportscar = SportsCar::find($id);

        if (!$sportscar) {
            return redirect()->route('sportscars.index')->with('error', 'Car not found.');
        }

        // Delete the associated image file if it exists
        $imagePath = public_path('images/cars/' . $sportscar->image);
        if (file_exists($imagePath)) {
            @unlink($imagePath);  // Use @unlink to suppress warnings if file is not found
        }

        // Delete the car from the database
        $sportscar->delete();

        return redirect()->route('sportscars.index')->with('success', 'Sports Car deleted successfully!');
    }
}


