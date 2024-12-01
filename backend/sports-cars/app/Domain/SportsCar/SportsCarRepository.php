<?php

namespace App\Domain\SportsCar;

interface SportsCarRepository
{
    public function findAll(): array;
    public function findById(int $id): ?SportsCar;
    public function findBySportsCarId(string $sportsCarId): ?SportsCar;
    public function createSportsCar(SportsCar $sportsCar): void;
    public function updateSportsCar(SportsCar $sportsCar): void;
    public function deleteSportsCar(int $id): void;
    public function findDeletedSportsCar(): array;
    public function restoreSportsCar(int $id): void;
    public function searchSportsCar(string $search): array;

}