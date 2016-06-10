<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        Model::unguard();

        $this->call(SentinelRoleSeeder::class);
        $this->call(SentinelUserSeeder::class);
        $this->call(SentinelUserRoleSeeder::class);
        $this->call(BaseAnchorageTableSeeder::class);
        $this->call(AdminTableSeeder::class);

        $this->command->info('All tables seeded!');

        Model::reguard();
    }
}
