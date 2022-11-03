<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function fake;

class BaseSeeder extends Seeder
{
    protected function generateUniqueColumnValue(string $tableName, string $fieldName, int $maxWords = 10): string
    {
        do {
            $name = implode(' ',fake()->unique(true)->words(rand(3, $maxWords)));
        } while (DB::table($tableName)->where($fieldName, $name)->first());
        return $name;
    }
}
