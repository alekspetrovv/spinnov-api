<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('name', '=', 'Admin')->first();
        $user_role = Role::where('name', '=', 'User')->first();
        if (empty($admin_role)) {
            Role::create(['name' => 'Admin']);
        }
        if (empty($user_role)) {
            Role::create(['name' => 'User']);
        }
    }
}
