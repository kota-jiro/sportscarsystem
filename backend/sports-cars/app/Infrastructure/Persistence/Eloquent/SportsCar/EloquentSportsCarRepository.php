<?php

namespace App\Infrastructure\Persistence\Eloquent\SportsCar;

use App\Domain\SportsCar\SportsCarRepository;
use App\Domain\SportsCar\SportsCar;

class EloquentSportsCarRepository implements SportsCarRepository {
    public function findAll(): array {
        return SportsCarModel::all()->toArray();
    }
    public function findById(int $id): ?SportsCar {
        $sportsCar = SportsCarModel::find($id);
        if (! $sportsCar) {
            return null;
        }
        return new SportsCar(
            $sportsCar->id,
            $sportsCar->sportsCarId,
            $sportsCar->brand,
            $sportsCar->model,
            $sportsCar->description,
            $sportsCar->speed,
            $sportsCar->drivetrain,
            $sportsCar->price,
            $sportsCar->image,
            $sportsCar->created_at,
            $sportsCar->updated_at,
        );
    }
    public function findBySportsCarId(string $sportsCarId): ?SportsCar {
        $sportsCar = SportsCarModel::where('sportsCarId', $sportsCarId)->first();
        if (! $sportsCar) {
            return null;
        }
        return new SportsCar(
            $sportsCar->id,
            $sportsCar->sportsCarId,
            $sportsCar->brand,
            $sportsCar->model,
            $sportsCar->description,
            $sportsCar->speed,
            $sportsCar->drivetrain,
            $sportsCar->price,
            $sportsCar->image,
            $sportsCar->created_at,
            $sportsCar->updated_at,
        );
    }
    public function createSportsCar(SportsCar $sportsCar): void {
        $sportsCarModel = SportsCarModel::find($sportsCar->getId()) ?? new SportsCarModel();
        $sportsCarModel->fill([
            'id' => $sportsCar->getId(),
            'sportsCarId' => $sportsCar->getSportsCarId(),
            'brand' => $sportsCar->getBrand(),
            'model' => $sportsCar->getModel(),
            'description' => $sportsCar->getDescription(),
            'speed' => $sportsCar->getSpeed(),
            'drivetrain' => $sportsCar->getDrivetrain(),
            'price' => $sportsCar->getPrice(),
            'image' => $sportsCar->getImage(),
            'created_at' => $sportsCar->getCreatedAt(),
            'updated_at' => $sportsCar->getUpdatedAt(),
        ]);
        $sportsCarModel->save();
    }
    public function updateSportsCar(SportsCar $sportsCar): void {
        $existingSportsCar = SportsCarModel::where('sportsCarId', $sportsCar->getSportsCarId())->first();
        if ($existingSportsCar) {
            $existingSportsCar->brand = $sportsCar->getBrand();
            $existingSportsCar->model = $sportsCar->getModel();
            $existingSportsCar->description = $sportsCar->getDescription();
            $existingSportsCar->speed = $sportsCar->getSpeed();
            $existingSportsCar->drivetrain = $sportsCar->getDrivetrain();
            $existingSportsCar->price = $sportsCar->getPrice();
            $existingSportsCar->image = $sportsCar->getImage();
            $existingSportsCar->updated_at = $sportsCar->getUpdatedAt();
            $existingSportsCar->save();
        }
        else {
            $existingSportsCar->id = $sportsCar->getId();
            $existingSportsCar->sportsCarId = $sportsCar->getSportsCarId();
            $existingSportsCar->brand = $sportsCar->getBrand();
            $existingSportsCar->model = $sportsCar->getModel();
            $existingSportsCar->description = $sportsCar->getDescription();
            $existingSportsCar->speed = $sportsCar->getSpeed();
            $existingSportsCar->drivetrain = $sportsCar->getDrivetrain();
            $existingSportsCar->price = $sportsCar->getPrice();
            $existingSportsCar->image = $sportsCar->getImage();
            $existingSportsCar->updated_at = $sportsCar->getUpdatedAt();
            $existingSportsCar->save();
        }
    }
    public function deleteSportsCar(int $id): void {
        $sportsCarModel = SportsCarModel::find($id)->delete();
    }
    public function searchSportsCar(string $search): array {

    }
}