<?php

namespace Database\Seeders;

use App\Models\SportsCar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportsCarSeeder extends Seeder
{
    public function run(): void
    {   
        SportsCar::create([
            'make' => 'Ferrari',
            'model' => '488 GTB',
            'year' => 2015,
            'price' => 262000.00,
            'quantity' => 2,
            'image' => 'Ferrari_488_GTB.jpg'
        ]);

        SportsCar::create([
            'make' => 'Lamborghini',
            'model' => 'Huracan',
            'year' => 2014,
            'price' => 203000.00,
            'quantity' => 2,
            'image' => 'LAMBO_HURACAN.jpg'
        ]);

        SportsCar::create([
            'make' => 'Porsche',
            'model' => '911',
            'year' => 2015,
            'price' => 150000.00,
            'quantity' => 3,
            'image' => '2015_Porsche_911_Carrera_4S_Coupe.jpg'
        ]);
    }
}
