<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email'      => 'mathias.kuntze@tu-ilmenau.de',
            'password' => Hash::make('admin'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}
