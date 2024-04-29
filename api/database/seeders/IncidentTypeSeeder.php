<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = ['Trauma', 'Accident'];

        foreach ($types as $index => $type) {
            $type = IncidentType::create([
                'name' => $type,
                'isActive' => true
            ]);
        }
    }
}
