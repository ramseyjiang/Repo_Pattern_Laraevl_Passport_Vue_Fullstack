<?php

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
        factory(\Rspafs\Models\User::class)->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@qq.com',
            'password' => '12345678'
        ]);
    }
}
