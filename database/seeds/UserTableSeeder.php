<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'andi',
            'username' => 'andi123',
            'email' => 'andi@mail.com',
            'role_id' => 1,
            'active' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'budi',
            'username' => 'budi123',
            'email' => 'budi@mail.com',
            'role_id' => 2,
            'active' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'cici',
            'username' => 'cici123',
            'email' => 'cici@mail.com',
            'role_id' => 1,
            'active' => 0
        ]);
    }
}
