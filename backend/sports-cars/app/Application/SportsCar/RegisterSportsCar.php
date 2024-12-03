<?php

namespace App\Application\SportsCar;

use App\Domain\SportsCar\SportsCar;
use App\Domain\SportsCar\SportsCarRepository;

class RegisterSportsCar
{
    private SportsCarRepository $sportsCarRepository;

    public function __construct(SportsCarRepository $sportsCarRepository)
    {
        $this->sportsCarRepository = $sportsCarRepository;
    }
    public function findAll(){
        return $this->sportsCarRepository->findAll();
    }
    public function findById(int $id){
        return $this->sportsCarRepository->findById($id);
    }
    public function findBySportsCarId(string $sportsCarId){
        return $this->sportsCarRepository->findBySportsCarId($sportsCarId);
    }
    public function createSportsCar(
        string $sportsCarId,
        string $brand,
        string $model,
        int $year,
        string $description,
        string $speed,
        string $drivetrain,
        float $price,
        string $image,
        string $created_at,
        string  $updated_at,
    ) {
        $data = new SportsCar(
            null,
            $sportsCarId,
            $brand,
            $model,
            $year,
            $description,
            $speed,
            $drivetrain,
            $price,
            $image,
            $created_at,
            $updated_at,
        );
        $this->sportsCarRepository->createSportsCar($data);   
    }
    public function  updateSportsCar(
        string $sportsCarId,
        string $brand,
        string $model,
        int $year,
        string $description,
        string $speed,
        string $drivetrain,
        float $price,
        string $image,
        string $updated_at,
    ){
        $validate = $this->sportsCarRepository->findBySportsCarId($sportsCarId);

        if(!$validate){
            throw new \Exception("Sports Car not found");
        }

        $updateSportsCar = new SportsCar(
            null,
            $sportsCarId,
            $brand,
            $model,
            $year,
            $description,
            $speed,
            $drivetrain,
            $price,
            $image,
            null,
            $updated_at,
        );
        $this->sportsCarRepository->updateSportsCar($updateSportsCar);
    }
    public function deleteSportsCar(int $id){
        $this->sportsCarRepository->deleteSportsCar($id);
    }
    public function findDeletedSportsCar(){
        return $this->sportsCarRepository->findDeletedSportsCar();
    }
    public function restoreSportsCar(int $id){
        $this->sportsCarRepository->restoreSportsCar($id);
    }
    public function searchSportsCar(string $search){
        $results = $this->sportsCarRepository->searchSportsCar($search);
        
        return [
            'exact_match'=> $results['exact_match'] ? $results['exact_match']->toArray() : null,
            'related_match'=> array_map(function($sportsCar){
                return $sportsCar->toArray();
            }, $results['related_match'] ?? [])
        ];
    }
}