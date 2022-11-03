<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Sample\SampleAuthorSeeder;
use Database\Seeders\Sample\SampleBookSeeder;
use Database\Seeders\Sample\SamplePublisherSeeder;
use Illuminate\Database\Seeder;

class SampleDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SampleAuthorSeeder::class,
            SamplePublisherSeeder::class,
            SampleBookSeeder::class,
        ]);
    }
}
