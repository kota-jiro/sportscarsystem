<?php

namespace App\Http\Controllers\SportsCar\Web;

use App\Http\Controllers\Controller;
use App\Application\SportsCar\RegisterSportsCar;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SportsCarWebController extends Controller
{
    private RegisterSportsCar $registerSportsCar;

    public function __construct(RegisterSportsCar $registerSportsCar)
    {
        $this->registerSportsCar = $registerSportsCar;
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
    public function getSportsCar()
    {
        $sportsCars = $this->registerSportsCar->findAll();
        if (empty($sportsCars)) {
            return [];
        }

        if (is_array($sportsCars)) {
            return $sportsCars;
        }

        return $sportsCars->toArray();
    }
    public function index(Request $request)
    {
        $brandFilter = $request->input('brand');
        $query = SportsCarModel::where('isDeleted', false);

        if ($brandFilter) {
            $query->where('brand', $brandFilter);
        }

        $sportsCars = $query->get();
        $sportsCarCount = $sportsCars->count();
        $totalBrands = SportsCarModel::where('isDeleted', false)->distinct('brand')->count();
        $brands = SportsCarModel::where('isDeleted', false)->distinct('brand')->pluck('brand');

        return view('sportsCars.index', compact('sportsCars', 'sportsCarCount', 'totalBrands', 'brands', 'brandFilter'));
    }
    public function create()
    {
        return view('sportsCars.create');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'brand' => 'required|string|max:25',
            'model' => 'required|string|max:25',
            'year' => 'required|digits:4|numeric|min:1900',
            'description' => 'required|string|max:255',
            'speed' => 'required|string|max:25',
            'drivetrain' => 'required|string|max:25',
            'price' => 'required|numeric',
            'image' => 'nullable',
        ], [
            'year' => 'The year must be exactly 4 digits.',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $sportsCarId = $this->generateUniqueSportsCarID();
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $imageName);

            $data['image'] = $imageName;
        } else {
            $data['image'] = 'default.jpg';
        }
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
        return redirect()->route('sportsCars.index')->with('success', 'SportsCar created successfully');
    }
    public function show($id)
    {
        $sportsCars = SportsCarModel::find($id);

        if (!$sportsCars) {
            return redirect()->route('sportsCars.index')->with('error', 'SportsCar not found');
        }

        return view('sportsCars.showById', compact('sportsCars'));
    }
    public function showAll()
    {
        $sportsCars = SportsCarModel::where('isDeleted', false)->get();
        return view('sportsCars.show', compact('sportsCars'));
    }
    public function edit($sportsCarId)
    {
        $sportsCar = SportsCarModel::find($sportsCarId);
        if (!$sportsCar) {
            return redirect()->route('sportsCars.index')->with('error', 'SportsCar not found');
        }
        return view('sportsCars.edit', compact('sportsCar'));
    }
    public function update(Request $request, $sportsCarId)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'brand' => 'required|string|max:25',
            'model' => 'required|string|max:25',
            'year' => 'required|digits:4|numeric|min:1900',
            'description' => 'required|string|max:255',
            'speed' => 'required|string|max:25',
            'drivetrain' => 'required|string|max:25',
            'price' => 'required|numeric',
            'image' => 'nullable',
        ], [
            'year' => 'The year must be exactly 4 digits and must be greater than 1900.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $sportsCar = $this->registerSportsCar->findBySportsCarId($sportsCarId);

        if (!$sportsCar) {
            return redirect()->route('sportsCars.index')->with('error', 'SportsCar not found');
        }

        if ($request->hasFile('image')) {
            if ($sportsCar->getImage() !== 'default.jpg') {
                File::delete('images/' . $sportsCar->getImage());
            }
            $image = $request->file('image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = $sportsCar->getImage();
        }

        $this->registerSportsCar->updateSportsCar(
            $sportsCarId,
            $request->brand,
            $request->model,
            $request->year,
            $request->description,
            $request->speed,
            $request->drivetrain,
            $request->price,
            $data['image'],
            Carbon::now()->toDateTimeString()
        );

        return redirect()->route('sportsCars.index')->with('success', 'SportsCar updated successfully');
    }
    public function destroy($id)
    {
        $this->registerSportsCar->deleteSportsCar($id);
        return redirect()->route('sportsCars.index')->with('archive', 'SportsCar archived successfully');
    }
    public function archive(Request $request)
    {
        $brandFilter = $request->input('brand');
        $query = SportsCarModel::where('isDeleted', true);

        if ($brandFilter) {
            $query->where('brand', $brandFilter);
        }

        $deletedSportsCars = $query->get();
        $totalArchived = $deletedSportsCars->count();
        $totalBrands = SportsCarModel::where('isDeleted', true)->distinct('brand')->count();
        $brands = SportsCarModel::where('isDeleted', true)->distinct('brand')->pluck('brand');

        return view('sportsCars.archive', compact('deletedSportsCars', 'totalArchived', 'totalBrands', 'brands', 'brandFilter'));
    }
    public function restore($id)
    {
        $car = SportsCarModel::find($id);
        $car->isDeleted = false;
        $car->save();

        return redirect()->route('sportsCars.archive')->with('restore', 'SportsCar restored successfully');
    }
    public function permanentDelete($id)
    {
        $car = SportsCarModel::find($id);

        if ($car) {
            // Delete the image file if it's not the default image
            if ($car->image !== 'default.jpg') {
                File::delete(public_path('images/' . $car->image));
            }

            // Permanently delete the car record
            $car->delete();
        }

        return redirect()->route('sportsCars.archive')->with('success', 'SportsCar permanently deleted successfully');
    }
}
