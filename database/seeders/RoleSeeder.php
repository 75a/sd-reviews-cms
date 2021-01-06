<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrNew([
            'name' => env('ROLE_NAME_ADMIN')
        ])->save();
        Role::firstOrNew([
            'name' => env('ROLE_NAME_PUBLISHER')
        ])->save();
        Role::firstOrNew([
            'name' => env('ROLE_NAME_BASIC')
        ])->save();
        Role::firstOrNew([
            'name' => env('ROLE_NAME_UNVERIFIED')
        ])->save();
    }
}
