<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\wikuliner;

class WikulinerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wikuliners = [
            [
                'id_user' => null,
                'name' => "Seblak Dower Serdang Baru",
                'rating' => "5",
                'imageUrl' => "gambar/dower.jpg",
            ],
            [
                'id_user' => null,
                'name' => "Mall of Indonesia",
                'rating' => "4.5",
                'imageUrl' => "gambar/mall.jpg",
            ],
        ];
        foreach ($wikuliners as $value) {
            wikuliner::create($value);
        }
    }
}
