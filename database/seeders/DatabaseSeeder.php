<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Create Admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@apotek.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // Create Apoteker user
        $apoteker = User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@apotek.com',
            'password' => Hash::make('password'),
        ]);
        $apoteker->assignRole('Apoteker');

        // Create Kasir user
        $kasir = User::create([
            'name' => 'Kasir',
            'email' => 'kasir@apotek.com',
            'password' => Hash::make('password'),
        ]);
        $kasir->assignRole('Kasir');

        $this->call(MasterDataSeeder::class);
    }
}
