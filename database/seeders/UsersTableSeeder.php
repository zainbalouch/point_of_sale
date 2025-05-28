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
           'company_id' => 1,
           'point_of_sale_id' => 1,
           'first_name' =>  'Super',
           'last_name' =>  'Admin',
           'email' => 'admin@gmail.com',
           'password' => bcrypt('12345678')
        ]);

        $user->assignRole('super_admin');
    }
}
