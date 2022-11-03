<?php

namespace Database\Seeders\Sample;

use App\Models\Publisher;
use Database\Seeders\BaseSeeder;

class SamplePublisherSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample 100.000 unique publishers
        $totalPublisher = 100000;
        for ($i = 0; $i < $totalPublisher; $i++) {
            Publisher::factory()->create([
                'name' => $this->generateUniqueColumnValue('publishers', 'name', 10)
            ]);
        }
    }
}
