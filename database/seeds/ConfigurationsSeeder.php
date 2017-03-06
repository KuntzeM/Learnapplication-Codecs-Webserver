<?php

use Illuminate\Database\Seeder;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'name' => 'media_server',
            'value' => 'http://127.0.0.1:3000'
        ]);
        DB::table('configurations')->insert([
            'name' => 'api_key',
            'value' => '1234567890'
        ]);
        DB::table('configurations')->insert([
            'name' => 'api_expire',
            'value' => '60'
        ]);
        DB::table('configurations')->insert([
            'name' => 'impressum',
            'value' => ''
        ]);
        DB::table('configurations')->insert([
            'name' => 'welcome',
            'value' => ''
        ]);
    }
}
