<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'role'=>1,
                'first_name' => 'henish',
                'last_name' => 'patel',
                'email' =>'admin@gmail.com',
                'password' => Hash::make('Henish_12'),
                'phone' => '9979732688',
                'dob'=> Carbon::createFromDate(2014,07,22)->toDateTimeString(),
                'gender' => 0,
            ],
            [
                'role'=>2,
                'first_name' => 'Komal',
                'last_name' => 'Chhipa',
                'email' =>'komal@gmail.com',
                'password' => Hash::make('Komal_13'),
                'phone' => '9979732688',
                'dob'=> Carbon::createFromDate(2014,07,22)->toDateTimeString(),
                'gender' => 0,
            ],
            [
                'role'=>2,
                'first_name' => 'Alita',
                'last_name' => 'alita',
                'email' =>'alita@gmail.com',
                'password' => Hash::make('Alita_13'),
                'phone' => '9979732688',
                'dob'=> Carbon::createFromDate(2014,07,22)->toDateTimeString(),
                'gender' => 0,
            ],
        ]);
    }
}