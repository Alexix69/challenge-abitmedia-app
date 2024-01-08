<?php

namespace Database\Seeders;

use App\Models\OperatingSystem;
use Illuminate\Database\Seeder;

class OperatingSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperatingSystem::truncate();

        $os = ['Windows', 'Mac', 'Linux'];
        for ($i = 0; $i < count($os); $i++) {
            OperatingSystem::create([
                'name' => $os[$i]
            ]);
        }
    }
}
