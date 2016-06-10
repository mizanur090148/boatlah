<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BaseAnchorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('base_anchorages')->delete();

        DB::table('base_anchorages')->insert([
            'fullname' => 'MSP',
            'title' => 'MSP',
            'type' => 'Eastern',
            'latitude' => '1.35208301',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Changi Barge Temporary Holding Anchorage',
            'title' => 'ACBTH',
            'type' => 'Eastern',
            'latitude' => '1.35208301',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Changi General Purposes Anchorage',
            'title' => 'ACGP',
            'type' => 'Eastern',
            'latitude' => '1.331944',
            'longitude' => '104.058333',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Man-of-War Anchorage',
            'title' => 'AMOW',
            'type' => 'Eastern',
            'latitude' => '1.278889',
            'longitude' => '103.908611',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Bunkering A Anchorage',
            'title' => 'AEBA',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Bunkering B Anchorage',
            'title' => 'AEBB',
            'type' => 'Eastern',
            'latitude' => '1.35208301',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Petroleum C Anchorage',
             'title' => 'AEPBC',
            'type' => 'Eastern',
            'latitude' => '1.290833',
            'longitude' => '103.950833',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Small Craft  B Anchorage',
            'title' => 'ASCB',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Small Craft  A Anchorage',
            'title' => 'ASCA',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Petroleum B Anchorage',
            'title' => 'AEPBB',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Special Purposes Anchorage A',
            'title' => 'AESPA',
            'type' => 'Eastern',
            'latitude' => '1.281111',
            'longitude' => '103.950556',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Bunkering C Anchorage',
            'title' => 'AEBC',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Holding A Anchorage',
            'title' => 'AEHA',
            'type' => 'Eastern',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Petroleum A Anchorage',
            'title' => 'AEPA',
            'type' => 'Eastern',
            'latitude' => '1.258333',
            'longitude' => '103.923889',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Anchorage',
            'title' => 'AEW',
            'type' => 'Eastern',
            'latitude' => '1.3441750',
            'longitude' => '103.8995270',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Holding B Anchorage',
            'title' => 'AEHB',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Eastern Holding C Anchorage',
            'title' => 'AEHC',
            'type' => 'Eastern',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'WCP',
            'title' => 'WCP',
            'type' => 'Western',
            'latitude' => '1.218333',
            'longitude' => '103.823611',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Western Quarantine and Immigration Anchorage',
            'title' => 'AWQI',
            'type' => 'Western',
            'latitude' => '1.218333',
            'longitude' => '103.823611',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Western Anchorage',
            'title' => 'AWW',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Western Petroleum A Anchorage',
            'title' => 'AWPA',
            'type' => 'Western',
            'latitude' => '1.241667',
            'longitude' => '103.796667',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Western Holding Anchorage',
            'title' => 'AWH',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Western Petroleum B Anchorage',
            'title' => 'AWPB',
            'type' => 'Western',
            'latitude' => '1.241111',
            'longitude' => '103.784722',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Raffles Reserved Anchorage',
            'title' => 'ARAFR',
            'type' => 'Western',
            'latitude' => '1.2948829',
            'longitude' => '103.8544791',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Raffles Petroleum  Anchorage',
            'title' => 'ARP',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Selat Pauh Anchorage',
            'title' => 'ASPLU',
            'type' => 'Western',
            'latitude' => '1.2175',
            'longitude' => '103.738333',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Selat Pauh Petroleum  Anchorage',
            'title' => 'ASPP',
            'type' => 'Western',
            'latitude' => '1.273673',
            'longitude' => '103.801381',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Petroleum  Holding Anchorage',
            'title' => 'ASPH',
            'type' => 'Western',
            'latitude' => '1.352083',
            'longitude' => '103.819836',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Bunkering Anchorage B',
            'title' => 'ASUBB',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Explosive  Anchorage',
            'title' => 'ASUEX',
            'type' => 'Western',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Special Purpose  Anchorage',
            'title' => 'ASSPU',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Bunkering Anchorage A',
            'title' => 'ASUBA',
            'type' => 'Western',
            'latitude' => '1.3520830',
            'longitude' => '103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Sudong  Holding  Anchorage',
            'title' => 'ASH',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'Very Large Crude Carrier Anchorage',
            'title' => 'AVLCC',
            'type' => 'Western',
            'latitude' => '1.3354102',
            'longitude' => '103.7579142',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'LNG/LPG/Chemical Gas Carriers Anchorage',
            'title' => 'ALGAS',
            'type' => 'Western',
            'latitude' => '1.3520830',
            'longitude' => ' 103.8198360',
        ]);

        DB::table('base_anchorages')->insert([
            'fullname' => 'West Jurong Anchorage',
            'title' => 'AWJ',
            'type' => 'Western',
            'latitude' => '1.269722',
            'longitude' => '103.635833',
        ]);

        $this->command->info('Anchorages seeded!');
    }
}
