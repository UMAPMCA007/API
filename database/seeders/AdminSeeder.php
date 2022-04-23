<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin seeder
        $user = new User([
            'name' => 'Admin',
            'email' => 'midhunchacko@gmail.com',
            'password' => bcrypt('admin'),
            'IsAdmin' => '1',
        ]);
        $user->save();
    }
}
