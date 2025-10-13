<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => __('administrator'),
            'description' => 'Administrator with full access',
        ]);

        Role::factory()->create([
            'name' => __('farmer'),
            'description' => 'Farmer with limited access',
        ]);
    }
}
