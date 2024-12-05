<?php

namespace App\Http\Controllers\SportsCar\API;

use App\Application\SportsCar\RegisterSportsCar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SportsCarAPIController extends Controller
{
    private RegisterSportsCar $registerSportsCar;

    public function __construct(RegisterSportsCar $registerSportsCar)
    {
        $this->registerSportsCar = $registerSportsCar;
    }
    /**
     * get all sports cars
     */
    public function getAll(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $sportsCarModels = $this->registerSportsCar->findAll();
            if (empty($sportsCarModels)) {
                return response()->json(['message' => "No SportsCars found."], 404);
            }
            $sportsCars = array_map(function($sportsCarModel) {
                if (is_object($sportsCarModel) && method_exists($sportsCarModel, 'toArray')) {
                    return $sportsCarModel->toArray();
                }
                return $sportsCarModel; // or handle the error as needed
            }, $sportsCarModels);
            return response()->json(compact('sportsCars'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * get sports car by id
     */
    public function getBySportsCarId(string $sportsCarId)
    {
        $sportsCarModel = $this->registerSportsCar->findBySportsCarId($sportsCarId);
        if (!$sportsCarModel) {
            return response()->json(['message' => 'SportsCar not found', 'id' => $sportsCarId], 404);
        }
        $sportsCar = $sportsCarModel->toArray();
        return response()->json(compact('sportsCar'), 200);
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
    private function generateUniqueSportsCarID(): string
    {
        do {
            $sportsCarId = $this->generateRandomAlphanumericID(15);
        } while ($this->registerSportsCar->findBySportsCarID($sportsCarId));
        return $sportsCarId;
    }
    /**
     * get sports car by brand
     */
    public function getByBrand(string $brand, Request $request){
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        } try {
            $sportsCarModels = $this->registerSportsCar->findByBrand($brand);
            if (empty($sportsCarModels)) {
                return response()->json(['message' => "No SportsCars brand found."], 404);
            }
            $sportsCars = array_map(function($sportsCarModel) {
                if (is_object($sportsCarModel) && method_exists($sportsCarModel, 'toArray')) {
                    return $sportsCarModel->toArray();
                }
                return $sportsCarModel;
            }, $sportsCarModels);
            return response()->json(compact('sportsCars'), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * add a sports car
     */
    public function addSportsCar(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'brand' => 'required|string|max:25',
            'model' => 'required|string|max:25',
            'year' => 'required|digits:4|numeric|min:1900|max:2024',
            'description' => 'required|string|max:255',
            'speed' => 'required|string|max:25',
            'drivetrain' => 'required|string|max:25',
            'price' => 'required|numeric',
            'image' => 'nullable',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        $sportsCarId = $this->generateUniqueSportsCarID();
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
        // Create the sports car on database.
        $this->registerSportsCar->createSportsCar(
            $sportsCarId,
            $request->brand,
            $request->model,
            $request->year,
            $request->description,
            $request->speed,
            $request->drivetrain,
            $request->price,
            $data['image'],
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString(),
        );
        return response()->json(['message' => 'SportsCar created successfully'], 201);
    }
    /**
     * update a sports car 
     */
    public function updateSportsCar(Request $request, $sportsCarId)
    {
        $sportsCar = $this->registerSportsCar->findBySportsCarID($sportsCarId);
        if (!$sportsCar) {
            return response()->json(['message' => 'SportsCar not found', 'id' => $sportsCarId], 404);
        }
        $validate = Validator::make($request->all(), [
            'brand' => 'required|string|max:25',
            'model' => 'required|string|max:25',
            'year' => 'required|digits:4|numeric|min:1900|max:2024',
            'description' => 'required|string|max:255',
            'speed' => 'required|string|max:25',
            'drivetrain' => 'required|string|max:25',
            'price' => 'required|numeric',
            'image' => 'nullable',
        ]);
        $data = $request->all();
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        // Handle image upload if provided
        if ($request->file('image')) {
            // Delete old image if it's not the default image
            if ($sportsCar->getImage() !== 'default.jpg') {
                File::delete('images/' . $sportsCar->getImage());
            }
            $image = $request->file('image');
            $destinationPath = 'images';
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        } else {
            if ($sportsCar->getImage() === null) {
                $data['image'] = 'default.jpg';
            } else {
                $data['image'] = $sportsCar->getImage();
            }
        }
        $this->registerSportsCar->updateSportsCar(
            $sportsCarId,
            $data['brand'],
            $data['model'],
            $data['year'],
            $data['description'],
            $data['speed'],
            $data['drivetrain'],
            $data['price'],
            $data['image'],
            Carbon::now()->toDateTimeString(),
        );
        return response()->json(['message' => 'SportsCar updated successfully'], 200);
    }
    /**
     * search a sports car
     */
    public function searchSportsCar(Request $request)
    {
        $search = $request->input('searched');
        if (!$search) {
            return null;
        }
        $result = $this->registerSportsCar->searchSportsCar($search);
        if (is_null($result['exact_match'] && empty($result['related_match']))) {
            return response()->json(['message' => 'No data found.'], 404);
        }
        return response()->json(compact('result'));
    }
}
