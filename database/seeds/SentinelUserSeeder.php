<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SentinelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Sentinel::registerAndActivate([
            'username' => 'admin',
            'email'    => 'admin@admin.com',
            'password' => 'admin',
            'name' => 'Admin',
            'phone' => '123456',
        ]);

        $this->command->info('Users seeded!');

    }
}
