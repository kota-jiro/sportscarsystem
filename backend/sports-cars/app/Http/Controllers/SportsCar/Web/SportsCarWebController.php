<?php

namespace App\Http\Controllers\SportsCar\Web;

use App\Application\SportsCar\RegisterSportsCar;
use App\Http\Controllers\Controller;
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
        if (!$sportsCars) {
            return null;
        }
        return array_map(
            fn($sportsCar) =>
            $sportsCar->toArray(),
            $sportsCars
        );
    }
    public function index()
    {
        $sportsCars = $this->getSportsCar();
        return view('sportsCars.index', compact('sportsCars'));
    }
    public function create()
    {
        return view('sportsCars.create');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'brand' => 'required|string',
            'model' => 'required|string',
            'description' => 'required|string',
            'speed' => 'required|string',
            'drivetrain' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable',
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
        $sportsCar = SportsCarModel::find($id);
        if (!$sportsCar) {
            return redirect()->back()->with('error', 'SportsCar not found');
        }

        return view('sportsCars.show', compact('showSportsCar'));
    }
    public function edit($id)
    {
        $sportsCar = SportsCarModel::find($id);
        return view('sportsCars.edit', compact('editSportsCar'));
    }
    public function update(Request $request, $sportsCarId)
    {
        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'ingredients' => 'required|string',
            'country' => 'required|string',
            'prep_time' => 'required|integer',
            'yt_link' => 'required|string',
            'image' => 'nullable',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $sportsCar = SportsCarModel::find($sportsCarId);
        if ($request->hasFile('image')) {
            if ($sportsCar->image !== 'default.jpg') {
                File::delete('images/' . $sportsCar->image);
            }
            $image = $request->file('image');
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = $sportsCar->image;
        }
        $this->registerSportsCar->updateSportsCar(
            $sportsCarId,
            $request->brand,
            $request->model,
            $request->description,
            $request->speed,
            $request->drivetrain,
            $request->price,
            $data['image'],
            Carbon::now()->toDateTimeString(),
        );

        return redirect()->route('sportsCars.index')->with('success', 'SportsCar updated successfully');

    }
    public function destroy($sportsCarId)
    {
        $this->registerSportsCar->deleteSportsCar($sportsCarId);
        return redirect()->route('sportsCars.index')->with('success', 'SportsCar deleted successfully');
    }
    public function archive()
    {
        $deletedSportsCars = $this->registerSportsCar->findDeletedSportsCar();
        return view('sportsCars.archive', compact('deletedSportsCars'));
    }
    public function restore($sportsCarId)
    {
        $this->registerSportsCar->restoreSportsCar($sportsCarId);
        return redirect()->route('archive')->with('success', 'SportsCar restored successfully');
    }
}
