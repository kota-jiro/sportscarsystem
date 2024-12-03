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
            $sportsCar->year,
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
            $sportsCar->year,
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
            'year' => $sportsCar->getYear(),
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
            $existingSportsCar->update([
                'brand' => $sportsCar->getBrand(),
                'model' => $sportsCar->getModel(),
                'year' => $sportsCar->getYear(),
                'description' => $sportsCar->getDescription(),
                'speed' => $sportsCar->getSpeed(),
                'drivetrain' => $sportsCar->getDrivetrain(),
                'price' => $sportsCar->getPrice(),
                'image' => $sportsCar->getImage(),
                'updated_at' => $sportsCar->getUpdatedAt(),
            ]);
        }
    }
    public function deleteSportsCar(int $id): void {
        $sportsCarExist = SportsCarModel::find($id);
        $sportsCarExist->isDeleted = true;
        $sportsCarExist->save();
    }
    public function findDeletedSportsCar(): array {
        $sportsCar = SportsCarModel::where('isDeleted', true)->get();
        return [
            'sportsCar'=> $sportsCar,
        ];
    }
    public function restoreSportsCar(int $id): void {
        $sportsCarExist = SportsCarModel::find($id);
        $sportsCarExist->isDeleted = false;
        $sportsCarExist->save();
    }
    public function searchSportsCar(string $search): array {
        $exact_match = SportsCarModel::where('sportsCarId', $search)
        ->orWhere('brand', $search)
        ->orWhere('model', $search)
        ->orWhere('description', $search)
        ->orWhere('speed', $search)
        ->orWhere('drivetrain', $search)
        ->first();
        
        $related_match = SportsCarModel::where('sportsCarId', '!=', $exact_match->sportsCarId)->where(
            function ($query) use ($search) {
                $query->where('sportsCarId','LIKE',"%{$search}%")
                ->orWhere('brand','LIKE',"%{$search}%")
                ->orWhere('model','LIKE',"%{$search}%")
                ->orWhere('description','LIKE',"%{$search}%")
                ->orWhere('speed','LIKE',"%{$search}%")
                ->orWhere('drivetrain','LIKE',"%{$search}%");
            }
        )->get();

        return [
            'exact_match'=> $exact_match ? new SportsCar(
                $exact_match->id,
                $exact_match->sportsCarId,
                $exact_match->brand,
                $exact_match->model,
                $exact_match->year,
                $exact_match->description,
                $exact_match->speed,
                $exact_match->drivetrain,
                $exact_match->price,
                $exact_match->image,
                $exact_match->created_at,
                $exact_match->updated_at,
            ) : null,
            'related_match'=> $related_match->map(function ($sportsCar) {
                return new SportsCar(
                    $sportsCar->id,
                    $sportsCar->sportsCarId,
                    $sportsCar->brand,
                    $sportsCar->model,
                    $sportsCar->year,
                    $sportsCar->description,
                    $sportsCar->speed,
                    $sportsCar->drivetrain,
                    $sportsCar->price,
                    $sportsCar->image,
                    $sportsCar->created_at,
                    $sportsCar->updated_at,
                );
            })->toArray()
        ];
    }
}