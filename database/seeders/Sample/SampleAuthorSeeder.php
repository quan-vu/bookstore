<?php

namespace Database\Seeders\Sample;

use App\Models\Author;
use Database\Seeders\BaseSeeder;

class SampleAuthorSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample 100.000 unique authors
        $totalAuthor = 100000;
        for ($i = 0; $i < $totalAuthor; $i++) {
            Author::factory()->create([
                'name' => $this->generateUniqueColumnValue('authors', 'name', 5)
            ]);
        }
    }
}
