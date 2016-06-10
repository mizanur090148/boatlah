<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            'user_id'=>1
        ]);


        DB::table('boat_user_profiles')->delete();

        DB::table('boat_user_profiles')->insert([
            'user_id'=>1
        ]);

        $this->command->info('Admins seeded as admin and boat user!');
    }
}
