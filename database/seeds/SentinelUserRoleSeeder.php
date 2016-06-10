<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->delete();

        $adminUser = Sentinel::findByCredentials(['login' => 'admin@admin.com']);
        $adminRole = Sentinel::findRoleBySlug('admin');
        $adminRole->users()->attach($adminUser);

        $userRole = Sentinel::findRoleBySlug('user');
        $userRole->users()->attach($adminUser);

        $this->command->info('Users assigned to roles seeded!');
    }
}
