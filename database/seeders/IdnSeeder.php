<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indentation;

class IdnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idns = [
            [
                'top' => 1,
                'bottom' => 1
            ]
        ];

        Indentation::truncate();
        Indentation::insert($idns);
    }
}
