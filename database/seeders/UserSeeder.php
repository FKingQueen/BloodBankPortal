<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => 'Super',
            'LastName' => 'Admin',
            'middleInitial' => 'A',
            'userType' => 'Admin',
            'birthDate' => '2023-05-19',
            'age' => '23',
            'address' => 'Amlan',
            'gender' => 'Male',
            'bloodType' => 'A+',
            'phoneNumber' => '09123456789',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
