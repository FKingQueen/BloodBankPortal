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
            'firstName' => 'Patrick',
            'LastName' => 'Borja',
            'middleInitial' => 'C',
            'userType' => 'Admin',
            'age' => '23',
            'address' => 'Amlan (Ayuquitan)',
            'gender' => 'Male',
            'bloodType' => 'A+',
            'phoneNumber' => '09053102687',
            'email' => 'p@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'firstName' => 'Hisiah',
            'LastName' => 'Nidoy',
            'middleInitial' => 'B',
            'userType' => 'User',
            'age' => '23',
            'address' => 'Amlan (Ayuquitan)',
            'gender' => 'Female',
            'bloodType' => 'A+',
            'phoneNumber' => '09053102687',
            'email' => 'h@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
