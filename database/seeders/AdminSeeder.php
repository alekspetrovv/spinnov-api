<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_found = User::where('email', '=', 'admin@gmail.com')->first();
        if (empty($admin_found)) {
            $user = User::create(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => '$2y$10$QHoD951Xujw.1XIbrw0.s.Njh.0ZvFrhFrdK2gtIVD7LRzIXsjfTi']);
            $user->assignRole('Admin');
        }
    }
}
