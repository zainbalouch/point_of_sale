<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
           'first_name' =>  'Super',
           'last_name' =>  'Admin',
           'email' => 'super_admin@invoicesmanager.com',
           'password' => bcrypt('password')
        ]);

        $user->addRole('super_admin');
    }
}
