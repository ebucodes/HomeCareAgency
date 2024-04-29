<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statuses = ['Pending', 'Resolved', 'Rejected'];

        foreach ($statuses as $index => $status) {
            $status = Status::create([
                'name' => $status,
                'isActive' => true
            ]);
        }
    }
}
