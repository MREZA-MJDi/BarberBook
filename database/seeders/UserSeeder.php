<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('slug', 'super_admin')->first();
        $barberRole = Role::where('slug', 'barber')->first();

        User::create([
            'role_id'  => $superAdminRole->id,
            'full_name'      => 'Super Admin',
            'phone'     => '09000000000',
            'email'     => 'admin@barberbook.test',
            'password'  => Hash::make('password'),
        ]);

        User::create([
            'role_id'  => $barberRole->id,
            'full_name'      => 'علی مجیدی',
            'phone'     => '09121234567',
            'email'     => 'ali@barberbook.test',
            'password'  => Hash::make('password'),
        ]);
    }
}
