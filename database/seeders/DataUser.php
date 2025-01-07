<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class DataUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'guru',
                'email' => 'guru@gmail.com',
                'password' => bcrypt('testing'),
                'role' => 'teacher',
            ],
            [
                'name' => 'siswa',
                'email' => 'siswa@gmail.com',
                'password' => bcrypt('testing'),
                'role' => 'student',
            ]
        ]);
        
    }
}
