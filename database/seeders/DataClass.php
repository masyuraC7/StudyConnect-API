<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataClass extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->insert([
            [
                'name' => 'Class 1',
                'subject' => 'Math',
                'teacher_id' => 1,
                'description' => 'Class 1 Description',
                'code' => 'abcdef',
                'created_at' => now(),
                'updated_at' => now()
            ]
            ]);
    }
}
