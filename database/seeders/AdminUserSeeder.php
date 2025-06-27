<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->attach(1); // Attach admin role
    }
}
