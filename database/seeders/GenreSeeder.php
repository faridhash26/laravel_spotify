<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genres;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                "name"  =>  "Country",
                "description" => "Country"
            ],
            [
                "name"  =>  "Hip-Hop/Rap",
                "description" => "Hip-Hop/Rap"
            ]
        ];
        foreach ($genres as $genresData) {
            Genres::create([
                'name' => $genresData['name'],
                'description' => $genresData['name'],
            ]);
        }
    }
}
// php artisan make:seeder GenreSeeder          =>==== creating the seed folder
//  php artisan db:seed --class=GenreSeeder       =>==== assinging the seed folder