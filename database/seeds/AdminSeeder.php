<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Админ',
            'last_name' => 'Админов',
            'phone_number' => '+1 234567890',
            'verified' => 1,
            'phone_number_verified_at' => Carbon::now(),
            'email' => 'admin@admin.com',
            'role' => User::ROLE_ADMIN,
            'password' => Hash::make('password'),
        ]);
    }
}
