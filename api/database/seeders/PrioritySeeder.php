<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $priorities = ['Low', 'High', 'Severe'];

        foreach ($priorities as $index => $priority) {
            $priority = Priority::create([
                'name' => $priority,
                'isActive' => true
            ]);
        }
    }
}
