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
            'value' => '127.0.0.1'
        ]);
        DB::table('configurations')->insert([
            'name' => 'api_key',
            'value' => '1234567890'
        ]);
    }
}
