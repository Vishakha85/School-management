<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    public function run()
    {
        // Example data to insert
        $classes = [
            ['id' => 1, 'class' => 'B.Tech'],
            ['id' => 2, 'class' => 'M.Tech'],
            ['id' => 3, 'class' => 'PhD'],
            ['id' => 4, 'class' => 'MCA'],
            ['id' => 5, 'class' => 'BCA'],
            ['id' => 6, 'class' => 'BCOM'],

        ];

        DB::table('classes')->insert($classes);
    }
}
