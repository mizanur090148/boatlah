<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Owner',
            'slug' => 'owner',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Coordinator',
            'slug' => 'coordinator',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Captain',
            'slug' => 'captain',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'User',
            'slug' => 'user',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Shipping Agency',
            'slug' => 'company',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'CSR',
            'slug' => 'csr',
        ]);
        Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Walking User',
            'slug' => 'walkingUser',
        ]);

        $this->command->info('Roles seeded!');
    }
}
